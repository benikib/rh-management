<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Modifier l'historique de poste</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-4xl mx-auto">
        <form action="{{ route('employee-position-history.update', $employeePositionHistory) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            @include('employee_position_history._form', ['employeePositionHistory' => $employeePositionHistory])
            @include('partials.form-actions', ['cancelRoute' => route('employee-position-history.index'), 'submitLabel' => 'Mettre à jour'])
        </form>
    </div>
</x-app-layout>
