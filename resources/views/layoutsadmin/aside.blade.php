<aside id="sidebar"
    class="fixed inset-y-0 left-0 w-64 bg-gray-900 border-r border-gray-800 shadow-xl rounded-r-2xl p-4 overflow-y-auto transform transition-transform duration-300 ease-in-out z-50
    -translate-x-full md:translate-x-0 md:relative md:z-auto">

    <button id="closeSidebarButton" class="absolute top-4 right-4 md:hidden text-gray-400 hover:text-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <div class="flex items-center space-x-3 px-4 py-4">
        <a href="{{ route('dashboard') }}" class="text-white font-bold text-lg">RH-MANAG</a>
    </div>

    <hr class="border-gray-800 my-2">

    <ul class="space-y-2">
        <li class="text-xs text-gray-400 uppercase px-4 pt-4 pb-2">Navigation</li>
        <li>
            <a href="{{ route('dashboard') }}"
               class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge"></i>
                <span>Tableau de bord</span>
            </a>
        </li>

        <li class="text-xs text-gray-400 uppercase px-4 pt-4 pb-2">Administration</li>
        @if(auth()->check() && auth()->user()->canAccessModule('roles'))
        <li>
            <a href="{{ route('roles.index') }}"
               class="sidebar-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-shield"></i>
                <span>Rôles</span>
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

        <li class="text-xs text-gray-400 uppercase px-4 pt-4 pb-2">Organisation</li>
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

        <li class="text-xs text-gray-400 uppercase px-4 pt-4 pb-2">Ressources RH</li>
        @if(auth()->check() && auth()->user()->canAccessModule('formations'))
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
        @endif
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

        <li class="text-xs text-gray-400 uppercase px-4 pt-4 pb-2">Gestion RH</li>
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
        <li>
            <a href="{{ route('documents.index') }}"
               class="sidebar-item {{ request()->routeIs('documents.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file"></i>
                <span>Documents</span>
            </a>
        </li>
        <li>
            <a href="{{ route('criteres.index') }}"
               class="sidebar-item {{ request()->routeIs('criteres.*') ? 'active' : '' }}">
                <i class="fa-solid fa-list-check"></i>
                <span>Critères</span>
            </a>
        </li>
        @if(auth()->check() && auth()->user()->canManageEvaluations())
        <li>
            <a href="{{ route('evaluations.all') }}"
               class="sidebar-item {{ request()->routeIs('evaluations.*') ? 'active' : '' }}">
                <i class="fa-solid fa-star"></i>
                <span>Évaluations</span>
            </a>
        </li>
        @endif
        @if(auth()->check() && auth()->user()->canAccessModule('reports'))
        <li>
            <a href="{{ route('reports.index') }}"
               class="sidebar-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-lines"></i>
                <span>Rapports</span>
            </a>
        </li>
        @endif
        @if(auth()->check() && auth()->user()->canAccessModule('paie'))
        <li>
            <a href="{{ route('paie.settings.edit') }}"
               class="sidebar-item {{ request()->routeIs('paie.settings.*') ? 'active' : '' }}">
                <i class="fa-solid fa-calculator"></i>
                <span>Paramètres paie</span>
            </a>
        </li>
        @endif

        <li class="text-xs text-gray-400 uppercase px-4 pt-4 pb-2">Compte</li>
        <li>
            <a href="{{ route('profile.edit') }}"
               class="sidebar-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-gear"></i>
                <span>Profil</span>
            </a>
        </li>
        <li>
            <button type="button" onclick="logoutModal.showModal()"
                    class="sidebar-item w-full text-left">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Déconnexion</span>
            </button>
        </li>
    </ul>
</aside>
