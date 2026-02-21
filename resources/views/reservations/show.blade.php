@extends('layouts.autofleet')

@section('title', 'Détails Réservation')
@section('page_title', 'Détails Réservation')
@section('page_subtitle', 'Informations de la réservation')

@section('content')

<div class="table-card">
    <div class="table-header">
        <div class="table-title">
            <i class="fas fa-calendar-alt"></i> Réservation #{{ $reservation->id }}
        </div>

        <div style="display:flex; gap:10px;">
            <a class="btn-primary" href="{{ route('reservations.edit', $reservation) }}">
                <i class="fas fa-pen"></i> Modifier
            </a>
            <a class="btn-primary" href="{{ route('reservations.index') }}">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <table>
        <tbody>
            <tr>
                <th style="width:240px;">Véhicule</th>
                <td>
                    {{ $reservation->vehicle?->marque }} {{ $reservation->vehicle?->modele }}
                    ({{ $reservation->vehicle?->immatriculation }})
                </td>
            </tr>
            <tr>
                <th>Période</th>
                <td>
                    {{ \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') }}
                    → {{ \Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y') }}
                </td>
            </tr>
            <tr>
                <th>Statut</th>
                <td>{{ $reservation->statut }}</td>
            </tr>
            <tr>
                <th>Note</th>
                <td>{{ $reservation->note ?? '-' }}</td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
