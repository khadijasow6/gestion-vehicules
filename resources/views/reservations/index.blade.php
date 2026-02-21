@extends('layouts.autofleet')

@section('title', 'Réservations')
@section('page_title', 'Réservations')
@section('page_subtitle', 'Gérez vos réservations')

@section('content')

@if(session('success'))
    <div style="background:rgba(16,185,129,.15); border:1px solid rgba(16,185,129,.35); color:#bbf7d0; padding:14px; border-radius:14px; margin-bottom:18px;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div style="display:flex; justify-content:flex-end; margin-bottom:1rem;">
    <a href="{{ route('reservations.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Nouvelle réservation
    </a>
</div>

<div class="table-card">
    <div class="table-header">
        <div class="table-title">
            <i class="fas fa-list"></i> Mes réservations
            <span style="background:rgba(0,212,255,0.15);color:var(--accent-primary);padding:0.25rem 0.75rem;border-radius:20px;font-size:0.875rem;">
                {{ $reservations->total() }}
            </span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Véhicule</th>
                <th>Période</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        @forelse($reservations as $r)
            @php
                $badgeClass = match($r->statut) {
                    'en_attente' => 'loue',
                    'confirmee'  => 'disponible',
                    'annulee'    => 'maintenance',
                    default      => 'loue'
                };
                $badgeLabel = match($r->statut) {
                    'en_attente' => 'En attente',
                    'confirmee'  => 'Confirmée',
                    'annulee'    => 'Annulée',
                    default      => $r->statut
                };
            @endphp

            <tr>
                <td>
                    {{ $r->vehicle?->marque }} {{ $r->vehicle?->modele }}
                    <div style="color:var(--text-secondary); font-size:.9rem; font-family:'JetBrains Mono', monospace;">
                        {{ $r->vehicle?->immatriculation }}
                    </div>
                </td>

                <td>
                    {{ \Carbon\Carbon::parse($r->date_debut)->format('d/m/Y') }}
                    → {{ \Carbon\Carbon::parse($r->date_fin)->format('d/m/Y') }}
                </td>

                <td><span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span></td>

                <td>
                    <div class="actions">
                        <a href="{{ route('reservations.show', $r) }}" class="btn-action view" title="Voir">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('reservations.edit', $r) }}" class="btn-action edit" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('reservations.destroy', $r) }}" method="POST"
                              onsubmit="return confirm('Supprimer cette réservation ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action delete" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align:center;padding:3rem;color:var(--text-secondary);">
                    Aucune réservation trouvée.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    @if($reservations->hasPages())
        <div style="margin-top:1.5rem; display:flex; justify-content:center;">
            {{ $reservations->links() }}
        </div>
    @endif
</div>

@endsection
