@extends('layouts.autofleet')

@section('title','Clients')
@section('page_title','Clients')
@section('page_subtitle','Liste des clients et leurs réservations')

@section('content')
<div class="table-card">
    <div class="table-header">
        <div class="table-title">
            <i class="fas fa-users"></i> Clients
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Réservations</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @forelse($clients as $c)
            <tr>
                <td>{{ $c->name }}</td>
                <td>{{ $c->email }}</td>
                <td>
                    <span class="badge en_service">{{ $c->reservations_count }}</span>
                </td>
                <td>
                    <a class="btn-action view" href="{{ route('clients.show',$c->id) }}" title="Voir">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr><td colspan="4">Aucun client.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:1rem;">
        {{ $clients->links() }}
    </div>
</div>
@endsection