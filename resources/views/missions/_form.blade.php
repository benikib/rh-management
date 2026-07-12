<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <x-input-label for="employe_id" value="Employé" />
        <select id="employe_id" name="employe_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="">— Sélectionner —</option>
            @foreach ($employes as $employee)
                <option value="{{ $employee->id }}" @selected(old('employe_id', $mission->employe_id ?? null) == $employee->id)>
                    {{ $employee->nom_complet }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('employe_id')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="title" value="Titre" />
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                      :value="old('title', $mission->title ?? null)" required />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="lieu" value="Lieu" />
        <x-text-input id="lieu" name="lieu" type="text" class="mt-1 block w-full"
                      :value="old('lieu', $mission->lieu ?? null)" />
        <x-input-error :messages="$errors->get('lieu')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="motif" value="Motif" />
        <x-text-input id="motif" name="motif" type="text" class="mt-1 block w-full"
                      :value="old('motif', $mission->motif ?? null)" />
        <x-input-error :messages="$errors->get('motif')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="date_debut" value="Date de début" />
        <x-text-input id="date_debut" name="date_debut" type="date" class="mt-1 block w-full"
                      :value="old('date_debut', optional($mission->date_debut ?? null)->format('Y-m-d'))" required />
        <x-input-error :messages="$errors->get('date_debut')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="date_fin" value="Date de fin" />
        <x-text-input id="date_fin" name="date_fin" type="date" class="mt-1 block w-full"
                      :value="old('date_fin', optional($mission->date_fin ?? null)->format('Y-m-d'))" />
        <x-input-error :messages="$errors->get('date_fin')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="frais_montant" value="Frais (montant)" />
        <x-text-input id="frais_montant" name="frais_montant" type="number" step="0.01" min="0" class="mt-1 block w-full"
                      :value="old('frais_montant', $mission->frais_montant ?? null)" />
        <x-input-error :messages="$errors->get('frais_montant')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="statut" value="Statut" />
        <select id="statut" name="statut" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            @foreach (['planifiee' => 'Planifiée', 'en_cours' => 'En cours', 'terminee' => 'Terminée', 'annulee' => 'Annulée'] as $value => $label)
                <option value="{{ $value }}" @selected(old('statut', $mission->statut ?? 'planifiee') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('statut')" class="mt-2" />
    </div>
    <div class="md:col-span-2">
        <x-input-label for="description" value="Description" />
        <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $mission->description ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>
    <div class="md:col-span-2">
        <x-input-label for="observations" value="Observations" />
        <textarea id="observations" name="observations" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('observations', $mission->observations ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('observations')" class="mt-2" />
    </div>
</div>
