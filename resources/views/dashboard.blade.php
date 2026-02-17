@extends('layouts.autofleet')

@section('title', 'Dashboard')

@section('content')
    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card primary">
            <div class="stat-header">
                <div>
                    <div class="stat-label">Total Véhicules</div>
                    <div class="stat-value">{{ $totalVehicles }}</div>
                </div>
                <div class="stat-icon" style="color: var(--accent-primary);">
                    <i class="fas fa-car"></i>
                </div>
            </div>
        </div>

        <div class="stat-card success">
            <div class="stat-header">
                <div>
                    <div class="stat-label">Disponibles</div>
                    <div class="stat-value">{{ $availableVehicles }}</div>
                </div>
                <div class="stat-icon" style="color: var(--accent-success);">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>

        <div class="stat-card warning">
            <div class="stat-header">
                <div>
                    <div class="stat-label">En service</div>
                    <div class="stat-value">{{ $inServiceVehicles }}</div>
                </div>
                <div class="stat-icon" style="color: var(--accent-warning);">
                    <i class="fas fa-key"></i>
                </div>
            </div>
        </div>

        <div class="stat-card danger">
            <div class="stat-header">
                <div>
                    <div class="stat-label">En panne</div>
                    <div class="stat-value">{{ $brokenVehicles }}</div>
                </div>
                <div class="stat-icon" style="color: var(--accent-danger);">
                    <i class="fas fa-wrench"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Vehicles Table (Derniers véhicules) -->
    <div class="table-card">
        <div class="table-header">
            <div class="table-title">
                <i class="fas fa-list"></i>
                Véhicules Récents
            </div>
            <a class="btn-primary" href="{{ route('vehicles.index') }}">
                <i class="fas fa-car"></i> Voir véhicules
            </a>
        </div>

        <table>
            <thead>
            <tr>
                <th>Immatriculation</th>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Statut</th>
                <th>KM</th>
            </tr>
            </thead>
            <tbody>
            @foreach($latestVehicles as $v)
                <tr>
                    <td>
                        <div class="vehicle-info">
                            <div class="vehicle-icon"><i class="fas fa-car"></i></div>
                            <div class="vehicle-details">
                                <h4>{{ $v->marque }} {{ $v->modele }}</h4>
                                <p>{{ $v->immatriculation }}</p>
                            </div>
                        </div>
                    </td>
                    <td>{{ $v->marque }}</td>
                    <td>{{ $v->modele }}</td>
                    <td>
                        <span class="badge {{ $v->statut === 'disponible' ? 'disponible' : ($v->statut === 'en_service' ? 'loue' : 'maintenance') }}">
                            {{ $v->statut }}
                        </span>
                    </td>
                    <td>{{ number_format($v->km_actuel) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
