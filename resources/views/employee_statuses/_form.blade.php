@php
    $employeeStatusModel = $employeeStatus ?? null;
@endphp

<div class="grid grid-cols-1 gap-4">
    <div>
        <x-input-label for="code" value="Code" />
        <x-text-input id="code" name="code" type="text" class="mt-1 block w-full"
                      :value="old('code', $employeeStatusModel?->code)" required />
        <x-input-error :messages="$errors->get('code')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="label" value="Label" />
        <x-text-input id="label" name="label" type="text" class="mt-1 block w-full"
                      :value="old('label', $employeeStatusModel?->label)" required />
        <x-input-error :messages="$errors->get('label')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="description" value="Description" />
        <textarea id="description" name="description" rows="4"
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $employeeStatusModel?->description) }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>
</div>
