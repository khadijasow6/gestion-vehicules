<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard — Gestion Véhicules
            </h2>
            <a href="{{ route('vehicles.index') }}"
                 class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                  Voir véhicules
           </a>

        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
                    <div class="text-sm text-gray-500">Total véhicules</div>
                    <div class="mt-2 flex items-baseline justify-between">
                        <div class="text-3xl font-bold text-gray-900">{{ $totalVehicles }}</div>
                        <span class="text-xs text-gray-400">Fleet</span>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
                    <div class="text-sm text-gray-500">Disponibles</div>
                    <div class="mt-2 flex items-baseline justify-between">
                        <div class="text-3xl font-bold text-green-600">{{ $availableVehicles }}</div>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                            OK
                        </span>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
                    <div class="text-sm text-gray-500">En service</div>
                    <div class="mt-2 flex items-baseline justify-between">
                        <div class="text-3xl font-bold text-blue-600">{{ $inServiceVehicles }}</div>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                            En cours
                        </span>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
                    <div class="text-sm text-gray-500">En panne</div>
                    <div class="mt-2 flex items-baseline justify-between">
                        <div class="text-3xl font-bold text-red-600">{{ $brokenVehicles }}</div>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700">
                            Attention
                        </span>
                    </div>
                </div>

            </div>

            {{-- Table --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Derniers véhicules ajoutés</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Immatriculation</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Marque</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Modèle</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($latestVehicles as $v)
                                @php
                                    $badge = match($v->statut) {
                                        'disponible' => 'bg-green-50 text-green-700',
                                        'en_service' => 'bg-blue-50 text-blue-700',
                                        'en_panne' => 'bg-red-50 text-red-700',
                                        default => 'bg-gray-50 text-gray-700',
                                    };
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $v->immatriculation }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $v->marque }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $v->modele }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $badge }}">
                                            {{ $v->statut }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-6 text-gray-500" colspan="4">Aucun véhicule pour le moment.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
