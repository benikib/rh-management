@props(['criteres', 'evaluation' => null])

<div class="grid grid-cols-1 gap-4">
    <div>
        <x-input-label for="date_evaluation" value="Date d'évaluation" />
        <x-text-input id="date_evaluation" name="date_evaluation" type="date" class="mt-1 block w-full" :value="old('date_evaluation', optional($evaluation)->date_evaluation?->format('Y-m-d'))" required />
        <x-input-error :messages="$errors->get('date_evaluation')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="commentaire" value="Commentaire" />
        <textarea id="commentaire" name="commentaire" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('commentaire', $evaluation->commentaire ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('commentaire')" class="mt-2" />
    </div>

    <div class="bg-gray-50 rounded-xl p-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Critères évalués</h3>
            <span class="text-sm text-gray-600">Remplissez chaque note</span>
        </div>

        @error('criteres')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror

        @foreach($criteres as $index => $critere)
            @php
                $oldItem = old('criteres.' . $index, []);
                $existing = $evaluation ? $evaluation->criteres->firstWhere('critere_id', $critere->id) : null;
                $noteValue = $oldItem['note'] ?? $existing->note ?? '';
                $observationValue = $oldItem['observation'] ?? $existing->observation ?? '';
            @endphp

            <div class="rounded-lg border border-gray-200 p-4 mb-4 bg-white">
                <input type="hidden" name="criteres[{{ $index }}][critere_id]" value="{{ $critere->id }}">

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3 md:items-end">
                    <div class="md:col-span-1">
                        <h4 class="font-semibold text-gray-900">{{ $critere->nom }}</h4>
                        <p class="text-sm text-gray-600">{{ $critere->description ?: 'Pas de description.' }}</p>
                    </div>
                    <div>
                        <x-input-label for="criteres[{{ $index }}][note]" value="Note (max {{ $critere->note_max }})" />
                        <x-text-input id="criteres[{{ $index }}][note]" name="criteres[{{ $index }}][note]" type="number" step="0.01" min="0" max="{{ $critere->note_max }}" class="mt-1 block w-full" value="{{ $noteValue }}" required />
                        <x-input-error :messages="$errors->get('criteres.' . $index . '.note')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="criteres[{{ $index }}][observation]" value="Observation" />
                        <textarea id="criteres[{{ $index }}][observation]" name="criteres[{{ $index }}][observation]" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $observationValue }}</textarea>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
