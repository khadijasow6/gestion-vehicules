@extends('layouts.autofleet')

@section('title', 'Détails véhicule')
@section('page_title', 'Détails du véhicule')
@section('page_subtitle', 'Informations complètes')

@section('content')
    <div class="table-card">
        <div class="table-header">
            <div class="table-title">
                <i class="fas fa-car"></i> {{ $vehicle->marque }} {{ $vehicle->modele }}
            </div>

            <div style="display:flex; gap:10px;">
                <a class="btn-primary" href="{{ route('vehicles.edit', $vehicle) }}">
                    <i class="fas fa-pen"></i> Modifier
                </a>
                <a class="btn-primary" href="{{ route('vehicles.index') }}">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>

        <table>
            <tbody>
                <tr>
                    <th style="width:240px;">Immatriculation</th>
                    <td>{{ $vehicle->immatriculation }}</td>
                </tr>
                <tr>
                    <th>Marque</th>
                    <td>{{ $vehicle->marque }}</td>
                </tr>
                <tr>
                    <th>Modèle</th>
                    <td>{{ $vehicle->modele }}</td>
                </tr>
                <tr>
                    <th>Statut</th>
                    <td>
                        <span class="badge {{ $vehicle->statut === 'disponible' ? 'disponible' : ($vehicle->statut === 'en_service' ? 'loue' : 'maintenance') }}">
                            {{ $vehicle->statut }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Kilométrage actuel</th>
                    <td>{{ number_format($vehicle->km_actuel) }} km</td>
                </tr>
                <tr>
                    <th>Créé le</th>
                    <td>{{ $vehicle->created_at?->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Mis à jour le</th>
                    <td>{{ $vehicle->updated_at?->format('d/m/Y H:i') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
