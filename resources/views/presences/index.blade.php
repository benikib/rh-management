<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-wrap gap-4">
            <div class="flex items-center gap-4">
                <h2 class="font-semibold text-xl text-white">Présences</h2>
                <!-- Indicateur de statut en temps réel -->
                <div id="liveIndicator" class="flex items-center gap-2 bg-white/10 px-3 py-1 rounded-full text-sm text-white">
                    <span id="statusDot" class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                    <span id="statusText">En direct</span>
                    <span id="lastUpdate" class="text-xs text-white/60 ml-1"></span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button onclick="refreshPresences()" 
                        class="inline-flex items-center px-3 py-2 bg-white/10 text-white rounded-lg text-sm font-semibold hover:bg-white/20 transition-all">
                    <i class="fa-solid fa-rotate mr-2" id="refreshIcon"></i>
                    <span>Rafraîchir</span>
                </button>
                <a href="{{ route('presences.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold hover:bg-gray-100 transition-all">
                    <i class="fa-solid fa-plus mr-2"></i> Nouvelle présence
                </a>
            </div>
        </div>
    </x-slot>

    @include('partials.flash')

    <!-- Statistiques en temps réel -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total aujourd'hui</p>
                    <p class="text-2xl font-bold text-gray-800" id="totalToday">{{ $stats['total_today'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Arrivés</p>
                    <p class="text-2xl font-bold text-green-600" id="arrivedToday">{{ $stats['arrived_today'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Partis</p>
                    <p class="text-2xl font-bold text-orange-600" id="departedToday">{{ $stats['departed_today'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Absents</p>
                    <p class="text-2xl font-bold text-red-600" id="absentToday">{{ $stats['absent_today'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                    <i class="fa-solid fa-user-slash"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des présences avec mise à jour automatique -->
    <div class="bg-white rounded-xl shadow overflow-hidden" id="presencesContainer">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employé</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Arrivée</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Départ</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dernière activité</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody id="presencesTableBody">
                    @forelse ($presences as $presence)
                        <tr class="hover:bg-gray-50 transition-colors" data-presence-id="{{ $presence->id }}" data-status="{{ $presence->statut }}">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $presence->id }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                <div class="flex items-center gap-2">
                                    <span>{{ $presence->employe?->nom_complet ?? '—' }}</span>
                                    <!-- Indicateur de présence en temps réel -->
                                    @if($presence->statut === 'Présent')
                                        <span class="w-2 h-2 rounded-full bg-green-400 inline-block animate-pulse" title="Présent"></span>
                                    @elseif($presence->statut === 'En retard')
                                        <span class="w-2 h-2 rounded-full bg-orange-400 inline-block" title="En retard"></span>
                                    @elseif($presence->statut === 'Absent')
                                        <span class="w-2 h-2 rounded-full bg-red-400 inline-block" title="Absent"></span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $presence->date_presence?->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 presence-arrivee">{{ $presence->heure_arrivee ? substr($presence->heure_arrivee, 0, 5) : '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 presence-depart">{{ $presence->heure_depart ? substr($presence->heure_depart, 0, 5) : '—' }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2 py-1 rounded-full text-xs font-medium presence-status 
                                    @if($presence->statut === 'Présent') bg-green-100 text-green-800
                                    @elseif($presence->statut === 'En retard') bg-orange-100 text-orange-800
                                    @elseif($presence->statut === 'Absent') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $presence->statut }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 last-activity" data-timestamp="{{ $presence->updated_at?->timestamp ?? now()->timestamp }}">
                                {{ $presence->updated_at?->diffForHumans() ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @include('partials.crud-actions', ['routePrefix' => 'presences', 'model' => $presence])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">Aucune présence enregistrée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($presences->hasPages())
            <div class="px-6 py-4 border-t">{{ $presences->links() }}</div>
        @endif
    </div>
</x-app-layout>

<script>
    // Variables pour le rafraîchissement automatique
    let refreshInterval = null;
    let isRefreshing = false;
    const REFRESH_DELAY = 30000; // 30 secondes

    // Fonction pour rafraîchir les présences
    async function refreshPresences() {
        if (isRefreshing) return;
        isRefreshing = true;

        const refreshIcon = document.getElementById('refreshIcon');
        const statusDot = document.getElementById('statusDot');
        const statusText = document.getElementById('statusText');
        const lastUpdate = document.getElementById('lastUpdate');

        // Animation de rafraîchissement
        refreshIcon.classList.add('fa-spin');

        try {
            const response = await fetch('{{ route("presences.live") }}', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error('Erreur réseau');

            const data = await response.json();

            // Mettre à jour les statistiques
            document.getElementById('totalToday').textContent = data.stats.total_today || 0;
            document.getElementById('arrivedToday').textContent = data.stats.arrived_today || 0;
            document.getElementById('departedToday').textContent = data.stats.departed_today || 0;
            document.getElementById('absentToday').textContent = data.stats.absent_today || 0;

            // Mettre à jour les lignes du tableau
            const tbody = document.getElementById('presencesTableBody');
            const rows = tbody.querySelectorAll('tr[data-presence-id]');
            const newData = data.presences || [];

            // Créer un map des données par ID
            const dataMap = {};
            newData.forEach(p => {
                dataMap[p.id] = p;
            });

            // Mettre à jour chaque ligne existante
            rows.forEach(row => {
                const presenceId = row.dataset.presenceId;
                const presenceData = dataMap[presenceId];

                if (presenceData) {
                    // Mettre à jour les cellules
                    const arriveeCell = row.querySelector('.presence-arrivee');
                    const departCell = row.querySelector('.presence-depart');
                    const statusCell = row.querySelector('.presence-status');
                    const lastActivityCell = row.querySelector('.last-activity');
                    const statusDot = row.querySelector('.w-2.h-2.rounded-full');

                    // Mettre à jour les horaires
                    if (arriveeCell) {
                        arriveeCell.textContent = presenceData.heure_arrivee ? presenceData.heure_arrivee.substring(0, 5) : '—';
                    }
                    if (departCell) {
                        departCell.textContent = presenceData.heure_depart ? presenceData.heure_depart.substring(0, 5) : '—';
                    }

                    // Mettre à jour le statut
                    if (statusCell) {
                        const statut = presenceData.statut || '—';
                        statusCell.textContent = statut;
                        // Mettre à jour les classes CSS
                        statusCell.className = 'px-2 py-1 rounded-full text-xs font-medium presence-status';
                        if (statut === 'Présent') {
                            statusCell.classList.add('bg-green-100', 'text-green-800');
                        } else if (statut === 'En retard') {
                            statusCell.classList.add('bg-orange-100', 'text-orange-800');
                        } else if (statut === 'Absent') {
                            statusCell.classList.add('bg-red-100', 'text-red-800');
                        } else {
                            statusCell.classList.add('bg-gray-100', 'text-gray-800');
                        }
                    }

                    // Mettre à jour le point de statut
                    if (statusDot) {
                        statusDot.className = 'w-2 h-2 rounded-full inline-block';
                        if (presenceData.statut === 'Présent') {
                            statusDot.classList.add('bg-green-400', 'animate-pulse');
                            statusDot.title = 'Présent';
                        } else if (presenceData.statut === 'En retard') {
                            statusDot.classList.add('bg-orange-400');
                            statusDot.title = 'En retard';
                        } else if (presenceData.statut === 'Absent') {
                            statusDot.classList.add('bg-red-400');
                            statusDot.title = 'Absent';
                        }
                    }

                    // Mettre à jour la dernière activité
                    if (lastActivityCell) {
                        const timestamp = presenceData.updated_at || presenceData.created_at;
                        if (timestamp) {
                            const diff = timeDiff(new Date(timestamp));
                            lastActivityCell.textContent = diff;
                            lastActivityCell.dataset.timestamp = new Date(timestamp).getTime() / 1000;
                        }
                    }

                    // Ajouter une animation de flash pour les modifications
                    row.style.transition = 'background-color 0.3s';
                    row.style.backgroundColor = '#f0f9ff';
                    setTimeout(() => {
                        row.style.backgroundColor = '';
                    }, 1000);
                }
            });

            // Mettre à jour l'indicateur de statut
            statusDot.className = 'w-2 h-2 rounded-full bg-green-400 animate-pulse';
            statusText.textContent = 'À jour';
            const now = new Date();
            lastUpdate.textContent = `(${now.toLocaleTimeString()})`;

        } catch (error) {
            console.error('Erreur lors du rafraîchissement:', error);
            const statusDot = document.getElementById('statusDot');
            const statusText = document.getElementById('statusText');
            statusDot.className = 'w-2 h-2 rounded-full bg-red-400';
            statusText.textContent = 'Erreur de connexion';
        } finally {
            refreshIcon.classList.remove('fa-spin');
            isRefreshing = false;
        }
    }

    // Fonction pour calculer le temps écoulé
    function timeDiff(date) {
        const now = new Date();
        const diff = (now - date) / 1000;

        if (diff < 60) return 'à l\'instant';
        if (diff < 3600) return `il y a ${Math.floor(diff / 60)} min`;
        if (diff < 86400) return `il y a ${Math.floor(diff / 3600)} h`;
        if (diff < 604800) return `il y a ${Math.floor(diff / 86400)} j`;
        return 'il y a longtemps';
    }

    // Fonction pour mettre à jour les temps relatifs toutes les minutes
    function updateRelativeTimes() {
        const elements = document.querySelectorAll('.last-activity');
        elements.forEach(el => {
            const timestamp = el.dataset.timestamp;
            if (timestamp) {
                const date = new Date(timestamp * 1000);
                el.textContent = timeDiff(date);
            }
        });
    }

    // Démarrer le rafraîchissement automatique
    function startAutoRefresh() {
        // Rafraîchissement initial
        refreshPresences();

        // Rafraîchissement périodique
        if (refreshInterval) {
            clearInterval(refreshInterval);
        }
        refreshInterval = setInterval(refreshPresences, REFRESH_DELAY);

        // Mise à jour des temps relatifs
        setInterval(updateRelativeTimes, 60000);

        // Mise à jour de l'indicateur de statut
        setInterval(() => {
            const dot = document.getElementById('statusDot');
            if (dot && !dot.classList.contains('bg-red-400')) {
                dot.classList.toggle('animate-pulse');
            }
        }, 2000);
    }

    // Arrêter le rafraîchissement automatique
    function stopAutoRefresh() {
        if (refreshInterval) {
            clearInterval(refreshInterval);
            refreshInterval = null;
        }
    }

    // Démarrer au chargement de la page
    document.addEventListener('DOMContentLoaded', () => {
        startAutoRefresh();

        // Rafraîchir manuellement avec le raccourci F5 ou Ctrl+R (ne pas recharger la page)
        document.addEventListener('keydown', (e) => {
            if ((e.key === 'r' || e.key === 'R') && (e.ctrlKey || e.metaKey)) {
                e.preventDefault();
                refreshPresences();
            }
            if (e.key === 'F5') {
                e.preventDefault();
                refreshPresences();
            }
        });
    });

    // Arrêter le rafraîchissement quand la page est cachée
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            stopAutoRefresh();
        } else {
            startAutoRefresh();
        }
    });

    // Nettoyer les intervalles quand la page est déchargée
    window.addEventListener('beforeunload', () => {
        stopAutoRefresh();
    });
</script>