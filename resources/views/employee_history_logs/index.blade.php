<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Journal RH</h2>
            <a href="{{ route('employee-history-logs.create') }}" class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold hover:bg-gray-100">
                <i class="fa-solid fa-plus mr-2"></i> Nouveau log
            </a>
        </div>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employé</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Événement</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Enregistré par</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($logs as $log)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $log->employe?->nom_complet ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ App\Models\EmployeeHistoryLog::getEventTypeLabel($log->event_type) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ optional($log->event_date)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $log->status?->label ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $log->recordedBy?->name ?? auth()->user()?->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-right">
                                @include('partials.crud-actions', ['routePrefix' => 'employee-history-logs', 'model' => $log])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">Aucun journal RH trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t">
            {{ $logs->links() }}
        </div>
    </div>
</x-app-layout>
