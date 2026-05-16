<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Modifier le congé</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-2xl">
        <form action="{{ route('conges.update', $conge) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            @include('conges._form', ['conge' => $conge])
            @include('partials.form-actions', ['cancelRoute' => route('conges.index'), 'submitLabel' => 'Mettre à jour'])
        </form>
    </div>
</x-app-layout>
