<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Nouvelle évaluation</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-4xl mx-auto">
        <form action="{{ route('evaluations.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="employe_matricule" value="{{ $employe->matricule }}">
            <div class="rounded-lg border border-gray-200 p-4 bg-gray-50">
                <p class="text-sm text-gray-600">Employé : <strong>{{ $employe->prenom }} {{ $employe->nom }}</strong></p>
                <p class="text-sm text-gray-600">Matricule : <strong>{{ $employe->matricule }}</strong></p>
            </div>

            @include('evaluations._form', ['criteres' => $criteres])

            @include('partials.form-actions', ['cancelRoute' => route('evaluations.index', $employe->matricule)])
        </form>
    </div>
</x-app-layout>
