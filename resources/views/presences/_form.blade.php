@php
    $presenceModel = $presence ?? null;
@endphp

<div>
    <x-input-label for="employe_id" value="Employé" />
    <select id="employe_id" name="employe_id" class="search-select mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        <option value="">— Sélectionner —</option>
        @foreach ($employes as $emp)
            <option value="{{ $emp->id }}" @selected(old('employe_id', $presenceModel?->employe_id) == $emp->id)>
                {{ $emp->nom_complet }} ({{ $emp->matricule }})
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('employe_id')" class="mt-2" />
</div>
<div>
    <x-input-label for="date_presence" value="Date de présence" />
    <x-text-input id="date_presence" name="date_presence" type="date" class="mt-1 block w-full"
                  :value="old('date_presence', $presenceModel?->date_presence?->format('Y-m-d'))" required />
    <x-input-error :messages="$errors->get('date_presence')" class="mt-2" />
</div>
<div>
    <x-input-label for="heure_arrivee" value="Heure d'arrivée" />
    <x-text-input id="heure_arrivee" name="heure_arrivee" type="time" class="mt-1 block w-full"
                  :value="old('heure_arrivee', $presenceModel?->heure_arrivee ? substr($presenceModel->heure_arrivee, 0, 5) : null)" />
    <x-input-error :messages="$errors->get('heure_arrivee')" class="mt-2" />
</div>
<div>
    <x-input-label for="heure_depart" value="Heure de départ" />
    <x-text-input id="heure_depart" name="heure_depart" type="time" class="mt-1 block w-full"
                  :value="old('heure_depart', $presenceModel?->heure_depart ? substr($presenceModel->heure_depart, 0, 5) : null)" />
    <x-input-error :messages="$errors->get('heure_depart')" class="mt-2" />
</div>
<div>
    <x-input-label for="statut" value="Statut" />
    <select id="statut" name="statut" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        @foreach (['Present', 'Absent', 'Retard', 'Conge'] as $statutOption)
            <option value="{{ $statutOption }}" @selected(old('statut', $presenceModel?->statut) === $statutOption)>{{ $statutOption }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('statut')" class="mt-2" />
</div>
<div>
    <x-input-label for="remarque" value="Remarque" />
    <textarea id="remarque" name="remarque" rows="3"
              class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('remarque', $presenceModel?->remarque) }}</textarea>
    <x-input-error :messages="$errors->get('remarque')" class="mt-2" />
</div>
