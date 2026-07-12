<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Créer un dossier familial</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-4xl mx-auto">
        <form action="{{ route('employee-family-infos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @include('employee_family_infos._form')
            @include('partials.form-actions', ['cancelRoute' => route('employee-family-infos.index'), 'submitLabel' => 'Enregistrer'])
        </form>
    </div>
</x-app-layout>
