<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Modifier personne à charge</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-4xl mx-auto">
        <form action="{{ route('employee-dependents.update', $employeeDependent) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            @include('employee_dependents._form', ['employeeDependent' => $employeeDependent])
            @include('partials.form-actions', ['cancelRoute' => route('employee-dependents.index'), 'submitLabel' => 'Mettre à jour'])
        </form>
    </div>
</x-app-layout>
