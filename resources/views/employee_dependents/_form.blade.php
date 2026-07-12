@php
    $dependentModel = $employeeDependent ?? null;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <x-input-label for="employe_id" value="Employé" />
        <select id="employe_id" name="employe_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="">— Sélectionner —</option>
            @foreach ($employes as $employe)
                <option value="{{ $employe->id }}" @selected(old('employe_id', $dependentModel?->employe_id) == $employe->id)>
                    {{ $employe->nom_complet }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('employe_id')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="full_name" value="Nom complet" />
        <x-text-input id="full_name" name="full_name" type="text" class="mt-1 block w-full"
                      :value="old('full_name', $dependentModel?->full_name)" required />
        <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="type" value="Type" />
        <x-text-input id="type" name="type" type="text" class="mt-1 block w-full"
                      :value="old('type', $dependentModel?->type)" required />
        <x-input-error :messages="$errors->get('type')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="birth_date" value="Date de naissance" />
        <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full"
                      :value="old('birth_date', optional($dependentModel?->birth_date)->format('Y-m-d'))" required />
        <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="identity_number" value="Numéro d'identité" />
        <x-text-input id="identity_number" name="identity_number" type="text" class="mt-1 block w-full"
                      :value="old('identity_number', $dependentModel?->identity_number)" />
        <x-input-error :messages="$errors->get('identity_number')" class="mt-2" />
    </div>
    <div class="flex items-center gap-4">
        <label class="flex items-center gap-2">
            <input type="checkbox" name="is_student" value="1" @checked(old('is_student', $dependentModel?->is_student)) class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
            <span class="text-sm text-gray-700">Étudiant</span>
        </label>
        <label class="flex items-center gap-2">
            <input type="checkbox" name="is_schooled" value="1" @checked(old('is_schooled', $dependentModel?->is_schooled)) class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
            <span class="text-sm text-gray-700">Scolarisé</span>
        </label>
    </div>
    <div class="md:col-span-2">
        <x-input-label for="school_certificate" value="Attestation scolaire" />
        <input id="school_certificate" name="school_certificate" type="file" accept="application/pdf,image/*"
               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
        <x-input-error :messages="$errors->get('school_certificate')" class="mt-2" />
    </div>
    <div class="md:col-span-2">
        <x-input-label for="family_composition_document" value="Document de composition familiale" />
        <input id="family_composition_document" name="family_composition_document" type="file" accept="application/pdf,image/*"
               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
        <x-input-error :messages="$errors->get('family_composition_document')" class="mt-2" />
    </div>
</div>
