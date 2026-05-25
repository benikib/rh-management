<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Nouvelle direction</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-2xl mx-auto">
        <form action="{{ route('directions.store') }}" method="POST" class="space-y-4">
            @csrf
            @include('directions._form')
            @include('partials.form-actions', ['cancelRoute' => route('directions.index'), 'submitLabel' => 'Enregistrer'])
        </form>
    </div>
</x-app-layout>
