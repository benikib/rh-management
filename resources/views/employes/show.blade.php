<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Détail de l'employé</h2>
            <div class="flex gap-2">
                <a href="{{ route('employes.edit', $employe) }}" class="px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold">Modifier</a>
                <a href="{{ route('employes.index') }}" class="px-4 py-2 bg-blue-400 text-white rounded-lg text-sm">Retour</a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow p-6 max-w-4xl">
        <div class="flex flex-col md:flex-row gap-6 mb-6">
            @if ($employe->photo)
                <img src="{{ asset('storage/'.$employe->photo) }}" alt="Photo de {{ $employe->nom_complet }}"
                     class="w-32 h-32 rounded-lg object-cover border border-gray-200">
            @else
                <div class="w-32 h-32 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                    <i class="fa-solid fa-user text-4xl"></i>
                </div>
            @endif
            <div>
                <p class="text-sm text-gray-500">Nom complet</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $employe->nom_complet }}</p>
                <p class="text-gray-600 mt-1">Matricule : {{ $employe->matricule }}</p>
                <span class="inline-block mt-2 px-2 py-1 text-xs rounded-full {{ $employe->statut === 'Actif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ $employe->statut }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Département</p>
                <p class="text-gray-900">{{ $employe->departement?->nom ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Poste</p>
                <p class="text-gray-900">{{ $employe->poste?->titre ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Type de contrat</p>
                <p class="text-gray-900">{{ $employe->activeContract?->contractType?->label ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Statut RH</p>
                <p class="text-gray-900">{{ $employe->status?->label ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Sexe</p>
                <p class="text-gray-900">{{ $employe->sexe }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Date de naissance</p>
                <p class="text-gray-900">{{ $employe->date_naissance?->format('d/m/Y') ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Téléphone</p>
                <p class="text-gray-900">{{ $employe->telephone ?: '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Email</p>
                <p class="text-gray-900">{{ $employe->email ?: '—' }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Adresse</p>
                <p class="text-gray-900">{{ $employe->adresse ?: '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Date d'embauche</p>
                <p class="text-gray-900">{{ $employe->date_embauche?->format('d/m/Y') ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Salaire de base</p>
                <p class="text-gray-900 font-medium">{{ number_format($employe->salaire_base, 2, ',', ' ') }} $</p>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Dossier RH</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">État civil</p>
                    <p class="text-gray-900">{{ $employe->familyInfo?->maritalStatus?->label ?? 'Aucune information' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Enfants / personnes à charge</p>
                    <p class="text-gray-900">{{ $employe->familyInfo?->dependents->count() ? $employe->familyInfo->dependents->count().' enregistré(s)' : 'Aucun' }}</p>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                <a href="{{ $employe->familyInfo ? route('employee-family-infos.show', $employe->familyInfo) : route('employee-family-infos.create') }}"
                   class="block p-4 bg-white border border-gray-200 rounded-xl hover:border-blue-400">
                    <p class="text-sm text-gray-500">Dossier familial</p>
                    <p class="mt-2 text-lg font-semibold text-gray-900">{{ $employe->familyInfo ? 'Voir / Modifier' : 'Ajouter' }}</p>
                </a>
                <a href="{{ route('employee-dependents.index') }}"
                   class="block p-4 bg-white border border-gray-200 rounded-xl hover:border-blue-400">
                    <p class="text-sm text-gray-500">Personnes à charge</p>
                    <p class="mt-2 text-lg font-semibold text-gray-900">{{ $employe->familyInfo?->dependents->count() ?? 0 }}</p>
                </a>
                <a href="{{ route('employee-position-history.index') }}"
                   class="block p-4 bg-white border border-gray-200 rounded-xl hover:border-blue-400">
                    <p class="text-sm text-gray-500">Historique de poste</p>
                    <p class="mt-2 text-lg font-semibold text-gray-900">{{ $employe->position_history_count }}</p>
                </a>
                <a href="{{ route('employee-history-logs.index') }}"
                   class="block p-4 bg-white border border-gray-200 rounded-xl hover:border-blue-400">
                    <p class="text-sm text-gray-500">Journal RH</p>
                    <p class="mt-2 text-lg font-semibold text-gray-900">{{ $employe->history_logs_count }}</p>
                </a>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-sm font-medium text-gray-700 mb-2">Présences</p>
                <p class="text-2xl font-semibold text-blue-600">{{ $employe->presences->count() }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-700 mb-2">Congés</p>
                <p class="text-2xl font-semibold text-blue-600">{{ $employe->conges->count() }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-700 mb-2">Documents</p>
                <p class="text-2xl font-semibold text-blue-600">{{ $employe->documents->count() }}</p>
            </div>
            <div class="md:col-span-3">
                <p class="text-sm font-medium text-gray-700 mb-2">Mouvements de carrière</p>
                <p class="text-2xl font-semibold text-blue-600">{{ $employe->carrieres->count() }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
