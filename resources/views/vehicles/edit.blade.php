@extends('layouts.autofleet')

@section('title', 'Modifier véhicule')
@section('page_title', 'Modifier le véhicule')
@section('page_subtitle', 'Mettre à jour les informations')

@section('content')

    @if($errors->any())
        <div style="background:rgba(239,68,68,.15); border:1px solid rgba(239,68,68,.4); color:#fecaca; padding:16px; border-radius:14px; margin-bottom:20px;">
            <strong>Veuillez corriger les erreurs :</strong>
            <ul style="margin-top:8px; padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('vehicles.update', $vehicle) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="table-card">
            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(250px,1fr)); gap:16px;">

                <div>
                    <label style="display:block; margin-bottom:6px; color:var(--text-secondary);">Immatriculation *</label>
                    <input type="text" name="immatriculation" value="{{ old('immatriculation', $vehicle->immatriculation) }}" required
                           style="width:100%; padding:12px; border-radius:12px; border:1px solid var(--border-color); background:var(--bg-dark); color:var(--text-primary);">
                </div>

                <div>
                    <label style="display:block; margin-bottom:6px; color:var(--text-secondary);">Marque *</label>
                    <input type="text" name="marque" value="{{ old('marque', $vehicle->marque) }}" required
                           style="width:100%; padding:12px; border-radius:12px; border:1px solid var(--border-color); background:var(--bg-dark); color:var(--text-primary);">
                </div>

                <div>
                    <label style="display:block; margin-bottom:6px; color:var(--text-secondary);">Modèle *</label>
                    <input type="text" name="modele" value="{{ old('modele', $vehicle->modele) }}" required
                           style="width:100%; padding:12px; border-radius:12px; border:1px solid var(--border-color); background:var(--bg-dark); color:var(--text-primary);">
                </div>

                <div>
                    <label style="display:block; margin-bottom:6px; color:var(--text-secondary);">KM actuel *</label>
                    <input type="number" min="0" name="km_actuel" value="{{ old('km_actuel', $vehicle->km_actuel) }}" required
                           style="width:100%; padding:12px; border-radius:12px; border:1px solid var(--border-color); background:var(--bg-dark); color:var(--text-primary);">
                </div>

                <div>
                    <label style="display:block; margin-bottom:6px; color:var(--text-secondary);">Statut *</label>
                    <select name="statut" required
                            style="width:100%; padding:12px; border-radius:12px; border:1px solid var(--border-color); background:var(--bg-dark); color:var(--text-primary);">
                        <option value="disponible" {{ old('statut', $vehicle->statut) === 'disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="en_service" {{ old('statut', $vehicle->statut) === 'en_service' ? 'selected' : '' }}>En service</option>
                        <option value="en_panne" {{ old('statut', $vehicle->statut) === 'en_panne' ? 'selected' : '' }}>En panne</option>
                    </select>
                </div>
            </div>

            <div style="margin-top:24px; display:flex; gap:12px;">
                <a href="{{ route('vehicles.index') }}" class="btn-primary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>

                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
            </div>
        </div>
    </form>
@endsection
