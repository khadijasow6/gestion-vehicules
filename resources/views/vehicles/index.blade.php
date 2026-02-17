@extends('layouts.autofleet')

@section('title', 'Liste des Véhicules')
@section('page_title', 'Véhicules')
@section('page_subtitle', 'Gérez tous les véhicules de votre flotte')

@section('content')

    {{-- Barre d'actions --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem;">

        {{-- Filtres --}}
        <form method="GET" action="{{ route('vehicles.index') }}"
              style="display:flex; gap:0.75rem; flex-wrap:wrap; align-items:center;">
            <select name="statut" onchange="this.form.submit()"
                    style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:12px;padding:0.75rem 1rem;color:var(--text-primary);font-family:'Outfit',sans-serif;">
                <option value="">Tous les statuts</option>
                <option value="disponible"  {{ request('statut') == 'disponible'  ? 'selected' : '' }}>Disponible</option>
                <option value="loue"        {{ request('statut') == 'loue'        ? 'selected' : '' }}>En Location</option>
                <option value="maintenance" {{ request('statut') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
            </select>
            <select name="type" onchange="this.form.submit()"
                    style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:12px;padding:0.75rem 1rem;color:var(--text-primary);font-family:'Outfit',sans-serif;">
                <option value="">Tous les types</option>
                @foreach(['Berline','SUV','Citadine','Compacte','Break','Minibus','Pick-up'] as $t)
                    <option value="{{ $t }}" {{ request('type') == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
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
                    <th>Véhicule</th>
                    <th>Type</th>
                    <th>Année</th>
                    <th>Carburant</th>
                    <th>Kilométrage</th>
                    <th>Prix/Jour</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vehicles as $vehicle)
                <tr>
                    <td>
                        <div class="vehicle-info">
                            <div class="vehicle-icon">
                                @if($vehicle->photo)
                                    <img src="{{ asset('storage/'.$vehicle->photo) }}"
                                         style="width:100%;height:100%;object-fit:cover;border-radius:12px;" alt="">
                                @else
                                    <i class="fas fa-car"></i>
                                @endif
                            </div>
                            <div class="vehicle-details">
                                <h4>{{ $vehicle->marque }} {{ $vehicle->modele }}</h4>
                                <p>{{ $vehicle->immatriculation }}</p>
                            </div>
                        </div>
                    </td>
                    <td>{{ $vehicle->type }}</td>
                    <td>{{ $vehicle->annee }}</td>
                    <td>{{ ucfirst($vehicle->carburant) }}</td>
                    <td>{{ number_format($vehicle->kilometrage, 0, ',', ' ') }} km</td>
                    <td style="font-weight:600;color:var(--accent-primary);">
                        {{ number_format($vehicle->prix_location_jour, 0, ',', ' ') }} FCFA
                    </td>
                    <td>
                        <span class="badge {{ $vehicle->statut }}">
                            {{ $vehicle->statut == 'disponible' ? 'Disponible' : ($vehicle->statut == 'loue' ? 'En Location' : 'Maintenance') }}
                        </span>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('vehicles.show', $vehicle->id) }}"
                               class="btn-action view" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('vehicles.edit', $vehicle->id) }}"
                               class="btn-action edit" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="confirmDelete({{ $vehicle->id }}, '{{ $vehicle->marque }} {{ $vehicle->modele }}')"
                                    class="btn-action delete" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:3rem;color:var(--text-secondary);">
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
            <p>Êtes-vous sûr de vouloir supprimer <strong id="vehicleNom"></strong> ?<br>
               Cette action est <strong>irréversible</strong>.</p>
            <div class="modal-actions">
                <button onclick="closeModal()" class="btn-secondary">
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

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
@endsection
