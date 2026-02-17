@extends('layouts.autofleet')

@section('title', 'Ajouter un Véhicule')
@section('page_title', 'Ajouter un Véhicule')
@section('page_subtitle', 'Créer un nouveau véhicule')

@section('content')

    {{-- Erreurs de validation --}}
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

    <form action="{{ route('vehicles.store') }}" method="POST">
        @csrf

        <div class="table-card">

            <div class="form-grid" style="display:grid; grid-template-columns:repeat(auto-fit,minmax(250px,1fr)); gap:16px;">

                {{-- Immatriculation --}}
                <div class="form-group">
                    <label>Immatriculation *</label>
                    <input type="text" name="immatriculation"
                           placeholder="DK-123-AA"
                           value="{{ old('immatriculation') }}"
                           required>
                </div>

                {{-- Marque --}}
                <div class="form-group">
                    <label>Marque *</label>
                    <input type="text" name="marque"
                           placeholder="Toyota"
                           value="{{ old('marque') }}"
                           required>
                </div>

                {{-- Modèle --}}
                <div class="form-group">
                    <label>Modèle *</label>
                    <input type="text" name="modele"
                           placeholder="Yaris"
                           value="{{ old('modele') }}"
                           required>
                </div>

                {{-- Kilométrage --}}
                <div class="form-group">
                    <label>Kilométrage actuel *</label>
                    <input type="number" name="km_actuel"
                           min="0"
                           value="{{ old('km_actuel', 0) }}"
                           required>
                </div>

                {{-- Statut --}}
                <div class="form-group">
                    <label>Statut *</label>
                    <select name="statut" required>
                        <option value="disponible" {{ old('statut','disponible')=='disponible'?'selected':'' }}>Disponible</option>
                        <option value="en_service" {{ old('statut')=='en_service'?'selected':'' }}>En service</option>
                        <option value="en_panne" {{ old('statut')=='en_panne'?'selected':'' }}>En panne</option>
                    </select>
                </div>

            </div>

            {{-- Actions --}}
            <div style="margin-top:24px; display:flex; gap:12px;">
                <a href="{{ route('vehicles.index') }}" class="btn-secondary">
                    Annuler
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-plus"></i> Enregistrer
                </button>
            </div>

        </div>
    </form>

@endsection
