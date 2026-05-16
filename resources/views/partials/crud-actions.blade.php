@props(['routePrefix', 'model'])

<div class="flex items-center justify-end gap-2">
    <a href="{{ route($routePrefix.'.show', $model) }}"
       class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 rounded hover:bg-blue-100">
        <i class="fa-solid fa-eye mr-1"></i> Voir
    </a>
    <a href="{{ route($routePrefix.'.edit', $model) }}"
       class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-amber-700 bg-amber-50 rounded hover:bg-amber-100">
        <i class="fa-solid fa-pen mr-1"></i> Modifier
    </a>
    <form action="{{ route($routePrefix.'.destroy', $model) }}" method="POST"
          onsubmit="return confirm('Confirmer la suppression ?');">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-red-700 bg-red-50 rounded hover:bg-red-100">
            <i class="fa-solid fa-trash mr-1"></i> Supprimer
        </button>
    </form>
</div>
