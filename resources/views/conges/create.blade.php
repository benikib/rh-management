<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Nouveau congé</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-2xl mx-auto">
        <form action="{{ route('conges.store') }}" method="POST" class="space-y-4">
            @csrf
            @include('conges._form')
            @include('partials.form-actions', ['cancelRoute' => route('conges.index'), 'submitLabel' => 'Enregistrer'])
        </form>
    </div>
</x-app-layout>
