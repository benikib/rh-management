<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-white">Dashboard RH</h2>
                <p class="text-sm text-gray-300">Tableau de bord analytique des présences, évaluations et performances.</p>
            </div>
            <div class="space-x-2">
                <button onclick="window.print()" class="inline-flex items-center rounded-lg bg-slate-700 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-600 transition">
                    <i class="fa-solid fa-print mr-2"></i>Imprimer
                </button>
                <button onclick="exportTableToCsv('dashboard-departments.csv', 'departments-table')" class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-500 transition">
                    <i class="fa-solid fa-file-export mr-2"></i>Exporter CSV
                </button>
            </div>
        </div>
    </x-slot>

    <div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        <div class="rounded-3xl border border-slate-800 bg-slate-950 p-5 shadow-lg">
            <p class="text-sm uppercase tracking-[0.16em] text-slate-400">Employés actifs</p>
            <p class="mt-4 text-4xl font-bold text-white">{{ $globalMetrics['total_employes'] }}</p>
        </div>
        <div class="rounded-3xl border border-slate-800 bg-slate-950 p-5 shadow-lg">
            <p class="text-sm uppercase tracking-[0.16em] text-slate-400">Masculin</p>
            <p class="mt-4 text-4xl font-bold text-sky-400">{{ $globalMetrics['total_masculin'] ?? 0 }}</p>
        </div>
        <div class="rounded-3xl border border-slate-800 bg-slate-950 p-5 shadow-lg">
            <p class="text-sm uppercase tracking-[0.16em] text-slate-400">Féminin</p>
            <p class="mt-4 text-4xl font-bold text-pink-400">{{ $globalMetrics['total_feminin'] ?? 0 }}</p>
        </div>
        <div class="rounded-3xl border border-slate-800 bg-slate-950 p-5 shadow-lg">
            <p class="text-sm uppercase tracking-[0.16em] text-slate-400">Présents aujourd'hui</p>
            <p class="mt-4 text-4xl font-bold text-emerald-400">{{ $globalMetrics['present_today'] }}</p>
        </div>
        <div class="rounded-3xl border border-slate-800 bg-slate-950 p-5 shadow-lg">
            <p class="text-sm uppercase tracking-[0.16em] text-slate-400">Absents aujourd'hui</p>
            <p class="mt-4 text-4xl font-bold text-rose-400">{{ $globalMetrics['absent_today'] }}</p>
        </div>
        <div class="rounded-3xl border border-slate-800 bg-slate-950 p-5 shadow-lg">
            <p class="text-sm uppercase tracking-[0.16em] text-slate-400">Retards aujourd'hui</p>
            <p class="mt-4 text-4xl font-bold text-amber-400">{{ $globalMetrics['late_today'] }}</p>
        </div>
        <div class="rounded-3xl border border-slate-800 bg-slate-950 p-5 shadow-lg">
            <p class="text-sm uppercase tracking-[0.16em] text-slate-400">Taux de présence</p>
            <p class="mt-4 text-4xl font-bold text-cyan-400">{{ $globalMetrics['attendance_rate'] }}%</p>
        </div>
        <div class="rounded-3xl border border-slate-800 bg-slate-950 p-5 shadow-lg">
            <p class="text-sm uppercase tracking-[0.16em] text-slate-400">Moyenne des évaluations</p>
            <p class="mt-4 text-4xl font-bold text-violet-400">{{ $globalMetrics['average_evaluation'] }}</p>
        </div>
    </div>

    <div class="mb-6 grid gap-4 xl:grid-cols-3">
        <div class="rounded-3xl border border-slate-800 bg-slate-950 p-5 shadow-lg">
            <p class="text-sm uppercase tracking-[0.16em] text-slate-400">Meilleur département</p>
            <p class="mt-4 text-2xl font-semibold text-white">{{ $globalMetrics['best_department']['nom'] ?? 'N/A' }}</p>
            <p class="text-sm text-slate-400">Score: {{ $globalMetrics['best_department']['average_score'] ?? '0.00' }}</p>
        </div>
        <div class="rounded-3xl border border-slate-800 bg-slate-950 p-5 shadow-lg">
            <p class="text-sm uppercase tracking-[0.16em] text-slate-400">Meilleure direction</p>
            <p class="mt-4 text-2xl font-semibold text-white">{{ $globalMetrics['best_direction']['nom'] ?? 'N/A' }}</p>
            <p class="text-sm text-slate-400">Score: {{ $globalMetrics['best_direction']['average_score'] ?? '0.00' }}</p>
        </div>
        <div class="rounded-3xl border border-slate-800 bg-slate-950 p-5 shadow-lg">
            <p class="text-sm uppercase tracking-[0.16em] text-slate-400">Employé du mois</p>
            <p class="mt-4 text-2xl font-semibold text-white">{{ $globalMetrics['top_employees'][0]['nom_complet'] ?? 'N/A' }}</p>
            <p class="text-sm text-slate-400">Score: {{ $globalMetrics['top_employees'][0]['score'] ?? '0.00' }}</p>
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-2">
        <div class="rounded-3xl border border-slate-800 bg-slate-950 p-5 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-white">Evolution des présences</h3>
                    <p class="text-sm text-slate-400">14 derniers jours</p>
                </div>
            </div>
            <div class="mt-5 h-80">
                <canvas id="attendanceTrendChart" class="h-full w-full"></canvas>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-800 bg-slate-950 p-5 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-white">Moyenne des évaluations</h3>
                    <p class="text-sm text-slate-400">6 derniers mois</p>
                </div>
            </div>
            <div class="mt-5 h-80">
                <canvas id="evaluationTrendChart" class="h-full w-full"></canvas>
            </div>
        </div>
    </div>

    <div class="mt-6 grid gap-4 xl:grid-cols-2">
        <div class="rounded-3xl border border-slate-800 bg-slate-950 p-5 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-white">Comparaison des départements</h3>
                    <p class="text-sm text-slate-400">Présence et performance</p>
                </div>
            </div>
            <div class="mt-5 h-80">
                <canvas id="departmentComparisonChart" class="h-full w-full"></canvas>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-800 bg-slate-950 p-5 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-white">Comparaison des directions</h3>
                    <p class="text-sm text-slate-400">Performance globale</p>
                </div>
            </div>
            <div class="mt-5 h-80">
                <canvas id="directionComparisonChart" class="h-full w-full"></canvas>
            </div>
        </div>
    </div>

    <div class="mt-6 grid gap-4 lg:grid-cols-2">
        <div class="rounded-3xl border border-slate-800 bg-slate-950 p-5 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-white">Histogramme des performances</h3>
                    <p class="text-sm text-slate-400">Répartition des notes d'évaluation</p>
                </div>
            </div>
            <div class="mt-5 h-80">
                <canvas id="scoreHistogramChart" class="h-full w-full"></canvas>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-800 bg-slate-950 p-5 shadow-lg">
            <h3 class="text-lg font-semibold text-white">Top 5 meilleurs employés</h3>
            <div class="mt-5 overflow-hidden rounded-3xl border border-slate-800 bg-slate-900">
                <table class="min-w-full divide-y divide-slate-800 text-sm text-slate-300">
                    <thead class="bg-slate-950 text-left text-xs uppercase text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Employé</th>
                            <th class="px-4 py-3">Score</th>
                            <th class="px-4 py-3">Évaluations</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @foreach ($globalMetrics['top_employees'] as $employee)
                            <tr>
                                <td class="px-4 py-3">{{ $employee['nom_complet'] }}</td>
                                <td class="px-4 py-3">{{ $employee['score'] }}</td>
                                <td class="px-4 py-3">{{ $employee['evaluations'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-white">Top 5 moins performants</h3>
                <div class="mt-4 overflow-hidden rounded-3xl border border-slate-800 bg-slate-900">
                    <table class="min-w-full divide-y divide-slate-800 text-sm text-slate-300">
                        <thead class="bg-slate-950 text-left text-xs uppercase text-slate-500">
                            <tr>
                                <th class="px-4 py-3">Employé</th>
                                <th class="px-4 py-3">Score</th>
                                <th class="px-4 py-3">Évaluations</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @foreach ($globalMetrics['bottom_employees'] as $employee)
                                <tr>
                                    <td class="px-4 py-3">{{ $employee['nom_complet'] }}</td>
                                    <td class="px-4 py-3">{{ $employee['score'] }}</td>
                                    <td class="px-4 py-3">{{ $employee['evaluations'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 grid gap-4 lg:grid-cols-2">
        <div class="rounded-3xl border border-slate-800 bg-slate-950 p-5 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-white">Données par département</h3>
                    <p class="text-sm text-slate-400">Filtrer, trier et analyser par département.</p>
                </div>
                <input id="departmentSearch" type="text" placeholder="Rechercher département" class="rounded-2xl border border-slate-800 bg-slate-900 px-4 py-2 text-sm text-white outline-none focus:border-blue-500" />
            </div>
            <div class="mt-5 overflow-hidden rounded-3xl border border-slate-800 bg-slate-900">
                <table id="departments-table" class="min-w-full divide-y divide-slate-800 text-sm text-slate-300">
                    <thead class="bg-slate-950 text-left text-xs uppercase text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Département</th>
                            <th class="px-4 py-3">Direction</th>
                            <th class="px-4 py-3">Effectif</th>
                            <th class="px-4 py-3">Présence %</th>
                            <th class="px-4 py-3">Moyenne notes</th>
                            <th class="px-4 py-3">Retards</th>
                            <th class="px-4 py-3">Absences</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @foreach ($departmentMetrics as $department)
                            <tr>
                                <td class="px-4 py-3">{{ $department['nom'] }}</td>
                                <td class="px-4 py-3">{{ $department['direction'] ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $department['effectif_total'] }}</td>
                                <td class="px-4 py-3">{{ $department['taux_presence'] }}%</td>
                                <td class="px-4 py-3">{{ $department['moyenne_evaluations'] }}</td>
                                <td class="px-4 py-3">{{ $department['retards'] }}</td>
                                <td class="px-4 py-3">{{ $department['absences'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-800 bg-slate-950 p-5 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-white">Données par direction</h3>
                    <p class="text-sm text-slate-400">Comparer les directions et les tendances RH.</p>
                </div>
                <input id="directionSearch" type="text" placeholder="Rechercher direction" class="rounded-2xl border border-slate-800 bg-slate-900 px-4 py-2 text-sm text-white outline-none focus:border-blue-500" />
            </div>
            <div class="mt-5 overflow-hidden rounded-3xl border border-slate-800 bg-slate-900">
                <table id="directions-table" class="min-w-full divide-y divide-slate-800 text-sm text-slate-300">
                    <thead class="bg-slate-950 text-left text-xs uppercase text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Direction</th>
                            <th class="px-4 py-3">Effectif</th>
                            <th class="px-4 py-3">Masculin</th>
                            <th class="px-4 py-3">Féminin</th>
                            <th class="px-4 py-3">Présence %</th>
                            <th class="px-4 py-3">Moyenne notes</th>
                            <th class="px-4 py-3">Retards</th>
                            <th class="px-4 py-3">Absences</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @foreach ($directionMetrics as $direction)
                            <tr>
                                <td class="px-4 py-3">{{ $direction['nom'] }}</td>
                                <td class="px-4 py-3">{{ $direction['effectif_total'] }}</td>
                                <td class="px-4 py-3">{{ $direction['masculin'] ?? 0 }}</td>
                                <td class="px-4 py-3">{{ $direction['feminin'] ?? 0 }}</td>
                                <td class="px-4 py-3">{{ $direction['taux_presence'] }}%</td>
                                <td class="px-4 py-3">{{ $direction['moyenne_evaluations'] }}</td>
                                <td class="px-4 py-3">{{ $direction['retards'] }}</td>
                                <td class="px-4 py-3">{{ $direction['absences'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const attendanceTrend = @json($attendanceTrend);
        const evaluationTrend = @json($evaluationTrend);
        const departmentComparison = @json($departmentComparison);
        const directionComparison = @json($directionComparison);
        const scoreHistogram = @json($scoreHistogram);

        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: { color: '#CBD5E1' }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                x: {
                    ticks: { color: '#94A3B8' },
                    grid: { color: 'rgba(148,163,184,0.1)' }
                },
                y: {
                    ticks: { color: '#94A3B8' },
                    grid: { color: 'rgba(148,163,184,0.1)' }
                }
            }
        };

        function initCharts() {
            if (typeof Chart === 'undefined') {
                return setTimeout(initCharts, 150);
            }

            new Chart(document.getElementById('attendanceTrendChart'), {
                type: 'line',
                data: {
                    labels: attendanceTrend.labels,
                    datasets: [
                        { label: 'Présents', data: attendanceTrend.present, borderColor: '#22c55e', backgroundColor: 'rgba(34,197,94,0.2)', tension: 0.3, fill: true },
                        { label: 'Absents', data: attendanceTrend.absent, borderColor: '#f97316', backgroundColor: 'rgba(249,115,22,0.2)', tension: 0.3, fill: true },
                        { label: 'Retards', data: attendanceTrend.late, borderColor: '#facc15', backgroundColor: 'rgba(250,204,21,0.2)', tension: 0.3, fill: true }
                    ]
                },
                options: chartOptions
            });

            new Chart(document.getElementById('evaluationTrendChart'), {
                type: 'line',
                data: {
                    labels: evaluationTrend.labels,
                    datasets: [{ label: 'Moyenne des notes', data: evaluationTrend.average_score, borderColor: '#818cf8', backgroundColor: 'rgba(129,140,248,0.2)', tension: 0.3, fill: true }]
                },
                options: chartOptions
            });

            new Chart(document.getElementById('departmentComparisonChart'), {
                type: 'bar',
                data: {
                    labels: departmentComparison.map(item => item.label),
                    datasets: [
                        { label: 'Présence %', data: departmentComparison.map(item => item.presence_rate), backgroundColor: '#38bdf8' },
                        { label: 'Moyenne notes', data: departmentComparison.map(item => item.average_score), backgroundColor: '#a78bfa' }
                    ]
                },
                options: chartOptions
            });

            new Chart(document.getElementById('directionComparisonChart'), {
                type: 'bar',
                data: {
                    labels: directionComparison.map(item => item.label),
                    datasets: [
                        { label: 'Présence %', data: directionComparison.map(item => item.presence_rate), backgroundColor: '#22d3ee' },
                        { label: 'Moyenne notes', data: directionComparison.map(item => item.average_score), backgroundColor: '#f472b6' }
                    ]
                },
                options: chartOptions
            });

            new Chart(document.getElementById('scoreHistogramChart'), {
                type: 'bar',
                data: {
                    labels: scoreHistogram.labels,
                    datasets: [{ label: 'Nombre d’évaluations', data: scoreHistogram.data, backgroundColor: '#60a5fa' }]
                },
                options: chartOptions
            });
        }

        function filterTable(inputId, tableId) {
            const filter = document.getElementById(inputId);
            const table = document.getElementById(tableId);
            if (!filter || !table) return;

            filter.addEventListener('input', () => {
                const value = filter.value.toLowerCase();
                table.querySelectorAll('tbody tr').forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(value) ? '' : 'none';
                });
            });
        }

        function exportTableToCsv(filename, tableId) {
            const table = document.getElementById(tableId);
            if (!table) return;
            const rows = Array.from(table.querySelectorAll('tr'));
            const csv = rows.map(row => {
                return Array.from(row.querySelectorAll('th, td')).map(cell => '"' + cell.innerText.replace(/"/g, '""') + '"').join(',');
            }).join('\n');
            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        document.addEventListener('DOMContentLoaded', () => {
            initCharts();
            filterTable('departmentSearch', 'departments-table');
            filterTable('directionSearch', 'directions-table');
        });
    </script>
</x-app-layout>
