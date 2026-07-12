@props(['contractType' => null])

<div class="space-y-6">
    <div>
        <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
        <input id="code" name="code" type="text" value="{{ old('code', $contractType->code ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
    </div>

    <div>
        <label for="label" class="block text-sm font-medium text-gray-700">Libellé</label>
        <input id="label" name="label" type="text" value="{{ old('label', $contractType->label ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea id="description" name="description" rows="4"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $contractType->description ?? '') }}</textarea>
    </div>

    <div class="flex items-center gap-3">
        <input id="requires_end_date" name="requires_end_date" type="checkbox" value="1"
               {{ old('requires_end_date', $contractType->requires_end_date ?? false) ? 'checked' : '' }}
               class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
        <label for="requires_end_date" class="text-sm text-gray-700">Nécessite une date de fin</label>
    </div>
</div>
