<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;

class DashboardController extends Controller
{
 public function index()
    {
        return view('dashboard', [
            'totalVehicles' => Vehicle::count(),
            'availableVehicles' => Vehicle::where('statut', 'disponible')->count(),
            'inServiceVehicles' => Vehicle::where('statut', 'en_service')->count(),
            'brokenVehicles' => Vehicle::where('statut', 'en_panne')->count(),
            'latestVehicles' => Vehicle::latest()->take(5)->get(),
        ]);
    }
}
