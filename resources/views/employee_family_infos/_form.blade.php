@php
    $familyInfoModel = $employeeFamilyInfo ?? null;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <x-input-label for="employe_id" value="Employé" />
        <select id="employe_id" name="employe_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="">— Sélectionner —</option>
            @foreach ($employes as $employe)
                <option value="{{ $employe->id }}" @selected(old('employe_id', $familyInfoModel?->employe_id) == $employe->id)>
                    {{ $employe->nom_complet }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('employe_id')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="marital_status_id" value="Statut marital" />
        <select id="marital_status_id" name="marital_status_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="">— Sélectionner —</option>
            @foreach ($maritalStatuses as $status)
                <option value="{{ $status->id }}" @selected(old('marital_status_id', $familyInfoModel?->marital_status_id) == $status->id)>
                    {{ $status->label }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('marital_status_id')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="spouse_name" value="Nom du conjoint" />
        <x-text-input id="spouse_name" name="spouse_name" type="text" class="mt-1 block w-full"
                      :value="old('spouse_name', $familyInfoModel?->spouse_name)" />
        <x-input-error :messages="$errors->get('spouse_name')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="spouse_identity" value="Identité du conjoint" />
        <x-text-input id="spouse_identity" name="spouse_identity" type="text" class="mt-1 block w-full"
                      :value="old('spouse_identity', $familyInfoModel?->spouse_identity)" />
        <x-input-error :messages="$errors->get('spouse_identity')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="marriage_date" value="Date de mariage" />
        <x-text-input id="marriage_date" name="marriage_date" type="date" class="mt-1 block w-full"
                      :value="old('marriage_date', optional($familyInfoModel?->marriage_date)->format('Y-m-d'))" />
        <x-input-error :messages="$errors->get('marriage_date')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="number_of_children" value="Nombre d'enfants" />
        <x-text-input id="number_of_children" name="number_of_children" type="number" min="0" class="mt-1 block w-full"
                      :value="old('number_of_children', $familyInfoModel?->number_of_children)" />
        <x-input-error :messages="$errors->get('number_of_children')" class="mt-2" />
    </div>
    <div class="md:col-span-2">
        <x-input-label for="marriage_certificate" value="Justificatif de mariage" />
        <input id="marriage_certificate" name="marriage_certificate" type="file" accept="application/pdf,image/*"
               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
        <x-input-error :messages="$errors->get('marriage_certificate')" class="mt-2" />
        @if ($familyInfoModel?->marriage_certificate_path)
            <p class="mt-2 text-sm text-gray-500">Fichier actuel disponible.</p>
        @endif
    </div>
</div>
