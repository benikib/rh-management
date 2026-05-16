@php
    $documentModel = $document ?? null;
@endphp

<div>
    <x-input-label for="employe_id" value="Employé" />
    <select id="employe_id" name="employe_id" class="search-select mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        <option value="">— Sélectionner —</option>
        @foreach ($employes as $emp)
            <option value="{{ $emp->id }}" @selected(old('employe_id', $documentModel?->employe_id) == $emp->id)>
                {{ $emp->nom_complet }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('employe_id')" class="mt-2" />
</div>
<div>
    <x-input-label for="nom_document" value="Nom du document" />
    <x-text-input id="nom_document" name="nom_document" type="text" class="mt-1 block w-full"
                  :value="old('nom_document', $documentModel?->nom_document)" required />
    <x-input-error :messages="$errors->get('nom_document')" class="mt-2" />
</div>
<div>
    <x-input-label for="fichier" value="Fichier" />
    <input id="fichier" name="fichier" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
           @unless($documentModel) required @endunless />
    <x-input-error :messages="$errors->get('fichier')" class="mt-2" />
    @if ($documentModel?->fichier)
        <p class="mt-2 text-sm text-gray-500">Fichier actuel : {{ basename($documentModel->fichier) }}</p>
    @endif
</div>
<div>
    <x-input-label for="type_document" value="Type de document" />
    <x-text-input id="type_document" name="type_document" type="text" class="mt-1 block w-full"
                  :value="old('type_document', $documentModel?->type_document)" required />
    <x-input-error :messages="$errors->get('type_document')" class="mt-2" />
</div>
