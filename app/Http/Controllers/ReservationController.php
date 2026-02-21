<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    private function isAdmin(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    private function ensureOwnerOrAdmin(Reservation $reservation): void
    {
        if ($this->isAdmin()) return;

        abort_unless($reservation->user_id === auth()->id(), 403);
    }

    public function index()
    {
        $query = Reservation::with('vehicle')->latest();

        // ✅ Client : seulement ses réservations
        if (!$this->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        $reservations = $query->paginate(10);

        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        // ✅ liste véhicules (tu peux filtrer selon statut si tu veux)
        $vehicles = Vehicle::orderBy('marque')->orderBy('modele')->get();

        return view('reservations.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'date_debut' => 'required|date',
            'date_fin'   => 'required|date|after_or_equal:date_debut',
        ]);

        // ✅ blocage conflit (chevauchement)
        $overlap = Reservation::where('vehicle_id', $data['vehicle_id'])
            ->whereIn('statut', ['en_attente', 'confirmee'])
            ->where(function ($q) use ($data) {
                $q->whereBetween('date_debut', [$data['date_debut'], $data['date_fin']])
                  ->orWhereBetween('date_fin', [$data['date_debut'], $data['date_fin']])
                  ->orWhere(function ($q2) use ($data) {
                      $q2->where('date_debut', '<=', $data['date_debut'])
                         ->where('date_fin', '>=', $data['date_fin']);
                  });
            })
            ->exists();

        if ($overlap) {
            return back()
                ->withErrors(['date_debut' => 'Ce véhicule est déjà réservé sur cette période.'])
                ->withInput();
        }

        $data['user_id'] = auth()->id();
        $data['statut']  = 'en_attente'; // client ne choisit pas le statut

        Reservation::create($data);

        return redirect()->route('reservations.index')->with('success', '✅ Réservation créée.');
    }

    public function show(Reservation $reservation)
    {
        $this->ensureOwnerOrAdmin($reservation);

        $reservation->load('vehicle');

        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $this->ensureOwnerOrAdmin($reservation);

        // (Optionnel) empêcher client de modifier si confirmée
        // if (!$this->isAdmin() && $reservation->statut === 'confirmee') abort(403);

        $vehicles = Vehicle::orderBy('marque')->orderBy('modele')->get();

        return view('reservations.edit', compact('reservation', 'vehicles'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $this->ensureOwnerOrAdmin($reservation);

        $data = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'date_debut' => 'required|date',
            'date_fin'   => 'required|date|after_or_equal:date_debut',

            // ✅ seul admin peut modifier le statut (si tu veux)
            'statut'     => $this->isAdmin() ? 'nullable|in:en_attente,confirmee,annulee' : 'nullable',
        ]);

        // ✅ blocage conflit (exclure la réservation actuelle)
        $overlap = Reservation::where('vehicle_id', $data['vehicle_id'])
            ->whereIn('statut', ['en_attente', 'confirmee'])
            ->where('id', '!=', $reservation->id)
            ->where(function ($q) use ($data) {
                $q->whereBetween('date_debut', [$data['date_debut'], $data['date_fin']])
                  ->orWhereBetween('date_fin', [$data['date_debut'], $data['date_fin']])
                  ->orWhere(function ($q2) use ($data) {
                      $q2->where('date_debut', '<=', $data['date_debut'])
                         ->where('date_fin', '>=', $data['date_fin']);
                  });
            })
            ->exists();

        if ($overlap) {
            return back()
                ->withErrors(['date_debut' => 'Ce véhicule est déjà réservé sur cette période.'])
                ->withInput();
        }

        // ✅ client ne peut pas changer statut
        if (!$this->isAdmin()) {
            unset($data['statut']);
        } else {
            // si admin n'a pas envoyé statut, garder l'ancien
            if (!isset($data['statut']) || $data['statut'] === null) {
                unset($data['statut']);
            }
        }

        $reservation->update($data);

        return redirect()->route('reservations.index')->with('success', '✅ Réservation modifiée.');
    }

    public function destroy(Reservation $reservation)
    {
        $this->ensureOwnerOrAdmin($reservation);

        // Option: au lieu de supprimer, tu peux "annuler"
        // $reservation->update(['statut' => 'annulee']);
        // return redirect()->route('reservations.index')->with('success', '✅ Réservation annulée.');

        $reservation->delete();

        return redirect()->route('reservations.index')->with('success', '🗑️ Réservation supprimée.');
    }
}
