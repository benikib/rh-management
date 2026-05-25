<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Nouveau critère</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-2xl mx-auto">
        <form action="{{ route('criteres.store') }}" method="POST" class="space-y-4">
            @csrf
            @include('criteres._form')
            @include('partials.form-actions', ['cancelRoute' => route('criteres.index')])
        </form>
    </div>
</x-app-layout>
