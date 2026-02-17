<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::query();

        // Filtre statut (optionnel)
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $vehicles = $query->latest()->paginate(10);

        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('vehicles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'immatriculation' => 'required|string|max:50|unique:vehicles,immatriculation',
            'marque'          => 'required|string|max:100',
            'modele'          => 'required|string|max:100',
            'statut'          => 'required|in:disponible,en_service,en_panne',
            'km_actuel'       => 'required|integer|min:0',
        ]);

        Vehicle::create($data);

        return redirect()->route('vehicles.index')
            ->with('success', '✅ Véhicule ajouté avec succès !');
    }

    public function show(Vehicle $vehicle)
    {
        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'immatriculation' => 'required|string|max:50|unique:vehicles,immatriculation,' . $vehicle->id,
            'marque'          => 'required|string|max:100',
            'modele'          => 'required|string|max:100',
            'statut'          => 'required|in:disponible,en_service,en_panne',
            'km_actuel'       => 'required|integer|min:0',
        ]);

        $vehicle->update($data);

        return redirect()->route('vehicles.index')
            ->with('success', '✅ Véhicule modifié avec succès !');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('vehicles.index')
            ->with('success', '🗑️ Véhicule supprimé avec succès !');
    }
}
