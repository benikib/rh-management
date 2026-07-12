@php
    $history = $employeePositionHistory ?? null;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <x-input-label for="employe_id" value="Employé" />
        <select id="employe_id" name="employe_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="">— Sélectionner —</option>
            @foreach ($employes as $employe)
                <option value="{{ $employe->id }}" @selected(old('employe_id', $history?->employe_id) == $employe->id)>
                    {{ $employe->nom_complet }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('employe_id')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="poste_id" value="Poste" />
        <select id="poste_id" name="poste_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="">— Sélectionner —</option>
            @foreach ($postes as $poste)
                <option value="{{ $poste->id }}" @selected(old('poste_id', $history?->poste_id) == $poste->id)>
                    {{ $poste->titre }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('poste_id')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="departement_id" value="Département" />
        <select id="departement_id" name="departement_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="">— Sélectionner —</option>
            @foreach ($departements as $departement)
                <option value="{{ $departement->id }}" @selected(old('departement_id', $history?->departement_id) == $departement->id)>
                    {{ $departement->nom }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('departement_id')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="status" value="Statut" />
        <x-text-input id="status" name="status" type="text" class="mt-1 block w-full"
                      :value="old('status', $history?->status)" required />
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="start_date" value="Date de début" />
        <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full"
                      :value="old('start_date', optional($history?->start_date)->format('Y-m-d'))" required />
        <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="end_date" value="Date de fin" />
        <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full"
                      :value="old('end_date', optional($history?->end_date)->format('Y-m-d'))" />
        <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="supervisor_name" value="Nom du superviseur" />
        <x-text-input id="supervisor_name" name="supervisor_name" type="text" class="mt-1 block w-full"
                      :value="old('supervisor_name', $history?->supervisor_name)" />
        <x-input-error :messages="$errors->get('supervisor_name')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="observations" value="Observations" />
        <textarea id="observations" name="observations" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('observations', $history?->observations) }}</textarea>
        <x-input-error :messages="$errors->get('observations')" class="mt-2" />
    </div>
</div>
