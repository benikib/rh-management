<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Modifier le document</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-2xl">
        <form action="{{ route('documents.update', $document) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            @include('documents._form', ['document' => $document])
            @include('partials.form-actions', ['cancelRoute' => route('documents.index'), 'submitLabel' => 'Mettre à jour'])
        </form>
    </div>
</x-app-layout>
