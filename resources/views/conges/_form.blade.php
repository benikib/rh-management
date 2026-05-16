@php
    $congeModel = $conge ?? null;
@endphp

<div>
    <x-input-label for="employe_id" value="Employé" />
    <select id="employe_id" name="employe_id" class="search-select mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        <option value="">— Sélectionner —</option>
        @foreach ($employes as $emp)
            <option value="{{ $emp->id }}" @selected(old('employe_id', $congeModel?->employe_id) == $emp->id)>
                {{ $emp->nom_complet }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('employe_id')" class="mt-2" />
</div>
<div>
    <x-input-label for="type_conge" value="Type de congé" />
    <x-text-input id="type_conge" name="type_conge" type="text" class="mt-1 block w-full"
                  :value="old('type_conge', $congeModel?->type_conge)" required />
    <x-input-error :messages="$errors->get('type_conge')" class="mt-2" />
</div>
<div>
    <x-input-label for="date_debut" value="Date de début" />
    <x-text-input id="date_debut" name="date_debut" type="date" class="mt-1 block w-full"
                  :value="old('date_debut', $congeModel?->date_debut?->format('Y-m-d'))" required />
    <x-input-error :messages="$errors->get('date_debut')" class="mt-2" />
</div>
<div>
    <x-input-label for="date_fin" value="Date de fin" />
    <x-text-input id="date_fin" name="date_fin" type="date" class="mt-1 block w-full"
                  :value="old('date_fin', $congeModel?->date_fin?->format('Y-m-d'))" required />
    <x-input-error :messages="$errors->get('date_fin')" class="mt-2" />
</div>
<div>
    <x-input-label for="motif" value="Motif" />
    <textarea id="motif" name="motif" rows="3"
              class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('motif', $congeModel?->motif) }}</textarea>
    <x-input-error :messages="$errors->get('motif')" class="mt-2" />
</div>
<div>
    <x-input-label for="statut" value="Statut" />
    <select id="statut" name="statut" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        @foreach (['En attente', 'Valide', 'Refuse'] as $statutOption)
            <option value="{{ $statutOption }}" @selected(old('statut', $congeModel?->statut ?? 'En attente') === $statutOption)>{{ $statutOption }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('statut')" class="mt-2" />
</div>
