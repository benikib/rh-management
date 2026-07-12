<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <x-input-label for="direction_id" value="Direction" />
        <select id="direction_id" name="direction_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="">— Sélectionner —</option>
            @foreach ($directions as $direction)
                <option value="{{ $direction->id }}" @selected(old('direction_id', $personnelTask->direction_id ?? null) == $direction->id)>{{ $direction->nom }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('direction_id')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="departement_id" value="Département" />
        <select id="departement_id" name="departement_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="">— Sélectionner —</option>
            @foreach ($departements as $departement)
                <option value="{{ $departement->id }}" @selected(old('departement_id', $personnelTask->departement_id ?? null) == $departement->id)>{{ $departement->nom }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('departement_id')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="assigned_by_id" value="Assigné par" />
        <select id="assigned_by_id" name="assigned_by_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="">— Sélectionner —</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected(old('assigned_by_id', $personnelTask->assigned_by_id ?? auth()->id()) == $user->id)>{{ $user->name }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('assigned_by_id')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="assigned_to_id" value="Assigné à" />
        <select id="assigned_to_id" name="assigned_to_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            <option value="">— Sélectionner —</option>
            @foreach ($employes as $employe)
                <option value="{{ $employe->id }}" @selected(old('assigned_to_id', $personnelTask->assigned_to_id ?? null) == $employe->id)>{{ $employe->nom_complet }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('assigned_to_id')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="title" value="Titre" />
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                      :value="old('title', $personnelTask->title ?? null)" required />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="priority" value="Priorité" />
        <select id="priority" name="priority" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            @foreach (['low' => 'Faible', 'medium' => 'Moyenne', 'high' => 'Élevée', 'urgent' => 'Urgente'] as $value => $label)
                <option value="{{ $value }}" @selected(old('priority', $personnelTask->priority ?? 'medium') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <x-input-label for="status" value="Statut" />
        <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            @foreach (['pending' => 'En attente', 'in_progress' => 'En cours', 'completed' => 'Terminée', 'cancelled' => 'Annulée'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $personnelTask->status ?? 'pending') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <x-input-label for="due_date" value="Échéance" />
        <x-text-input id="due_date" name="due_date" type="date" class="mt-1 block w-full"
                      :value="old('due_date', optional($personnelTask->due_date ?? null)->format('Y-m-d'))" />
    </div>
    <div class="md:col-span-2">
        <x-input-label for="description" value="Description" />
        <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $personnelTask->description ?? '') }}</textarea>
    </div>
    <div class="md:col-span-2">
        <x-input-label for="notes" value="Notes" />
        <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('notes', $personnelTask->notes ?? '') }}</textarea>
    </div>
</div>
