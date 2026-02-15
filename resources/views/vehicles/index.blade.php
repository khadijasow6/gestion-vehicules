<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Véhicules
            </h2>

            <a href="#"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                + Ajouter
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100">

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Immatriculation</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Marque</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Modèle</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($vehicles as $v)
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
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900 font-medium">Voir</a>
                                        <span class="text-gray-300 px-2">|</span>
                                        <a href="#" class="text-amber-600 hover:text-amber-900 font-medium">Modifier</a>
                                        <span class="text-gray-300 px-2">|</span>
                                        <a href="#" class="text-red-600 hover:text-red-900 font-medium">Supprimer</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-6 text-gray-500" colspan="5">Aucun véhicule trouvé.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4">
                    {{ $vehicles->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>