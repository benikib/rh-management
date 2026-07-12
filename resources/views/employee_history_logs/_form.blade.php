@php
    $log = $employeeHistoryLog ?? null;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <x-input-label for="employe_id" value="Employé" />
        <select id="employe_id" name="employe_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="">— Sélectionner —</option>
            @foreach ($employes as $employe)
                <option value="{{ $employe->id }}" @selected(old('employe_id', $log?->employe_id) == $employe->id)>
                    {{ $employe->nom_complet }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('employe_id')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="event_type" value="Type d'événement" />
        <select id="event_type" name="event_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="">— Sélectionner —</option>
            @foreach ($eventTypeOptions as $key => $label)
                <option value="{{ $key }}" @selected(old('event_type', $log?->event_type) == $key)>{{ $label }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('event_type')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="event_date" value="Date de l'événement" />
        <x-text-input id="event_date" name="event_date" type="date" class="mt-1 block w-full"
                      :value="old('event_date', optional($log?->event_date)->format('Y-m-d'))" required />
        <x-input-error :messages="$errors->get('event_date')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="status_id" value="Statut RH" />
        <select id="status_id" name="status_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            <option value="">— Aucun —</option>
            @foreach ($statuses as $status)
                <option value="{{ $status->id }}" @selected(old('status_id', $log?->status_id) == $status->id)>
                    {{ $status->label }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('status_id')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="recorded_by_id" value="Enregistré par" />
        <select id="recorded_by_id" name="recorded_by_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            <option value="">— Utilisateur actuel —</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected(old('recorded_by_id', $log?->recorded_by_id) == $user->id)>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('recorded_by_id')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="reason" value="Raison" />
        <textarea id="reason" name="reason" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('reason', $log?->reason) }}</textarea>
        <x-input-error :messages="$errors->get('reason')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="notes" value="Notes" />
        <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('notes', $log?->notes) }}</textarea>
        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
    </div>
</div>
