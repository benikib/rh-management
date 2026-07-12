<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Modifier la tâche</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-4xl mx-auto">
        <form action="{{ route('personnel-tasks.update', $personnelTask) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            @include('personnel_tasks._form', ['personnelTask' => $personnelTask])
            @include('partials.form-actions', ['cancelRoute' => route('personnel-tasks.index'), 'submitLabel' => 'Mettre à jour'])
        </form>
    </div>
</x-app-layout>
