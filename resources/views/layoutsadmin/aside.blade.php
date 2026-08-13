<aside id="sidebar"
    class="fixed inset-y-0 left-0 w-64 bg-gray-900 border-r border-gray-800 shadow-xl rounded-r-2xl p-4 overflow-y-auto transform transition-transform duration-300 ease-in-out z-50
    -translate-x-full md:translate-x-0 md:relative md:z-auto"
    style="height: 100vh; overflow-y: auto;">

    <!-- Header avec toggle -->
    <div class="flex items-center justify-between mb-4 sticky top-0 bg-gray-900 z-10 pb-2">
        <div class="flex items-center space-x-3 px-2">
            <a href="{{ route('dashboard') }}" class="text-white font-bold text-lg flex items-center gap-2 whitespace-nowrap">
                <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">RH</span>
                <span class="hidden md:inline">RH-MANAG</span>
            </a>
        </div>
        <div class="flex items-center gap-2 flex-shrink-0">
            <!-- Bouton toggle pour cacher/afficher (desktop) -->
            <button id="toggleSidebarButton" class="hidden md:block text-gray-400 hover:text-white transition-transform duration-300 p-1">
                <svg id="toggleIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                </svg>
            </button>
            <!-- Bouton fermeture mobile -->
            <button id="closeSidebarButton" class="md:hidden text-gray-400 hover:text-white p-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <hr class="border-gray-800 my-2">

    <ul class="space-y-1 pb-20">
        <!-- ========== SECTION 1 : NAVIGATION PRINCIPALE ========== -->
        <li class="text-xs text-gray-400 uppercase px-4 pt-4 pb-2 font-semibold tracking-wider">
            <i class="fa-solid fa-compass mr-2"></i>Navigation
        </li>
        <li>
            <a href="{{ route('dashboard') }}"
               class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge"></i>
                <span>Tableau de bord</span>
            </a>
        </li>

        <!-- ========== SECTION 2 : ADMINISTRATION ========== -->
        <li>
            <button onclick="toggleSection('adminSection')"
                    class="sidebar-section-toggle w-full flex items-center justify-between px-4 py-2 text-gray-300 hover:text-white hover:bg-gray-800/50 rounded-lg transition-colors">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-gear"></i>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Administration</span>
                </span>
                <i id="adminSectionIcon" class="fa-solid fa-chevron-down text-gray-500 text-xs transition-transform duration-300"></i>
            </button>
            <ul id="adminSection" class="section-content ml-4 space-y-1">
                @if(auth()->check() && auth()->user()->canAccessModule('roles'))
                <li>
                    <a href="{{ route('roles.index') }}"
                       class="sidebar-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-shield"></i>
                        <span>Rôles & permissions</span>
                    </a>
                </li>
                @endif
                @if(auth()->check() && auth()->user()->canAccessModule('users'))
                <li>
                    <a href="{{ route('users.index') }}"
                       class="sidebar-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users"></i>
                        <span>Utilisateurs</span>
                    </a>
                </li>
                @endif
                @if(auth()->check() && auth()->user()->canAccessModule('employee-statuses'))
                <li>
                    <a href="{{ route('employee-statuses.index') }}"
                       class="sidebar-item {{ request()->routeIs('employee-statuses.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <span>Statuts RH</span>
                    </a>
                </li>
                @endif
            </ul>
        </li>

        <!-- ========== SECTION 3 : STRUCTURE ========== -->
        <li>
            <button onclick="toggleSection('structureSection')"
                    class="sidebar-section-toggle w-full flex items-center justify-between px-4 py-2 text-gray-300 hover:text-white hover:bg-gray-800/50 rounded-lg transition-colors">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-sitemap"></i>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Structure</span>
                </span>
                <i id="structureSectionIcon" class="fa-solid fa-chevron-down text-gray-500 text-xs transition-transform duration-300"></i>
            </button>
            <ul id="structureSection" class="section-content ml-4 space-y-1">
                <li>
                    <a href="{{ route('departements.index') }}"
                       class="sidebar-item {{ request()->routeIs('departements.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-building"></i>
                        <span>Départements</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('directions.index') }}"
                       class="sidebar-item {{ request()->routeIs('directions.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-sitemap"></i>
                        <span>Directions</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('postes.index') }}"
                       class="sidebar-item {{ request()->routeIs('postes.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-briefcase"></i>
                        <span>Postes</span>
                    </a>
                </li>
                @if(auth()->check() && auth()->user()->canAccessModule('employes'))
                <li>
                    <a href="{{ route('employes.index') }}"
                       class="sidebar-item {{ request()->routeIs('employes.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-id-card"></i>
                        <span>Employés</span>
                    </a>
                </li>
                @endif
            </ul>
        </li>

        <!-- ========== SECTION 4 : COMPÉTENCES & FORMATION ========== -->
        @if(auth()->check() && auth()->user()->canAccessModule('formations'))
        <li>
            <button onclick="toggleSection('formationSection')"
                    class="sidebar-section-toggle w-full flex items-center justify-between px-4 py-2 text-gray-300 hover:text-white hover:bg-gray-800/50 rounded-lg transition-colors">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Compétences & Formation</span>
                </span>
                <i id="formationSectionIcon" class="fa-solid fa-chevron-down text-gray-500 text-xs transition-transform duration-300"></i>
            </button>
            <ul id="formationSection" class="section-content ml-4 space-y-1">
                <li>
                    <a href="{{ route('competences.index') }}"
                       class="sidebar-item {{ request()->routeIs('competences.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-lightbulb"></i>
                        <span>Compétences</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('formations.index') }}"
                       class="sidebar-item {{ request()->routeIs('formations.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span>Formations</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('stagiaires.index') }}"
                       class="sidebar-item {{ request()->routeIs('stagiaires.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-tie"></i>
                        <span>Stagiaires</span>
                    </a>
                </li>
            </ul>
        </li>
        @endif

        <!-- ========== SECTION 5 : CONTRATS & MISSIONS ========== -->
        <li>
            <button onclick="toggleSection('contratSection')"
                    class="sidebar-section-toggle w-full flex items-center justify-between px-4 py-2 text-gray-300 hover:text-white hover:bg-gray-800/50 rounded-lg transition-colors">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-file-contract"></i>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Contrats & Missions</span>
                </span>
                <i id="contratSectionIcon" class="fa-solid fa-chevron-down text-gray-500 text-xs transition-transform duration-300"></i>
            </button>
            <ul id="contratSection" class="section-content ml-4 space-y-1">
                @if(auth()->check() && auth()->user()->canAccessModule('contract-types'))
                <li>
                    <a href="{{ route('contract-types.index') }}"
                       class="sidebar-item {{ request()->routeIs('contract-types.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-contract"></i>
                        <span>Types de contrat</span>
                    </a>
                </li>
                @endif
                @if(auth()->check() && auth()->user()->canAccessModule('missions'))
                <li>
                    <a href="{{ route('missions.index') }}"
                       class="sidebar-item {{ request()->routeIs('missions.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-route"></i>
                        <span>Missions</span>
                    </a>
                </li>
                @endif
            </ul>
        </li>

        <!-- ========== SECTION 6 : DOSSIER EMPLOYÉ ========== -->
        <li>
            <button onclick="toggleSection('dossierSection')"
                    class="sidebar-section-toggle w-full flex items-center justify-between px-4 py-2 text-gray-300 hover:text-white hover:bg-gray-800/50 rounded-lg transition-colors">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-folder"></i>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Dossier employé</span>
                </span>
                <i id="dossierSectionIcon" class="fa-solid fa-chevron-down text-gray-500 text-xs transition-transform duration-300"></i>
            </button>
            <ul id="dossierSection" class="section-content ml-4 space-y-1">
                @if(auth()->check() && auth()->user()->canAccessModule('personnel-tasks'))
                <li>
                    <a href="{{ route('personnel-tasks.index') }}"
                       class="sidebar-item {{ request()->routeIs('personnel-tasks.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-list-check"></i>
                        <span>Tâches</span>
                    </a>
                </li>
                @endif
                @if(auth()->check() && auth()->user()->canAccessModule('employee-family-infos'))
                <li>
                    <a href="{{ route('employee-family-infos.index') }}"
                       class="sidebar-item {{ request()->routeIs('employee-family-infos.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-house-user"></i>
                        <span>Dossier familial</span>
                    </a>
                </li>
                @endif
                @if(auth()->check() && auth()->user()->canAccessModule('employee-dependents'))
                <li>
                    <a href="{{ route('employee-dependents.index') }}"
                       class="sidebar-item {{ request()->routeIs('employee-dependents.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-group"></i>
                        <span>Personnes à charge</span>
                    </a>
                </li>
                @endif
                @if(auth()->check() && auth()->user()->canAccessModule('employee-position-history'))
                <li>
                    <a href="{{ route('employee-position-history.index') }}"
                       class="sidebar-item {{ request()->routeIs('employee-position-history.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-history"></i>
                        <span>Historique de poste</span>
                    </a>
                </li>
                @endif
                @if(auth()->check() && auth()->user()->canAccessModule('employee-history-logs'))
                <li>
                    <a href="{{ route('employee-history-logs.index') }}"
                       class="sidebar-item {{ request()->routeIs('employee-history-logs.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-book"></i>
                        <span>Journal RH</span>
                    </a>
                </li>
                @endif
            </ul>
        </li>

        <!-- ========== SECTION 7 : GESTION RH ========== -->
        <li>
            <button onclick="toggleSection('rhSection')"
                    class="sidebar-section-toggle w-full flex items-center justify-between px-4 py-2 text-gray-300 hover:text-white hover:bg-gray-800/50 rounded-lg transition-colors">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-calendar-days"></i>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Gestion RH</span>
                </span>
                <i id="rhSectionIcon" class="fa-solid fa-chevron-down text-gray-500 text-xs transition-transform duration-300"></i>
            </button>
            <ul id="rhSection" class="section-content ml-4 space-y-1">
                @if(auth()->check() && auth()->user()->canAccessModule('presences'))
                <li>
                    <a href="{{ route('presences.index') }}"
                       class="sidebar-item {{ request()->routeIs('presences.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-clock"></i>
                        <span>Présences</span>
                    </a>
                </li>
                @endif
                <li>
                    <a href="{{ route('conges.index') }}"
                       class="sidebar-item {{ request()->routeIs('conges.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-calendar-days"></i>
                        <span>Congés</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('carrieres.index') }}"
                       class="sidebar-item {{ request()->routeIs('carrieres.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-line"></i>
                        <span>Carrières</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- ========== SECTION 8 : ÉVALUATIONS ========== -->
        <li>
            <button onclick="toggleSection('evaluationSection')"
                    class="sidebar-section-toggle w-full flex items-center justify-between px-4 py-2 text-gray-300 hover:text-white hover:bg-gray-800/50 rounded-lg transition-colors">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-star"></i>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Évaluations</span>
                </span>
                <i id="evaluationSectionIcon" class="fa-solid fa-chevron-down text-gray-500 text-xs transition-transform duration-300"></i>
            </button>
            <ul id="evaluationSection" class="section-content ml-4 space-y-1">
                @if(auth()->check() && auth()->user()->canManageEvaluations())
                <li>
                    <a href="{{ route('evaluations.all') }}"
                       class="sidebar-item {{ request()->routeIs('evaluations.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-star"></i>
                        <span>Évaluations</span>
                    </a>
                </li>
                @endif
                <li>
                    <a href="{{ route('criteres.index') }}"
                       class="sidebar-item {{ request()->routeIs('criteres.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-list-check"></i>
                        <span>Critères d'évaluation</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- ========== SECTION 9 : DOCUMENTS & RAPPORTS ========== -->
        <li>
            <button onclick="toggleSection('docSection')"
                    class="sidebar-section-toggle w-full flex items-center justify-between px-4 py-2 text-gray-300 hover:text-white hover:bg-gray-800/50 rounded-lg transition-colors">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-file-lines"></i>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Documents & Rapports</span>
                </span>
                <i id="docSectionIcon" class="fa-solid fa-chevron-down text-gray-500 text-xs transition-transform duration-300"></i>
            </button>
            <ul id="docSection" class="section-content ml-4 space-y-1">
                <li>
                    <a href="{{ route('documents.index') }}"
                       class="sidebar-item {{ request()->routeIs('documents.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-file"></i>
                        <span>Documents</span>
                    </a>
                </li>
                @if(auth()->check() && auth()->user()->canAccessModule('reports'))
                <li>
                    <a href="{{ route('reports.index') }}"
                       class="sidebar-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-lines"></i>
                        <span>Rapports</span>
                    </a>
                </li>
                @endif
            </ul>
        </li>

        <!-- ========== SECTION 10 : PAIE ========== -->
        @if(auth()->check() && auth()->user()->canAccessModule('paie'))
        <li>
            <button onclick="toggleSection('paieSection')"
                    class="sidebar-section-toggle w-full flex items-center justify-between px-4 py-2 text-gray-300 hover:text-white hover:bg-gray-800/50 rounded-lg transition-colors">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-coins"></i>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Paie</span>
                </span>
                <i id="paieSectionIcon" class="fa-solid fa-chevron-down text-gray-500 text-xs transition-transform duration-300"></i>
            </button>
            <ul id="paieSection" class="section-content ml-4 space-y-1">
                <li>
                    <a href="{{ route('paie.settings.edit') }}"
                       class="sidebar-item {{ request()->routeIs('paie.settings.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-calculator"></i>
                        <span>Paramètres paie</span>
                    </a>
                </li>
            </ul>
        </li>
        @endif

        <!-- ========== SECTION 11 : COMPTE ========== -->
        <li>
            <button onclick="toggleSection('compteSection')"
                    class="sidebar-section-toggle w-full flex items-center justify-between px-4 py-2 text-gray-300 hover:text-white hover:bg-gray-800/50 rounded-lg transition-colors">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-user"></i>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Compte</span>
                </span>
                <i id="compteSectionIcon" class="fa-solid fa-chevron-down text-gray-500 text-xs transition-transform duration-300"></i>
            </button>
            <ul id="compteSection" class="section-content ml-4 space-y-1">
                <li>
                    <a href="{{ route('profile.edit') }}"
                       class="sidebar-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-gear"></i>
                        <span>Profil</span>
                    </a>
                </li>
                <li>
                    <button type="button" onclick="logoutModal.showModal()"
                            class="sidebar-item w-full text-left text-red-400 hover:text-red-300 hover:bg-red-500/10">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Déconnexion</span>
                    </button>
                </li>
            </ul>
        </li>
    </ul>

    <!-- Version -->
    <div class="mt-6 pt-4 border-t border-gray-800 px-4 sticky bottom-0 bg-gray-900">
        <p class="text-xs text-gray-500">
            <i class="fa-solid fa-code mr-1"></i>
            Version {{ config('app.version', '1.0.0') }}
        </p>
    </div>
</aside>

<!-- Bouton pour ouvrir le sidebar en mobile (flottant) -->
<button id="openSidebarButton" class="fixed bottom-6 right-6 md:hidden z-40 bg-gradient-to-br from-blue-500 to-purple-600 text-white rounded-full p-4 shadow-2xl hover:scale-105 transition-transform">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
</button>

<style>
    /* ========== STYLES POUR L'ACCORDÉON ========== */
    .section-content {
        max-height: 0;
        opacity: 0;
        padding-top: 0;
        padding-bottom: 0;
        transition: max-height 0.4s ease-in-out, opacity 0.3s ease-in-out, padding 0.3s ease-in-out;
        overflow: hidden;
    }

    .section-content.open {
        max-height: 1000px;
        opacity: 1;
        padding-top: 4px;
        padding-bottom: 4px;
    }

    .sidebar-section-toggle {
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .sidebar-section-toggle:hover {
        background: rgba(255, 255, 255, 0.05);
    }

    /* Animation du toggle */
    #toggleSidebarButton {
        transition: transform 0.3s ease;
    }

    #toggleSidebarButton:hover {
        transform: scale(1.1);
    }

    /* Sidebar scroll indépendant */
    #sidebar {
        height: 100vh;
        overflow-y: auto;
        overscroll-behavior: contain;
        scrollbar-width: thin;
        scrollbar-color: #4b5563 transparent;
    }

    #sidebar::-webkit-scrollbar {
        width: 4px;
    }

    #sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    #sidebar::-webkit-scrollbar-thumb {
        background: #4b5563;
        border-radius: 10px;
    }

    #sidebar::-webkit-scrollbar-thumb:hover {
        background: #6b7280;
    }

    /* Animation du bouton d'ouverture mobile */
    #openSidebarButton {
        animation: pulse-ring 2s ease-in-out infinite;
    }

    @keyframes pulse-ring {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4);
        }
        50% {
            box-shadow: 0 0 0 15px rgba(59, 130, 246, 0);
        }
    }

    /* Responsive */
    @media (max-width: 767px) {
        #sidebar {
            width: 80%;
            max-width: 320px;
            border-radius: 0 1.5rem 1.5rem 0;
            height: 100vh;
        }
    }

    /* Sticky header dans le sidebar */
    .sticky {
        position: sticky;
        z-index: 10;
    }
</style>

<script>
    // ========== GESTION DE L'ACCORDÉON ==========
    function toggleSection(sectionId) {
        const section = document.getElementById(sectionId);
        const icon = document.getElementById(sectionId + 'Icon');

        if (!section) return;

        // Vérifier si la section est déjà ouverte
        const isOpen = section.classList.contains('open');

        // Fermer toutes les sections
        document.querySelectorAll('.section-content').forEach(el => {
            el.classList.remove('open');
        });

        // Réinitialiser toutes les icônes
        document.querySelectorAll('[id$="Icon"]').forEach(el => {
            if (el.id !== sectionId + 'Icon') {
                el.style.transform = 'rotate(0deg)';
            }
        });

        // Si la section était fermée, on l'ouvre
        if (!isOpen) {
            section.classList.add('open');
            if (icon) {
                icon.style.transform = 'rotate(180deg)';
            }
        }
    }

    // ========== GESTION DU TOGGLE (CACHER/AFFICHER) ==========
    let sidebarVisible = true;
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebarButton');
    const toggleIcon = document.getElementById('toggleIcon');
    const openBtn = document.getElementById('openSidebarButton');
    const overlay = document.getElementById('sidebarOverlay');
    const closeBtn = document.getElementById('closeSidebarButton');

    // Fonction pour cacher le sidebar (Desktop)
    function hideSidebar() {
        if (window.innerWidth >= 768) {
            sidebar.style.transform = 'translateX(-100%)';
            sidebar.style.width = '0';
            sidebar.style.padding = '0';
            sidebar.style.overflow = 'hidden';
            sidebar.style.margin = '0';
            if (toggleIcon) {
                toggleIcon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>';
            }
            sidebarVisible = false;
            document.querySelector('main')?.style.setProperty('margin-left', '0');
        }
    }

    // Fonction pour afficher le sidebar (Desktop)
    function showSidebar() {
        if (window.innerWidth >= 768) {
            sidebar.style.transform = 'translateX(0)';
            sidebar.style.width = '';
            sidebar.style.padding = '';
            sidebar.style.overflow = '';
            sidebar.style.margin = '';
            if (toggleIcon) {
                toggleIcon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>';
            }
            sidebarVisible = true;
            document.querySelector('main')?.style.setProperty('margin-left', '');
        }
    }

    // Toggle du sidebar
    function toggleSidebar() {
        if (sidebarVisible) {
            hideSidebar();
        } else {
            showSidebar();
        }
    }

    // Ouvrir le sidebar (Mobile)
    function openSidebarMobile() {
        sidebar.classList.remove('-translate-x-full');
        if (overlay) overlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    // Fermer le sidebar (Mobile)
    function closeSidebarMobile() {
        sidebar.classList.add('-translate-x-full');
        if (overlay) overlay.classList.add('hidden');
        document.body.style.overflow = '';
    }

    // ========== ÉVÉNEMENTS ==========
    // Toggle desktop
    if (toggleBtn) {
        toggleBtn.addEventListener('click', toggleSidebar);
    }

    // Ouvrir mobile
    if (openBtn) {
        openBtn.addEventListener('click', openSidebarMobile);
    }

    // Fermer mobile
    if (closeBtn) {
        closeBtn.addEventListener('click', closeSidebarMobile);
    }

    // Fermer avec overlay
    if (overlay) {
        overlay.addEventListener('click', closeSidebarMobile);
    }

    // Fermer en cliquant sur un lien (mobile)
    const sidebarLinks = sidebar?.querySelectorAll('a, button');
    sidebarLinks?.forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 768) {
                closeSidebarMobile();
            }
        });
    });

    // ========== GESTION DU RESPONSIVE ==========
    let lastWidth = window.innerWidth;

    window.addEventListener('resize', function() {
        const currentWidth = window.innerWidth;

        // On passe de desktop à mobile
        if (lastWidth >= 768 && currentWidth < 768) {
            sidebar.style.transform = '';
            sidebar.style.width = '';
            sidebar.style.padding = '';
            sidebar.style.overflow = '';
            sidebar.style.margin = '';
            sidebar.classList.add('-translate-x-full');
            document.querySelector('main')?.style.setProperty('margin-left', '');
            sidebarVisible = true;
            if (overlay) overlay.classList.add('hidden');
        }

        // On passe de mobile à desktop
        if (lastWidth < 768 && currentWidth >= 768) {
            sidebar.classList.remove('-translate-x-full');
            if (overlay) overlay.classList.add('hidden');
            document.body.style.overflow = '';
            // On rétablit l'état du toggle
            if (sidebarVisible) {
                showSidebar();
            } else {
                hideSidebar();
            }
        }

        lastWidth = currentWidth;
    });

    // ========== INITIALISATION ==========
    // Par défaut, le sidebar est visible sur desktop
    if (window.innerWidth >= 768) {
        showSidebar();
    } else {
        sidebar?.classList.add('-translate-x-full');
        if (overlay) overlay.classList.add('hidden');
    }

    // ========== SAUVEGARDE DE L'ÉTAT DES SECTIONS ==========
    function saveSectionState() {
        const openSections = [];
        document.querySelectorAll('.section-content.open').forEach(el => {
            openSections.push(el.id);
        });
        try {
            localStorage.setItem('sidebarSections', JSON.stringify(openSections));
        } catch (e) {
            // Ignorer les erreurs de localStorage
        }
    }

    function restoreSectionState() {
        try {
            const saved = localStorage.getItem('sidebarSections');
            if (saved) {
                const openSections = JSON.parse(saved);
                openSections.forEach(id => {
                    const section = document.getElementById(id);
                    if (section) {
                        section.classList.add('open');
                        const icon = document.getElementById(id + 'Icon');
                        if (icon) {
                            icon.style.transform = 'rotate(180deg)';
                        }
                    }
                });
            }
        } catch (e) {
            // Ignorer les erreurs de localStorage
        }
    }

    // Sauvegarder l'état quand on clique sur une section
    document.querySelectorAll('.sidebar-section-toggle').forEach(btn => {
        btn.addEventListener('click', () => {
            setTimeout(saveSectionState, 300);
        });
    });

    // Restaurer l'état au chargement
    document.addEventListener('DOMContentLoaded', restoreSectionState);
</script>