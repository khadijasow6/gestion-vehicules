@extends('layouts.autofleet')

@section('title', 'Liste des Véhicules')
@section('page_title', 'Véhicules')
@section('page_subtitle', 'Gérez tous les véhicules de votre flotte')

@section('content')

    {{-- Message succès --}}
    @if(session('success'))
        <div style="background:rgba(16,185,129,.15); border:1px solid rgba(16,185,129,.35); color:#bbf7d0; padding:14px; border-radius:14px; margin-bottom:18px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Barre d'actions --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem;">

        {{-- Filtre statut --}}
        <form method="GET" action="{{ route('vehicles.index') }}"
              style="display:flex; gap:0.75rem; flex-wrap:wrap; align-items:center;">
            <select name="statut" onchange="this.form.submit()"
                    style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:12px;padding:0.75rem 1rem;color:var(--text-primary);font-family:'Outfit',sans-serif;">
                <option value="">Tous les statuts</option>
                <option value="disponible" {{ request('statut') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                <option value="en_service" {{ request('statut') == 'en_service' ? 'selected' : '' }}>En service</option>
                <option value="en_panne" {{ request('statut') == 'en_panne' ? 'selected' : '' }}>En panne</option>
            </select>
        </form>

        <a href="{{ route('vehicles.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Ajouter un Véhicule
        </a>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-header">
            <div class="table-title">
                <i class="fas fa-list"></i>
                Tous les Véhicules
                <span style="background:rgba(0,212,255,0.15);color:var(--accent-primary);padding:0.25rem 0.75rem;border-radius:20px;font-size:0.875rem;">
                    {{ $vehicles->total() }}
                </span>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Immatriculation</th>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>Kilométrage</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($vehicles as $vehicle)
                    @php
                        // On réutilise les classes de badge du template
                        $badgeClass = match($vehicle->statut) {
                            'disponible' => 'disponible',
                            'en_service' => 'loue',        // couleur orange
                            'en_panne'   => 'maintenance', // couleur rouge
                            default      => 'disponible',
                        };

                        $badgeLabel = match($vehicle->statut) {
                            'disponible' => 'Disponible',
                            'en_service' => 'En service',
                            'en_panne'   => 'En panne',
                            default      => $vehicle->statut,
                        };
                    @endphp

                    <tr>
                        <td style="font-family:'JetBrains Mono', monospace;">
                            {{ $vehicle->immatriculation }}
                        </td>

                        <td>{{ $vehicle->marque }}</td>
                        <td>{{ $vehicle->modele }}</td>

                        <td>{{ number_format($vehicle->km_actuel, 0, ',', ' ') }} km</td>

                        <td>
                            <span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
                        </td>

                        <td>
                            <div class="actions">
                                <a href="{{ route('vehicles.show', $vehicle) }}"
                                   class="btn-action view" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('vehicles.edit', $vehicle) }}"
                                   class="btn-action edit" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button type="button"
                                    onclick="confirmDelete({{ $vehicle->id }}, '{{ $vehicle->immatriculation }}')"
                                    class="btn-action delete" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:3rem;color:var(--text-secondary);">
                            <i class="fas fa-car" style="font-size:3rem;margin-bottom:1rem;display:block;opacity:0.3;"></i>
                            Aucun véhicule trouvé
                            <br>
                            <a href="{{ route('vehicles.create') }}" class="btn-primary" style="margin-top:1rem;display:inline-flex;">
                                <i class="fas fa-plus"></i> Ajouter le premier véhicule
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($vehicles->hasPages())
            <div style="margin-top:1.5rem; display:flex; justify-content:center;">
                {{ $vehicles->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    {{-- Modal Suppression --}}
    <div class="modal-overlay" id="deleteModal">
        <div class="modal">
            <div class="modal-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3>Confirmer la suppression</h3>
            <p>Êtes-vous sûr de vouloir supprimer le véhicule <strong id="vehicleNom"></strong> ?<br>
               Cette action est <strong>irréversible</strong>.</p>
            <div class="modal-actions">
                <button type="button" onclick="closeModal()" class="btn-secondary">
                    <i class="fas fa-times"></i> Annuler
                </button>

                <form id="deleteForm" method="POST" style="margin:0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger">
                        <i class="fas fa-trash"></i> Oui, Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function confirmDelete(id, nom) {
        document.getElementById('vehicleNom').textContent = nom;
        document.getElementById('deleteForm').action = '/vehicles/' + id;
        document.getElementById('deleteModal').classList.add('show');
    }

    function closeModal() {
        document.getElementById('deleteModal').classList.remove('show');
    }

    const modal = document.getElementById('deleteModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    }
</script>
@endsection
