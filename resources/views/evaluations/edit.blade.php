<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Modifier l'évaluation</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-4xl mx-auto">
        <form action="{{ route('evaluations.update', $evaluation) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="employe_matricule" value="{{ $evaluation->employe_matricule }}">

            <div class="rounded-lg border border-gray-200 p-4 bg-gray-50">
                <p class="text-sm text-gray-600">Employé : <strong>{{ $evaluation->employe->prenom }} {{ $evaluation->employe->nom }}</strong></p>
                <p class="text-sm text-gray-600">Matricule : <strong>{{ $evaluation->employe_matricule }}</strong></p>
            </div>

            @include('evaluations._form', ['criteres' => $criteres, 'evaluation' => $evaluation])

            @include('partials.form-actions', ['cancelRoute' => route('evaluations.show', $evaluation), 'submitLabel' => 'Mettre à jour'])
        </form>
    </div>
</x-app-layout>
