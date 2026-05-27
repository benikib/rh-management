<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-white">Rapports RH</h2>
                <p class="text-sm text-gray-300">Générez des rapports PDF / Excel et consultez l'historique des exports.</p>
            </div>
        </div>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Module de rapports RH</h1>
            <p class="text-sm text-slate-600">Générez des rapports PDF/Excel et consultez l'historique des exports.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 p-4 text-emerald-800">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 rounded-lg bg-rose-50 border border-rose-200 p-4 text-rose-800">{{ session('error') }}</div>
    @endif

    <div class="grid gap-6 grid-cols-1 lg:grid-cols-[minmax(300px,360px)_1fr]">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm w-full">
            <h2 class="mb-4 text-lg font-semibold text-slate-900">Filtres de rapport</h2>

            <form method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Type de rapport</label>
                    <select name="report_type" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900">
                        @foreach($reportTypes as $key => $label)
                            <option value="{{ $key }}" {{ old('report_type', $filters['report_type'] ?? 'presence') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Période</label>
                    <select name="period" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900">
                        @foreach($periods as $key => $label)
                            <option value="{{ $key }}" {{ old('period', $filters['period'] ?? 'monthly') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Date de début</label>
                        <input type="date" name="start_date" value="{{ old('start_date', $filters['start_date'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm text-slate-900" />
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Date de fin</label>
                        <input type="date" name="end_date" value="{{ old('end_date', $filters['end_date'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm text-slate-900" />
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Direction</label>
                    <select name="direction_id" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900">
                        <option value="">Toutes</option>
                        @foreach($directions as $direction)
                            <option value="{{ $direction->id }}" {{ (string) old('direction_id', $filters['direction_id'] ?? '') === (string) $direction->id ? 'selected' : '' }}>{{ $direction->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Département</label>
                    <select name="department_id" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900">
                        <option value="">Tous</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ (string) old('department_id', $filters['department_id'] ?? '') === (string) $department->id ? 'selected' : '' }}>{{ $department->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Employé</label>
                    <select name="employe_id" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900">
                        <option value="">Tous</option>
                        @foreach($employees as $employe)
                            <option value="{{ $employe->id }}" {{ (string) old('employe_id', $filters['employe_id'] ?? '') === (string) $employe->id ? 'selected' : '' }}>{{ $employe->nom_complet }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Statut de présence</label>
                    <input type="text" name="status" value="{{ old('status', $filters['status'] ?? '') }}" placeholder="Present, Absent, Retard, Conge" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm text-slate-900" />
                </div>

                <div class="flex flex-col gap-3 pt-4 sm:flex-row">
                    <button type="submit" formaction="{{ route('reports.preview') }}" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Prévisualiser</button>
                    <button type="submit" formaction="{{ route('reports.export.excel') }}" class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-500">Exporter Excel</button>
                    <button type="submit" formaction="{{ route('reports.export.pdf') }}" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-500">Exporter PDF</button>
                </div>
            </form>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="mb-4 text-lg font-semibold text-slate-900">Aperçu du rapport</h2>

                @if(isset($report))
                    <div class="space-y-4">
                        <div class="rounded-2xl bg-slate-50 p-4 text-sm text-slate-800">
                            <div class="font-semibold text-slate-900">{{ $reportName }}</div>
                            <div class="mt-2 flex flex-wrap gap-3 text-slate-700">
                                <span class="rounded-full bg-white px-3 py-1 text-xs font-medium uppercase tracking-wide text-slate-600">Type: {{ $reportTypes[$filters['report_type']] ?? 'Rapport' }}</span>
                                <span class="rounded-full bg-white px-3 py-1 text-xs font-medium uppercase tracking-wide text-slate-600">Période: {{ $periods[$filters['period']] ?? $filters['period'] }}</span>
                                <span class="rounded-full bg-white px-3 py-1 text-xs font-medium uppercase tracking-wide text-slate-600">Du: {{ $filters['start_date'] }}</span>
                                <span class="rounded-full bg-white px-3 py-1 text-xs font-medium uppercase tracking-wide text-slate-600">Au: {{ $filters['end_date'] }}</span>
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($report['meta'] as $key => $value)
                                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                                    <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ ucfirst(str_replace('_', ' ', $key)) }}</div>
                                    <div class="mt-2 text-xl font-semibold text-slate-900">{{ is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : $value }}</div>
                                </div>
                            @endforeach
                        </div>

                        @if(isset($report['calendar']))
                            @php
                                $presenceStatusClasses = [
                                    'on_time' => 'bg-emerald-500 text-white border-emerald-500',
                                    'absent_unjustified' => 'bg-red-500 text-white border-red-500',
                                    'early_departure' => 'bg-amber-400 text-slate-900 border-amber-400',
                                    'late_arrival' => 'bg-orange-500 text-white border-orange-500',
                                    'justified_absence' => 'bg-slate-900 text-white border-slate-900',
                                    'justified_early_departure' => 'bg-sky-300 text-slate-900 border-sky-300',
                                    'justified_late' => 'bg-sky-900 text-white border-sky-900',
                                    'holiday' => 'bg-violet-600 text-white border-violet-600',
                                    'empty' => 'bg-slate-100 text-slate-500 border-slate-200',
                                ];
                            @endphp

                            <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                                <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <h3 class="text-base font-semibold text-slate-900">Calendrier de présence</h3>
                                        <p class="text-sm text-slate-600">Vue calendrier par jour avec code couleur selon le statut de présence.</p>
                                    </div>
                                </div>

                                <table class="w-full min-w-full border-separate border-spacing-2 text-sm text-slate-700">
                                    <thead>
                                        <tr>
                                            @foreach(['Lun','Mar','Mer','Jeu','Ven','Sam','Dim'] as $dayName)
                                                <th class="px-2 py-2 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $dayName }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($report['calendar'] as $week)
                                            <tr>
                                                @foreach($week as $day)
                                                    <td class="align-top p-1">
                                                        @if($day['within_range'])
                                                            <div title="{{ $day['label'] . ($day['tooltip'] ? ': ' . $day['tooltip'] : '') }}" class="min-h-[100px] overflow-hidden rounded-2xl border p-3 text-[10px] leading-tight {{ $presenceStatusClasses[$day['status']] ?? 'bg-slate-100 text-slate-500 border-slate-200' }}">
                                                                <div class="text-xs font-semibold">{{ $day['date']->format('d') }}</div>
                                                                <div class="mt-2 whitespace-normal">{{ $day['label'] }}</div>
                                                            </div>
                                                        @else
                                                            <div class="min-h-[100px] rounded-2xl border border-transparent bg-transparent"></div>
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="mt-4 grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
                                    @foreach($report['legend'] as $item)
                                        <div class="rounded-2xl border border-slate-200 bg-white p-3">
                                            <div class="flex items-center gap-3">
                                                <span class="inline-flex h-3 w-3 flex-shrink-0 rounded-full {{ $item['bg'] }} {{ $item['text'] }}"></span>
                                                <span class="text-sm text-slate-700">{{ $item['label'] }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if(! empty($report['details']))
                            <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white p-4 shadow-sm w-full">
                                <h3 class="mb-3 text-base font-semibold text-slate-900">Détails</h3>
                                <table class="w-full min-w-full divide-y divide-slate-200 text-sm text-slate-700">
                                    <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500">
                                        <tr>
                                            @foreach(array_keys((array) $report['details'][0]) as $column)
                                                <th class="px-3 py-2">{{ ucfirst(str_replace('_', ' ', $column)) }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 bg-white">
                                        @foreach($report['details'] as $row)
                                            <tr>
                                                @foreach((array) $row as $value)
                                                    <td class="px-3 py-2 align-top break-words">{{ $value }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">Aucun détail disponible pour ce rapport.</div>
                        @endif
                    </div>
                @else
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6 text-sm text-slate-600">Sélectionnez les filtres puis cliquez sur "Prévisualiser" pour afficher le contenu du rapport.</div>
                @endif
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="mb-4 text-lg font-semibold text-slate-900">Historique des exports</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-slate-700">
                        <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="px-3 py-2">Nom</th>
                                <th class="px-3 py-2">Type</th>
                                <th class="px-3 py-2">Fichier</th>
                                <th class="px-3 py-2">Généré par</th>
                                <th class="px-3 py-2">Date</th>
                                <th class="px-3 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @foreach($history as $export)
                                <tr>
                                    <td class="px-3 py-3">{{ $export->report_name }}</td>
                                    <td class="px-3 py-3">{{ strtoupper($export->file_type) }}</td>
                                    <td class="px-3 py-3">{{ $export->file_name }}</td>
                                    <td class="px-3 py-3">{{ $export->generated_by ? $export->generatedBy->name ?? 'Utilisateur' : 'Système' }}</td>
                                    <td class="px-3 py-3">{{ $export->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('reports.download', $export) }}" class="rounded-xl bg-slate-900 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-700">Télécharger</a>
                                            <form action="{{ route('reports.destroy', $export) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-xl bg-rose-600 px-3 py-2 text-xs font-semibold text-white hover:bg-rose-500">Supprimer</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $history->links() }}</div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
