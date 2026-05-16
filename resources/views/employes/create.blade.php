<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Nouvel employé</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-4xl">
        <form action="{{ route('employes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @include('employes._form')
            @include('partials.form-actions', ['cancelRoute' => route('employes.index'), 'submitLabel' => 'Enregistrer'])
        </form>
    </div>
</x-app-layout>
