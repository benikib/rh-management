<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Détail de l'utilisateur</h2>
            <div class="flex gap-2">
                <a href="{{ route('users.edit', $user) }}" class="px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold">Modifier</a>
                <a href="{{ route('users.index') }}" class="px-4 py-2 bg-blue-400 text-white rounded-lg text-sm">Retour</a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow p-6 max-w-2xl space-y-4">
        <div>
            <p class="text-sm text-gray-500">Nom</p>
            <p class="text-lg font-semibold text-gray-900">{{ $user->name }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Email</p>
            <p class="text-gray-900">{{ $user->email }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Rôle</p>
            <p class="text-gray-900 font-medium">{{ $user->role?->nom ?? '—' }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Créé le</p>
            <p class="text-gray-900">{{ $user->created_at?->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</x-app-layout>
