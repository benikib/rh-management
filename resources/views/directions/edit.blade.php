<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Modifier la direction</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-2xl mx-auto">
        <form action="{{ route('directions.update', $direction) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            @include('directions._form', ['direction' => $direction])
            @include('partials.form-actions', ['cancelRoute' => route('directions.index'), 'submitLabel' => 'Mettre à jour'])
        </form>
    </div>
</x-app-layout>
