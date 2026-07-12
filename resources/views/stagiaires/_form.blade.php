@php
    $stagiaireModel = $stagiaire ?? null;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <x-input-label for="departement_id" value="Département" />
        <select id="departement_id" name="departement_id" class="search-select mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="">— Sélectionner —</option>
            @foreach ($departements as $departement)
                <option value="{{ $departement->id }}" @selected(old('departement_id', $stagiaireModel?->departement_id) == $departement->id)>
                    {{ $departement->nom }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('departement_id')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="nom" value="Nom" />
        <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full"
                      :value="old('nom', $stagiaireModel?->nom)" required />
        <x-input-error :messages="$errors->get('nom')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="postnom" value="Postnom" />
        <x-text-input id="postnom" name="postnom" type="text" class="mt-1 block w-full"
                      :value="old('postnom', $stagiaireModel?->postnom)" required />
        <x-input-error :messages="$errors->get('postnom')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="prenom" value="Prénom" />
        <x-text-input id="prenom" name="prenom" type="text" class="mt-1 block w-full"
                      :value="old('prenom', $stagiaireModel?->prenom)" required />
        <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="sexe" value="Sexe" />
        <select id="sexe" name="sexe" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="Masculin" @selected(old('sexe', $stagiaireModel?->sexe) === 'Masculin')>Masculin</option>
            <option value="Feminin" @selected(old('sexe', $stagiaireModel?->sexe) === 'Feminin')>Féminin</option>
        </select>
        <x-input-error :messages="$errors->get('sexe')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="date_naissance" value="Date de naissance" />
        <x-text-input id="date_naissance" name="date_naissance" type="date" class="mt-1 block w-full"
                      :value="old('date_naissance', $stagiaireModel?->date_naissance?->format('Y-m-d'))" required />
        <x-input-error :messages="$errors->get('date_naissance')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="telephone" value="Téléphone" />
        <x-text-input id="telephone" name="telephone" type="text" class="mt-1 block w-full"
                      :value="old('telephone', $stagiaireModel?->telephone)" />
        <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="email" value="Email" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                      :value="old('email', $stagiaireModel?->email)" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="adresse" value="Adresse" />
        <textarea id="adresse" name="adresse" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('adresse', $stagiaireModel?->adresse) }}</textarea>
        <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="universite" value="Université" />
        <x-text-input id="universite" name="universite" type="text" class="mt-1 block w-full"
                      :value="old('universite', $stagiaireModel?->universite)" required />
        <x-input-error :messages="$errors->get('universite')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="specialite" value="Spécialité" />
        <x-text-input id="specialite" name="specialite" type="text" class="mt-1 block w-full"
                      :value="old('specialite', $stagiaireModel?->specialite)" required />
        <x-input-error :messages="$errors->get('specialite')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="date_debut_stage" value="Date de début" />
        <x-text-input id="date_debut_stage" name="date_debut_stage" type="date" class="mt-1 block w-full"
                      :value="old('date_debut_stage', $stagiaireModel?->date_debut_stage?->format('Y-m-d'))" required />
        <x-input-error :messages="$errors->get('date_debut_stage')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="date_fin_stage" value="Date de fin" />
        <x-text-input id="date_fin_stage" name="date_fin_stage" type="date" class="mt-1 block w-full"
                      :value="old('date_fin_stage', $stagiaireModel?->date_fin_stage?->format('Y-m-d'))" required />
        <x-input-error :messages="$errors->get('date_fin_stage')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="encadrant_id" value="Encadrant (Superviseur)" />
        <select id="encadrant_id" name="encadrant_id" class="search-select mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            <option value="">— Sélectionner —</option>
            @foreach ($employes as $employe)
                <option value="{{ $employe->id }}" @selected(old('encadrant_id', $stagiaireModel?->encadrant_id) == $employe->id)>
                    {{ $employe->nom_complet }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('encadrant_id')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="statut" value="Statut" />
        <select id="statut" name="statut" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="En cours" @selected(old('statut', $stagiaireModel?->statut) === 'En cours')>En cours</option>
            <option value="Terminé" @selected(old('statut', $stagiaireModel?->statut) === 'Terminé')>Terminé</option>
            <option value="Suspendu" @selected(old('statut', $stagiaireModel?->statut) === 'Suspendu')>Suspendu</option>
        </select>
        <x-input-error :messages="$errors->get('statut')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="observations" value="Observations" />
        <textarea id="observations" name="observations" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('observations', $stagiaireModel?->observations) }}</textarea>
        <x-input-error :messages="$errors->get('observations')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="photo" value="Photo" />
        <x-text-input id="photo" name="photo" type="file" accept="image/*" class="mt-1 block w-full" />
        <x-input-error :messages="$errors->get('photo')" class="mt-2" />
        @if ($stagiaireModel?->photo)
            <div class="mt-4">
                <p class="text-sm text-gray-600 mb-2">Photo actuelle :</p>
                <img src="{{ Storage::url($stagiaireModel->photo) }}" alt="Photo" class="w-24 h-24 rounded object-cover">
            </div>
        @endif
    </div>
</div>
