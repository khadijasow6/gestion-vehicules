@extends('layouts.autofleet')

@section('title','Détail Client')
@section('page_title','Client')
@section('page_subtitle','Détails + réservations')

@section('content')
<div class="table-card" style="margin-bottom:1.5rem;">
    <div class="table-title">
        <i class="fas fa-user"></i> {{ $client->name }}
    </div>
    <p style="color:var(--text-secondary);margin-top:.5rem;">
        Email : <strong>{{ $client->email }}</strong>
    </p>
</div>

<div class="table-card">
    <div class="table-header">
        <div class="table-title">
            <i class="fas fa-calendar-alt"></i> Réservations de ce client
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Véhicule</th>
                <th>Immatriculation</th>
                <th>Date début</th>
                <th>Date fin</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
        @forelse($client->reservations as $r)
            <tr>
                <td>{{ $r->vehicle?->marque }} {{ $r->vehicle?->modele }}</td>
                <td>{{ $r->vehicle?->immatriculation }}</td>
                <td>{{ $r->date_debut }}</td>
                <td>{{ $r->date_fin }}</td>
                <td><span class="badge disponible">{{ $r->statut ?? 'en_attente' }}</span></td>
            </tr>
        @empty
            <tr><td colspan="5">Aucune réservation.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection