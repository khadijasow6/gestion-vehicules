@extends('layouts.autofleet')

@section('title', 'Nouvelle Réservation')
@section('page_title', 'Nouvelle Réservation')
@section('page_subtitle', 'Créer une réservation')

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

<form action="{{ route('reservations.store') }}" method="POST">
    @csrf

    <div class="table-card" style="display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); gap:16px;">

        <div>
            <label style="display:block; margin-bottom:6px; color:var(--text-secondary);">Véhicule *</label>
            <select name="vehicle_id" required
                    style="width:100%; padding:12px; border-radius:12px; border:1px solid var(--border-color); background:var(--bg-dark); color:var(--text-primary);">
                <option value="">-- Choisir --</option>
                @foreach($vehicles as $v)
                    <option value="{{ $v->id }}" {{ old('vehicle_id') == $v->id ? 'selected' : '' }}>
                        {{ $v->marque }} {{ $v->modele }} ({{ $v->immatriculation }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label style="display:block; margin-bottom:6px; color:var(--text-secondary);">Date début *</label>
            <input type="date" name="date_debut" value="{{ old('date_debut') }}" required
                   style="width:100%; padding:12px; border-radius:12px; border:1px solid var(--border-color); background:var(--bg-dark); color:var(--text-primary);">
        </div>

        <div>
            <label style="display:block; margin-bottom:6px; color:var(--text-secondary);">Date fin *</label>
            <input type="date" name="date_fin" value="{{ old('date_fin') }}" required
                   style="width:100%; padding:12px; border-radius:12px; border:1px solid var(--border-color); background:var(--bg-dark); color:var(--text-primary);">
        </div>

        <div style="grid-column:1/-1;">
            <label style="display:block; margin-bottom:6px; color:var(--text-secondary);">Note</label>
            <textarea name="note" rows="3"
                style="width:100%; padding:12px; border-radius:12px; border:1px solid var(--border-color); background:var(--bg-dark); color:var(--text-primary);">{{ old('note') }}</textarea>
        </div>

        <div style="grid-column:1/-1; display:flex; gap:12px;">
            <a href="{{ route('reservations.index') }}" class="btn-primary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Enregistrer
            </button>
        </div>

    </div>
</form>

@endsection
