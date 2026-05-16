@props(['cancelRoute', 'submitLabel' => 'Enregistrer'])

<div class="flex gap-3 pt-4">
    <x-primary-button>{{ $submitLabel }}</x-primary-button>
    <a href="{{ $cancelRoute }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm hover:bg-gray-300">
        Annuler
    </a>
</div>
