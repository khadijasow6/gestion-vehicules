@extends('layouts.autofleet')

@section('title', 'Dashboard - AutoFleet')
@section('page_title', 'Dashboard')
@section('page_subtitle', "Vue d'ensemble de votre flotte")

@section('content')

{{-- Message success --}}
@if(session('success'))
    <div style="background:rgba(16,185,129,.15); border:1px solid rgba(16,185,129,.35); color:#a7f3d0; padding:14px; border-radius:14px; margin-bottom:16px;">
        {{ session('success') }}
    </div>
@endif

{{-- ====== STATS ====== --}}
<div style="
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap:16px;
    margin-bottom:18px;
">

    {{-- Total --}}
    <div style="background:var(--bg-card); border:1px solid var(--border-color); border-radius:18px; padding:16px;">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
            <div>
                <div style="color:var(--text-secondary); font-size:.85rem; letter-spacing:.04em; text-transform:uppercase;">Total véhicules</div>
                <div style="font-size:2rem; font-weight:800; margin-top:6px;">{{ $totalVehicles ?? 0 }}</div>
            </div>
            <div style="width:46px; height:46px; border-radius:14px; display:flex; align-items:center; justify-content:center; background:rgba(0,212,255,.12); color:var(--accent-primary); font-size:1.2rem;">
                <i class="fas fa-car"></i>
            </div>
        </div>
    </div>

    {{-- Disponibles --}}
    <div style="background:var(--bg-card); border:1px solid var(--border-color); border-radius:18px; padding:16px;">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
            <div>
                <div style="color:var(--text-secondary); font-size:.85rem; letter-spacing:.04em; text-transform:uppercase;">Disponibles</div>
                <div style="font-size:2rem; font-weight:800; margin-top:6px;">{{ $disponibles ?? 0 }}</div>
            </div>
            <div style="width:46px; height:46px; border-radius:14px; display:flex; align-items:center; justify-content:center; background:rgba(16,185,129,.12); color:var(--accent-success); font-size:1.2rem;">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>

    {{-- En service --}}
    <div style="background:var(--bg-card); border:1px solid var(--border-color); border-radius:18px; padding:16px;">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
            <div>
                <div style="color:var(--text-secondary); font-size:.85rem; letter-spacing:.04em; text-transform:uppercase;">En service</div>
                <div style="font-size:2rem; font-weight:800; margin-top:6px;">{{ $enService ?? 0 }}</div>
            </div>
            <div style="width:46px; height:46px; border-radius:14px; display:flex; align-items:center; justify-content:center; background:rgba(245,158,11,.12); color:var(--accent-warning); font-size:1.2rem;">
                <i class="fas fa-key"></i>
            </div>
        </div>
    </div>

    {{-- En panne --}}
    <div style="background:var(--bg-card); border:1px solid var(--border-color); border-radius:18px; padding:16px;">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
            <div>
                <div style="color:var(--text-secondary); font-size:.85rem; letter-spacing:.04em; text-transform:uppercase;">En panne</div>
                <div style="font-size:2rem; font-weight:800; margin-top:6px;">{{ $enPanne ?? 0 }}</div>
            </div>
            <div style="width:46px; height:46px; border-radius:14px; display:flex; align-items:center; justify-content:center; background:rgba(239,68,68,.12); color:var(--accent-danger); font-size:1.2rem;">
                <i class="fas fa-triangle-exclamation"></i>
            </div>
        </div>
    </div>

</div>

{{-- ====== ACTIONS RAPIDES ====== --}}
<div style="display:flex; gap:12px; flex-wrap:wrap; margin-bottom:16px;">
    <a href="{{ route('vehicles.index') }}" class="btn-primary">
        <i class="fas fa-car"></i> Gérer les véhicules
    </a>
    <a href="{{ route('reservations.index') }}" class="btn-primary">
        <i class="fas fa-calendar-alt"></i> Voir les réservations
    </a>
</div>

{{-- ====== VEHICULES RECENTS ====== --}}
<div class="table-card">
    <div class="table-header">
        <div class="table-title">
            <i class="fas fa-clock"></i> Véhicules récents
        </div>

        <a href="{{ route('vehicles.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Ajouter
        </a>
    </div>

    <div style="overflow-x:auto;">
        <table style="min-width:900px;">
            <thead>
                <tr>
                    <th>Immatriculation</th>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>Statut</th>
                    <th style="text-align:right;">KM</th>
                    <th style="text-align:right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse(($lastVehicles ?? []) as $v)
                    @php
                        $badgeClass = match($v->statut) {
                            'disponible' => 'disponible',
                            'en_service' => 'loue',
                            'en_panne' => 'maintenance',
                            default => 'loue',
                        };
                        $statutLabel = match($v->statut) {
                            'disponible' => 'Disponible',
                            'en_service' => 'En service',
                            'en_panne' => 'En panne',
                            default => $v->statut,
                        };
                    @endphp
                    <tr>
                        <td style="font-family:'JetBrains Mono', monospace;">{{ $v->immatriculation }}</td>
                        <td style="font-weight:600;">{{ $v->marque }}</td>
                        <td>{{ $v->modele }}</td>
                        <td>
                            <span class="badge {{ $badgeClass }}">{{ $statutLabel }}</span>
                        </td>
                        <td style="text-align:right; font-weight:600;">
                            {{ number_format($v->km_actuel, 0, ',', ' ') }}
                        </td>
                        <td style="text-align:right;">
                            <a href="{{ route('vehicles.index') }}" class="btn-primary" style="padding:.55rem .9rem;">
                                <i class="fas fa-eye"></i> Voir
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding:2rem; text-align:center; color:var(--text-secondary);">
                            Aucun véhicule pour le moment.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
