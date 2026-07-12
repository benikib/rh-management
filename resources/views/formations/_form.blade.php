@php
    $formationModel = $formation ?? null;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="md:col-span-2">
        <x-input-label for="employe_id" value="Employé" />
        <select id="employe_id" name="employe_id" class="search-select mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="">— Sélectionner —</option>
            @foreach ($employes as $employe)
                <option value="{{ $employe->id }}" @selected(old('employe_id', $formationModel?->employe_id) == $employe->id)>
                    {{ $employe->nom_complet }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('employe_id')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="titre" value="Titre de la formation" />
        <x-text-input id="titre" name="titre" type="text" class="mt-1 block w-full"
                      :value="old('titre', $formationModel?->titre)" required />
        <x-input-error :messages="$errors->get('titre')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="description" value="Description" />
        <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $formationModel?->description) }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="organisme_formation" value="Organisme de formation" />
        <x-text-input id="organisme_formation" name="organisme_formation" type="text" class="mt-1 block w-full"
                      :value="old('organisme_formation', $formationModel?->organisme_formation)" required />
        <x-input-error :messages="$errors->get('organisme_formation')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="duree_heures" value="Durée (heures)" />
        <x-text-input id="duree_heures" name="duree_heures" type="number" class="mt-1 block w-full"
                      :value="old('duree_heures', $formationModel?->duree_heures)" />
        <x-input-error :messages="$errors->get('duree_heures')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="date_debut" value="Date de début" />
        <x-text-input id="date_debut" name="date_debut" type="date" class="mt-1 block w-full"
                      :value="old('date_debut', $formationModel?->date_debut?->format('Y-m-d'))" required />
        <x-input-error :messages="$errors->get('date_debut')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="date_fin" value="Date de fin" />
        <x-text-input id="date_fin" name="date_fin" type="date" class="mt-1 block w-full"
                      :value="old('date_fin', $formationModel?->date_fin?->format('Y-m-d'))" required />
        <x-input-error :messages="$errors->get('date_fin')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="cout" value="Coût (€)" />
        <x-text-input id="cout" name="cout" type="number" step="0.01" class="mt-1 block w-full"
                      :value="old('cout', $formationModel?->cout)" />
        <x-input-error :messages="$errors->get('cout')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="statut" value="Statut" />
        <select id="statut" name="statut" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="Planifiée" @selected(old('statut', $formationModel?->statut) === 'Planifiée')>Planifiée</option>
            <option value="En cours" @selected(old('statut', $formationModel?->statut) === 'En cours')>En cours</option>
            <option value="Terminée" @selected(old('statut', $formationModel?->statut) === 'Terminée')>Terminée</option>
            <option value="Annulée" @selected(old('statut', $formationModel?->statut) === 'Annulée')>Annulée</option>
        </select>
        <x-input-error :messages="$errors->get('statut')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="competences" value="Compétences acquises" />
        <div class="mt-2 border border-gray-300 rounded-md p-4 max-h-64 overflow-y-auto">
            @forelse ($competences as $competence)
                <label class="flex items-center mb-3">
                    <input type="checkbox" name="competences[]" value="{{ $competence->id }}"
                           class="rounded border-gray-300 text-blue-600"
                           @checked(in_array($competence->id, old('competences', $selectedCompetences ?? [])))>
                    <span class="ml-2 text-sm text-gray-700">{{ $competence->nom }}</span>
                </label>
            @empty
                <p class="text-sm text-gray-500">Aucune compétence disponible</p>
            @endforelse
        </div>
        <x-input-error :messages="$errors->get('competences')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="certificat" value="Certificat" />
        <x-text-input id="certificat" name="certificat" type="file" accept=".pdf,.doc,.docx" class="mt-1 block w-full" />
        <x-input-error :messages="$errors->get('certificat')" class="mt-2" />
        @if ($formationModel?->certificat)
            <div class="mt-2">
                <p class="text-sm text-gray-600 mb-2">Certificat actuel : 
                    <a href="{{ Storage::url($formationModel->certificat) }}" class="text-blue-600 hover:underline" target="_blank">
                        <i class="fa-solid fa-download"></i> Télécharger
                    </a>
                </p>
            </div>
        @endif
    </div>

    <div class="md:col-span-2">
        <x-input-label for="observations" value="Observations" />
        <textarea id="observations" name="observations" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('observations', $formationModel?->observations) }}</textarea>
        <x-input-error :messages="$errors->get('observations')" class="mt-2" />
    </div>
</div>
