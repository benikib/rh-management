<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Modifier l'employé</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-4xl">
        <form action="{{ route('employes.update', $employe) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            @include('employes._form', ['employe' => $employe])
            @include('partials.form-actions', ['cancelRoute' => route('employes.index'), 'submitLabel' => 'Mettre à jour'])
        </form>
    </div>
</x-app-layout>
