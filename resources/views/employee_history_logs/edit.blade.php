<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Modifier le journal RH</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-4xl mx-auto">
        <form action="{{ route('employee-history-logs.update', $employeeHistoryLog) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            @include('employee_history_logs._form', ['employeeHistoryLog' => $employeeHistoryLog])
            @include('partials.form-actions', ['cancelRoute' => route('employee-history-logs.index'), 'submitLabel' => 'Mettre à jour'])
        </form>
    </div>
</x-app-layout>
