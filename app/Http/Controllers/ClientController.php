<?php

namespace App\Http\Controllers;

use App\Models\User;

class ClientController extends Controller
{
    public function index()
    {
        // Si ce n'est pas admin → interdit
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Accès interdit');
        }

        $clients = User::where('role', 'client')
            ->withCount('reservations')
            ->latest()
            ->paginate(10);

        return view('clients.index', compact('clients'));
    }

    public function show(User $client)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Accès interdit');
        }

        $client->load('reservations.vehicle');

        return view('clients.show', compact('client'));
    }
}