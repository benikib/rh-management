<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Modifier la mission</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-4xl mx-auto">
        <form action="{{ route('missions.update', $mission) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            @include('missions._form', ['mission' => $mission])
            @include('partials.form-actions', ['cancelRoute' => route('missions.index'), 'submitLabel' => 'Mettre à jour'])
        </form>
    </div>
</x-app-layout>
