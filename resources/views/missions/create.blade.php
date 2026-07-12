<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Nouvelle mission</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-4xl mx-auto">
        <form action="{{ route('missions.store') }}" method="POST" class="space-y-4">
            @csrf
            @include('missions._form')
            @include('partials.form-actions', ['cancelRoute' => route('missions.index'), 'submitLabel' => 'Enregistrer'])
        </form>
    </div>
</x-app-layout>
