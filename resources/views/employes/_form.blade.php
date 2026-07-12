@php
    $employeModel = $employe ?? null;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <x-input-label for="departement_id" value="Département" />
        <select id="departement_id" name="departement_id" class="search-select mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="">— Sélectionner —</option>
            @foreach ($departements as $departement)
                <option value="{{ $departement->id }}" @selected(old('departement_id', $employeModel?->departement_id) == $departement->id)>
                    {{ $departement->nom }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('departement_id')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="poste_id" value="Poste" />
        <select id="poste_id" name="poste_id" class="search-select mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="">— Sélectionner —</option>
            @foreach ($postes as $poste)
                <option value="{{ $poste->id }}" @selected(old('poste_id', $employeModel?->poste_id) == $poste->id)>
                    {{ $poste->titre }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('poste_id')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="contract_type_id" value="Type de contrat" />
        <select id="contract_type_id" name="contract_type_id" class="search-select mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="">— Sélectionner —</option>
            @foreach ($contractTypes as $contractType)
                <option value="{{ $contractType->id }}"
                        @selected(old('contract_type_id', $employeModel?->activeContract?->contract_type_id) == $contractType->id)>
                    {{ $contractType->label }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('contract_type_id')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="matricule" value="Matricule" />
        <x-text-input id="matricule" name="matricule" type="text" class="mt-1 block w-full"
                      :value="old('matricule', $employeModel?->matricule)" required />
        <x-input-error :messages="$errors->get('matricule')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="nom" value="Nom" />
        <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full"
                      :value="old('nom', $employeModel?->nom)" required />
        <x-input-error :messages="$errors->get('nom')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="postnom" value="Postnom" />
        <x-text-input id="postnom" name="postnom" type="text" class="mt-1 block w-full"
                      :value="old('postnom', $employeModel?->postnom)" required />
        <x-input-error :messages="$errors->get('postnom')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="prenom" value="Prénom" />
        <x-text-input id="prenom" name="prenom" type="text" class="mt-1 block w-full"
                      :value="old('prenom', $employeModel?->prenom)" required />
        <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="sexe" value="Sexe" />
        <select id="sexe" name="sexe" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="Masculin" @selected(old('sexe', $employeModel?->sexe) === 'Masculin')>Masculin</option>
            <option value="Feminin" @selected(old('sexe', $employeModel?->sexe) === 'Feminin')>Féminin</option>
        </select>
        <x-input-error :messages="$errors->get('sexe')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="date_naissance" value="Date de naissance" />
        <x-text-input id="date_naissance" name="date_naissance" type="date" class="mt-1 block w-full"
                      :value="old('date_naissance', $employeModel?->date_naissance?->format('Y-m-d'))" required />
        <x-input-error :messages="$errors->get('date_naissance')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="telephone" value="Téléphone" />
        <x-text-input id="telephone" name="telephone" type="text" class="mt-1 block w-full"
                      :value="old('telephone', $employeModel?->telephone)" />
        <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="email" value="Email" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                      :value="old('email', $employeModel?->email)" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>
    <div class="md:col-span-2">
        <x-input-label for="adresse" value="Adresse" />
        <textarea id="adresse" name="adresse" rows="2"
                  class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('adresse', $employeModel?->adresse) }}</textarea>
        <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="photo" value="Photo" />
        <input id="photo" name="photo" type="file" accept="image/*"
               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
        <x-input-error :messages="$errors->get('photo')" class="mt-2" />
        @if ($employeModel?->photo)
            <p class="mt-2 text-sm text-gray-500">Photo actuelle enregistrée.</p>
        @endif
    </div>
    <div>
        <x-input-label for="date_embauche" value="Date d'embauche" />
        <x-text-input id="date_embauche" name="date_embauche" type="date" class="mt-1 block w-full"
                      :value="old('date_embauche', $employeModel?->date_embauche?->format('Y-m-d'))" required />
        <x-input-error :messages="$errors->get('date_embauche')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="salaire_base" value="Salaire de base" />
        <x-text-input id="salaire_base" name="salaire_base" type="number" step="0.01" min="0"
                      class="mt-1 block w-full"
                      :value="old('salaire_base', $employeModel?->salaire_base)" required />
        <x-input-error :messages="$errors->get('salaire_base')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="status_id" value="Statut RH" />
        <select id="status_id" name="status_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            <option value="">— Sélectionner —</option>
            @foreach ($employeeStatuses as $employeeStatus)
                <option value="{{ $employeeStatus->id }}" @selected(old('status_id', $employeModel?->status_id) == $employeeStatus->id)>
                    {{ $employeeStatus->label }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('status_id')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="statut" value="Statut" />
        <select id="statut" name="statut" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="Actif" @selected(old('statut', $employeModel?->statut ?? 'Actif') === 'Actif')>Actif</option>
            <option value="Inactif" @selected(old('statut', $employeModel?->statut) === 'Inactif')>Inactif</option>
        </select>
        <x-input-error :messages="$errors->get('statut')" class="mt-2" />
    </div>
</div>
