<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Modifier la présence</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-2xl    mx-auto">
        <form action="{{ route('presences.update', $presence) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            @include('presences._form', ['presence' => $presence])
            @include('partials.form-actions', ['cancelRoute' => route('presences.index'), 'submitLabel' => 'Mettre à jour'])
        </form>
    </div>
</x-app-layout>
