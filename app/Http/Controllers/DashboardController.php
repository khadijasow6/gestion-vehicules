<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;

class DashboardController extends Controller
{
    public function index()
    {
        $totalVehicles = Vehicle::count();
        $disponibles   = Vehicle::where('statut', 'disponible')->count();
        $enService     = Vehicle::where('statut', 'en_service')->count();
        $enPanne       = Vehicle::where('statut', 'en_panne')->count();

        $lastVehicles = Vehicle::latest()->take(6)->get();

        return view('dashboard', compact(
            'totalVehicles','disponibles','enService','enPanne','lastVehicles'
        ));
    }
}
