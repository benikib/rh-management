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
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
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
                    <p class="text-sm text-gray-500">En retard</p>
                    <p class="text-2xl font-bold text-yellow-600" id="lateToday">{{ $stats['late_today'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                    <i class="fa-solid fa-clock"></i>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Durée</th>
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
                                    @if($presence->statut === 'Present' || $presence->statut === 'Présent')
                                        <span class="w-2 h-2 rounded-full bg-green-400 inline-block animate-pulse" title="Présent"></span>
                                    @elseif($presence->statut === 'En retard')
                                        <span class="w-2 h-2 rounded-full bg-yellow-400 inline-block" title="En retard"></span>
                                    @elseif($presence->statut === 'Absent')
                                        <span class="w-2 h-2 rounded-full bg-red-400 inline-block" title="Absent"></span>
                                    @elseif($presence->statut === 'Parti')
                                        <span class="w-2 h-2 rounded-full bg-orange-400 inline-block" title="Parti"></span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $presence->date_presence ? \Carbon\Carbon::parse($presence->date_presence)->format('d/m/Y') : '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 presence-arrivee">
                                @if(!empty($presence->heure_arrivee) && $presence->heure_arrivee !== '00:00:00')
                                    {{ \Carbon\Carbon::parse($presence->heure_arrivee)->format('H:i') }}
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 presence-depart">
                                @if(!empty($presence->heure_depart) && $presence->heure_depart !== '00:00:00')
                                    {{ \Carbon\Carbon::parse($presence->heure_depart)->format('H:i') }}
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @php
                                    $statut = $presence->statut;
                                    // Normaliser le statut pour l'affichage
                                    if ($statut === 'Present') $statut = 'Présent';
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-medium presence-status 
                                    @if($statut === 'Présent') bg-green-100 text-green-800
                                    @elseif($statut === 'En retard') bg-yellow-100 text-yellow-800
                                    @elseif($statut === 'Absent') bg-red-100 text-red-800
                                    @elseif($statut === 'Parti') bg-orange-100 text-orange-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $statut }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                @php
                                    $duree = null;
                                    if (!empty($presence->heure_arrivee) && !empty($presence->heure_depart)) {
                                        $arrivee = \Carbon\Carbon::parse($presence->heure_arrivee);
                                        $depart = \Carbon\Carbon::parse($presence->heure_depart);
                                        $diff = $arrivee->diff($depart);
                                        $duree = $diff->format('%H:%I');
                                    }
                                @endphp
                                {{ $duree ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('presences.edit', $presence) }}" 
                                       class="text-blue-600 hover:text-blue-800 transition-colors">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('presences.destroy', $presence) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" 
                                                onclick="return confirm('Voulez-vous supprimer cette présence ?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
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

<!-- Scripts pour le live -->
<script>
    // Variables pour le rafraîchissement automatique
    let refreshInterval = null;
    let isRefreshing = false;
    const REFRESH_DELAY = 30000; // 30 secondes
    let errorCount = 0;
    const MAX_ERRORS = 3;

    // Fonction pour formater une heure (HH:MM)
    function formatHeure(heure) {
        if (!heure || heure === '00:00:00' || heure === '00:00') {
            return '—';
        }
        try {
            // Si c'est une chaîne comme "17:02:17"
            if (typeof heure === 'string' && heure.length >= 5) {
                // Extraire HH:MM
                return heure.substring(0, 5);
            }
            // Si c'est un objet Date
            if (heure instanceof Date) {
                return heure.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
            }
            // Sinon, essayer de parser
            const date = new Date(heure);
            if (!isNaN(date)) {
                return date.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
            }
            return '—';
        } catch (e) {
            return '—';
        }
    }

    // Fonction pour calculer la durée
    function calculerDuree(arrivee, depart) {
        if (!arrivee || !depart || arrivee === '00:00:00' || depart === '00:00:00') {
            return '—';
        }
        try {
            const a = new Date('1970-01-01T' + arrivee.substring(0, 5) + ':00');
            const d = new Date('1970-01-01T' + depart.substring(0, 5) + ':00');
            const diff = (d - a) / 60000; // en minutes
            if (diff <= 0) return '—';
            const heures = Math.floor(diff / 60);
            const minutes = Math.floor(diff % 60);
            return String(heures).padStart(2, '0') + ':' + String(minutes).padStart(2, '0');
        } catch (e) {
            return '—';
        }
    }

    // Fonction pour obtenir la classe CSS du statut
    function getStatutClass(statut) {
        if (statut === 'Present') statut = 'Présent';
        const classes = {
            'Présent': 'bg-green-100 text-green-800',
            'En retard': 'bg-yellow-100 text-yellow-800',
            'Absent': 'bg-red-100 text-red-800',
            'Parti': 'bg-orange-100 text-orange-800',
        };
        return classes[statut] || 'bg-gray-100 text-gray-800';
    }

    // Fonction pour obtenir le nom affiché du statut
    function getStatutDisplay(statut) {
        if (statut === 'Present') return 'Présent';
        return statut || '—';
    }

    // Fonction pour rafraîchir les présences
    async function refreshPresences() {
        if (isRefreshing) return;
        isRefreshing = true;

        const refreshIcon = document.getElementById('refreshIcon');
        const statusDot = document.getElementById('statusDot');
        const statusText = document.getElementById('statusText');
        const lastUpdate = document.getElementById('lastUpdate');

        // Animation de rafraîchissement
        if (refreshIcon) refreshIcon.classList.add('fa-spin');

        try {
            // Récupérer le token CSRF
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

            const response = await fetch('{{ route("presences.live") }}', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                const errorText = await response.text();
                console.error('Erreur HTTP:', response.status, errorText);
                throw new Error(`Erreur HTTP ${response.status}: ${response.statusText}`);
            }

            const data = await response.json();

            // Vérifier si les données sont valides
            if (!data || typeof data !== 'object') {
                throw new Error('Données invalides reçues');
            }

            // Réinitialiser le compteur d'erreurs
            errorCount = 0;

            // Mettre à jour les statistiques
            if (data.stats) {
                document.getElementById('totalToday').textContent = data.stats.total_today || 0;
                document.getElementById('arrivedToday').textContent = data.stats.arrived_today || 0;
                document.getElementById('departedToday').textContent = data.stats.departed_today || 0;
                document.getElementById('lateToday').textContent = data.stats.late_today || 0;
                document.getElementById('absentToday').textContent = data.stats.absent_today || 0;
            }

            // Mettre à jour les lignes du tableau
            if (data.presences && Array.isArray(data.presences)) {
                updateTableRows(data.presences);
            }

            // Mettre à jour l'indicateur de statut
            if (statusDot) {
                statusDot.className = 'w-2 h-2 rounded-full bg-green-400 animate-pulse';
            }
            if (statusText) statusText.textContent = 'À jour';
            if (lastUpdate) {
                const now = new Date();
                lastUpdate.textContent = `(${now.toLocaleTimeString()})`;
            }

        } catch (error) {
            console.error('Erreur lors du rafraîchissement:', error);
            errorCount++;

            const statusDot = document.getElementById('statusDot');
            const statusText = document.getElementById('statusText');

            if (errorCount >= MAX_ERRORS) {
                if (statusDot) statusDot.className = 'w-2 h-2 rounded-full bg-red-400';
                if (statusText) statusText.textContent = '⚠️ Connexion perdue';
            } else {
                if (statusDot) statusDot.className = 'w-2 h-2 rounded-full bg-yellow-400 animate-pulse';
                if (statusText) statusText.textContent = `🔄 Tentative ${errorCount}/${MAX_ERRORS}`;
            }
        } finally {
            if (refreshIcon) refreshIcon.classList.remove('fa-spin');
            isRefreshing = false;
        }
    }

    // Fonction pour mettre à jour les lignes du tableau
    function updateTableRows(presences) {
        const tbody = document.getElementById('presencesTableBody');
        if (!tbody) return;

        // Créer un map des données par ID
        const dataMap = {};
        presences.forEach(p => {
            dataMap[p.id] = p;
        });

        // Mettre à jour chaque ligne existante
        const rows = tbody.querySelectorAll('tr[data-presence-id]');
        rows.forEach(row => {
            const presenceId = parseInt(row.dataset.presenceId);
            const presenceData = dataMap[presenceId];

            if (presenceData) {
                updateRowData(row, presenceData);
            }
        });
    }

    // Fonction pour mettre à jour les données d'une ligne
    function updateRowData(row, data) {
        // Mettre à jour les horaires
        const arriveeCell = row.querySelector('.presence-arrivee');
        const departCell = row.querySelector('.presence-depart');
        const statusCell = row.querySelector('.presence-status');
        const statusDot = row.querySelector('.w-2.h-2.rounded-full');

        // Mettre à jour l'arrivée
        if (arriveeCell) {
            arriveeCell.textContent = formatHeure(data.heure_arrivee);
        }

        // Mettre à jour le départ
        if (departCell) {
            departCell.textContent = formatHeure(data.heure_depart);
        }

        // Mettre à jour la durée (colonne ajoutée)
        const dureeCell = row.querySelector('.presence-duree');
        if (dureeCell) {
            dureeCell.textContent = calculerDuree(data.heure_arrivee, data.heure_depart);
        }

        // Mettre à jour le statut
        if (statusCell) {
            const statut = data.statut || '—';
            const displayStatut = getStatutDisplay(statut);
            statusCell.textContent = displayStatut;
            statusCell.className = 'px-2 py-1 rounded-full text-xs font-medium presence-status ' + getStatutClass(statut);
        }

        // Mettre à jour le point de statut
        if (statusDot) {
            statusDot.className = 'w-2 h-2 rounded-full inline-block';
            if (data.statut === 'Présent' || data.statut === 'Present') {
                statusDot.classList.add('bg-green-400', 'animate-pulse');
                statusDot.title = 'Présent';
            } else if (data.statut === 'En retard') {
                statusDot.classList.add('bg-yellow-400');
                statusDot.title = 'En retard';
            } else if (data.statut === 'Absent') {
                statusDot.classList.add('bg-red-400');
                statusDot.title = 'Absent';
            } else if (data.statut === 'Parti') {
                statusDot.classList.add('bg-orange-400');
                statusDot.title = 'Parti';
            }
        }

        // Animation de flash
        row.style.transition = 'background-color 0.3s';
        row.style.backgroundColor = '#f0f9ff';
        setTimeout(() => {
            row.style.backgroundColor = '';
        }, 1000);
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

        // Mise à jour de l'indicateur de statut
        setInterval(() => {
            const dot = document.getElementById('statusDot');
            if (dot && !dot.classList.contains('bg-red-400') && !dot.classList.contains('bg-yellow-400')) {
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