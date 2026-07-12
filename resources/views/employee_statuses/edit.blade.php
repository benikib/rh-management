<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Modifier le statut RH</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-4xl mx-auto">
        <form action="{{ route('employee-statuses.update', $employeeStatus) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            @include('employee_statuses._form', ['employeeStatus' => $employeeStatus])
            @include('partials.form-actions', ['cancelRoute' => route('employee-statuses.index'), 'submitLabel' => 'Mettre à jour'])
        </form>
    </div>
</x-app-layout>
