<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Ajouter un journal RH</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-4xl mx-auto">
        <form action="{{ route('employee-history-logs.store') }}" method="POST" class="space-y-4">
            @csrf
            @include('employee_history_logs._form')
            @include('partials.form-actions', ['cancelRoute' => route('employee-history-logs.index'), 'submitLabel' => 'Enregistrer'])
        </form>
    </div>
</x-app-layout>
