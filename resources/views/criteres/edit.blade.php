<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Modifier le critère</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-2xl mx-auto">
        <form action="{{ route('criteres.update', $critere) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            @include('criteres._form', ['critere' => $critere])
            @include('partials.form-actions', ['cancelRoute' => route('criteres.index'), 'submitLabel' => 'Mettre à jour'])
        </form>
    </div>
</x-app-layout>
