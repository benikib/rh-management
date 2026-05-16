<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Modifier le mouvement de carrière</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-2xl">
        <form action="{{ route('carrieres.update', $carriere) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            @include('carrieres._form', ['carriere' => $carriere])
            @include('partials.form-actions', ['cancelRoute' => route('carrieres.index'), 'submitLabel' => 'Mettre à jour'])
        </form>
    </div>
</x-app-layout>
