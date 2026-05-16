@php
    $carriereModel = $carriere ?? null;
@endphp

<div>
    <x-input-label for="employe_id" value="Employé" />
    <select id="employe_id" name="employe_id" class="search-select mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        <option value="">— Sélectionner —</option>
        @foreach ($employes as $emp)
            <option value="{{ $emp->id }}" @selected(old('employe_id', $carriereModel?->employe_id) == $emp->id)>
                {{ $emp->nom_complet }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('employe_id')" class="mt-2" />
</div>
<div>
    <x-input-label for="ancien_poste_id" value="Ancien poste (optionnel)" />
    <select id="ancien_poste_id" name="ancien_poste_id" class="search-select mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        <option value="">— Aucun —</option>
        @foreach ($postes as $poste)
            <option value="{{ $poste->id }}" @selected(old('ancien_poste_id', $carriereModel?->ancien_poste_id) == $poste->id)>
                {{ $poste->titre }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('ancien_poste_id')" class="mt-2" />
</div>
<div>
    <x-input-label for="nouveau_poste_id" value="Nouveau poste" />
    <select id="nouveau_poste_id" name="nouveau_poste_id" class="search-select mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        <option value="">— Sélectionner —</option>
        @foreach ($postes as $poste)
            <option value="{{ $poste->id }}" @selected(old('nouveau_poste_id', $carriereModel?->nouveau_poste_id) == $poste->id)>
                {{ $poste->titre }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('nouveau_poste_id')" class="mt-2" />
</div>
<div>
    <x-input-label for="type_mouvement" value="Type de mouvement" />
    <select id="type_mouvement" name="type_mouvement" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        <option value="Promotion" @selected(old('type_mouvement', $carriereModel?->type_mouvement) === 'Promotion')>Promotion</option>
        <option value="Mutation" @selected(old('type_mouvement', $carriereModel?->type_mouvement) === 'Mutation')>Mutation</option>
    </select>
    <x-input-error :messages="$errors->get('type_mouvement')" class="mt-2" />
</div>
<div>
    <x-input-label for="date_changement" value="Date du changement" />
    <x-text-input id="date_changement" name="date_changement" type="date" class="mt-1 block w-full"
                  :value="old('date_changement', $carriereModel?->date_changement?->format('Y-m-d'))" required />
    <x-input-error :messages="$errors->get('date_changement')" class="mt-2" />
</div>
<div>
    <x-input-label for="commentaire" value="Commentaire" />
    <textarea id="commentaire" name="commentaire" rows="3"
              class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('commentaire', $carriereModel?->commentaire) }}</textarea>
    <x-input-error :messages="$errors->get('commentaire')" class="mt-2" />
</div>
