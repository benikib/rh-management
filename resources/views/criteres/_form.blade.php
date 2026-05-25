@props(['critere' => null])

<div class="grid grid-cols-1 gap-4">
    <div>
        <x-input-label for="nom" value="Nom" />
        <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full" :value="old('nom', $critere->nom ?? '')" required />
        <x-input-error :messages="$errors->get('nom')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="description" value="Description" />
        <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $critere->description ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-input-label for="note_max" value="Note maximale" />
            <x-text-input id="note_max" name="note_max" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('note_max', $critere->note_max ?? '')" required />
            <x-input-error :messages="$errors->get('note_max')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="ponderation" value="Pondération (%)" />
            <x-text-input id="ponderation" name="ponderation" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('ponderation', $critere->ponderation ?? '')" required />
            <x-input-error :messages="$errors->get('ponderation')" class="mt-2" />
        </div>
    </div>
</div>
