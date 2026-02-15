<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard — Gestion Véhicules
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded shadow">
                    <div class="text-gray-500 text-sm">Total véhicules</div>
                    <div class="text-3xl font-bold">{{ $totalVehicles }}</div>
                </div>
                <div class="bg-white p-5 rounded shadow">
                    <div class="text-gray-500 text-sm">Disponibles</div>
                    <div class="text-3xl font-bold">{{ $availableVehicles }}</div>
                </div>
                <div class="bg-white p-5 rounded shadow">
                    <div class="text-gray-500 text-sm">En service</div>
                    <div class="text-3xl font-bold">{{ $inServiceVehicles }}</div>
                </div>
                <div class="bg-white p-5 rounded shadow">
                    <div class="text-gray-500 text-sm">En panne</div>
                    <div class="text-3xl font-bold">{{ $brokenVehicles }}</div>
                </div>
            </div>

            <div class="bg-white p-5 rounded shadow">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold">Derniers véhicules ajoutés</h3>
                </div>

                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-500 border-b">
                            <tr>
                                <th class="py-2 pr-4">Immatriculation</th>
                                <th class="py-2 pr-4">Marque</th>
                                <th class="py-2 pr-4">Modèle</th>
                                <th class="py-2 pr-4">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse($latestVehicles as $v)
                                <tr>
                                    <td class="py-2 pr-4 font-medium">{{ $v->immatriculation }}</td>
                                    <td class="py-2 pr-4">{{ $v->marque }}</td>
                                    <td class="py-2 pr-4">{{ $v->modele }}</td>
                                    <td class="py-2 pr-4">{{ $v->statut }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="py-3 text-gray-500" colspan="4">Aucun véhicule pour le moment.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
