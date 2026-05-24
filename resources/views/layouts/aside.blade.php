<aside id="sidebar" 
            class="fixed inset-y-0 left-0 w-64 bg-gray-900 border-r border-gray-800 shadow-xl rounded-r-2xl p-4 overflow-y-auto transform transition-transform duration-300 ease-in-out z-50 
            -translate-x-full md:translate-x-0 md:relative md:z-auto">

            <!-- Mobile Close Button -->
            <button id="closeSidebarButton" class="absolute top-4 right-4 md:hidden text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- LOGO -->
            <div class="flex items-center space-x-3 px-4 py-4">
                <span class="text-white font-bold text-lg">Marital</span>
            </div>

            <hr class="border-gray-800 my-2">

            <!-- MENU VERTICAL -->
            <ul class="space-y-2">

                <!-- SECTION : Navigation principale -->
                <li class="text-xs text-gray-400 uppercase px-4 pt-4 pb-2">
                    Navigation
                </li>

                @if(Auth::check() && Auth::user()->hasRole('superAdmin')) 
                <li>
                    <a href="{{ route('province.dashboard') }}"
                       class="sidebar-item {{ request()->routeIs('dashboard.superAdmin') ? 'active' : '' }}">
                        <span>🏠</span>
                        <span>Dashboard</span>
                    </a>
                </li>


                <li class="text-xs text-gray-400 uppercase px-4 pt-4 pb-2">
                    Gestion
                </li>
                 <li>
                    <a href="{{ route('personnes.index') }}"
                       class="sidebar-item {{ request()->routeIs('personnes.*') ? 'active' : '' }}">
                        <span>👤</span>
                        <span>Identification</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('mariages.index') }}"
                       class="sidebar-item {{ request()->routeIs('mariages.*') ? 'active' : '' }}">
                        <span>💍</span>
                        <span>Mariages</span>
                    </a>
                </li>

               

                <li>
                    <a href="{{ route('entites.index') }}"
                       class="sidebar-item {{ request()->routeIs('entites.*') ? 'active' : '' }}">
                        <span>🏢</span>
                        <span>Entités</span>
                    </a>
                </li>

                <li class="text-xs text-gray-400 uppercase px-4 pt-4 pb-2">
                    Administration
                </li>   

                <li>
                    <a href="{{ route('users.index') }}"
                       class="sidebar-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <span>👥</span>
                        <span>Utilisateurs</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('roles.index') }}"
                       class="sidebar-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                        <span>🔐</span>
                        <span>Rôles</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('contrats.index') }}"
                       class="sidebar-item {{ request()->routeIs('contrats.*') ? 'active' : '' }}">
                        <span>📄</span>
                        <span>Contrats</span>
                    </a>
                </li>
                <li>
                    
                    <a href="{{ route('regimes.index') }}"
                       class="sidebar-item {{ request()->routeIs('regimes.*') ? 'active' : '' }}">
                        <span>📑</span>
                        <span>Régimes Matrimoniaux</span>
                        </a>
                </li>

                <li>
                    <a href="{{ route('statuts.index') }}"
                       class="sidebar-item {{ request()->routeIs('statuts.*') ? 'active' : '' }}">
                        <span>📊</span>
                        <span>Statuts</span>
                    </a>
                </li>
                
                @endif
                @if((Auth::check() && Auth::user()->hasRole('admin')) )
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <span>🏛</span>
                        <span>Dashboard</span>
                    </a>
                </li>
                {{-- provinnce  --}}
                    <li>
                        <a href="{{ route('province.dashboard') }}"
                        class="sidebar-item {{ request()->routeIs('province.dashboard') ? 'active' : '' }}">
                            <span>🏢</span>
                            <span>Dashboard Province</span>
                        </a>

                @endif

                @if(Auth::check() && Auth::user()->hasRole('agent')) 
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <span>🏛</span>
                        <span>Dashboard</span>
                    </a>
                </li>
                     <li class="text-xs text-gray-400 uppercase px-4 pt-4 pb-2">
                    Gestion
                </li>
                 <li>
                    <a href="{{ route('personnes.index') }}"
                    class="sidebar-item {{ request()->routeIs('personnes.*') ? 'active' : '' }}">
                
                        <span>👤</span>
                        <span>Identification</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('mariages.index') }}"
                    class="sidebar-item {{ request()->routeIs('mariages.*') ? 'active' : '' }}">
                        <span>📜</span>
                        <span>Certificat Mariages</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('composition_familiales.index') }}"
                    class="sidebar-item {{ request()->routeIs('composition_familiales.*') ? 'active' : '' }}">
                        <span>📜</span>
                        <span>Certificat Composition Familiale</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('divorces.index') }}"
                    class="sidebar-item {{ request()->routeIs('divorces.*') ? 'active' : '' }}">
                        <span>📜</span>
                        <span>Attest Divorces</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('nationalites.index') }}"
                    class="sidebar-item {{ request()->routeIs('nationalites.*') ? 'active' : '' }}">
                        <span>🌍</span>
                        <span>Attest Nationalités</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('naissances.index') }}"
                    class="sidebar-item {{ request()->routeIs('naissances.*') ? 'active' : '' }}">
                        <span>👶</span>
                        <span>Attest Naissances</span>
                    </a>
                </li>
                <li>
                    {{-- bonneviemoeurs --}}
                    <a href="{{ route('bonneviemoeurs.index') }}"
                    class="sidebar-item {{ request()->routeIs('bonneviemoeurs.*') ? 'active' : '' }}">
                        <span>✅</span>
                        <span>Attest Bonne Vie & Moeurs</span>
                    </a>
                </li>
               
                <li>
                    <a href="{{ route('residences.index') }}"
                    class="sidebar-item {{ request()->routeIs('residences.*') ? 'active' : '' }}">
                        <span>🏠</span>
                        <span>Attest Résidences</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('veuvages.index') }}"
                    class="sidebar-item {{ request()->routeIs('veuvages.*') ? 'active' : '' }}">
                        <span>💔</span>
                        <span>Attest Veuvages</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('deces.index') }}"
                    class="sidebar-item {{ request()->routeIs('deces.*') ? 'active' : '' }}">
                        <span>⚰️</span>
                        <span>Attest Décès</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('celibats.index') }}"
                    class="sidebar-item {{ request()->routeIs('celibats.*') ? 'active' : '' }}">
                        <span>💑</span>
                        <span>Attest Célibats</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('inhumations.index') }}"
                    class="sidebar-item {{ request()->routeIs('inhumations.*') ? 'active' : '' }}">
                        <span>🪦</span>
                        <span>Attest Inhumations</span>
                    </a>
                </li>
               
                @endif

                <li class="text-xs text-gray-400 uppercase px-4 pt-6 pb-2">
                    Compte
                </li>

                <li>
                    <a href="{{ route('profile.edit') }}"
                       class="sidebar-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <span>⚙️</span>
                        <span>Profil</span>
                    </a>
                </li>

                <li>
                    <button onclick="document.getElementById('logoutModal').showModal();"
                        class="sidebar-item w-full text-left">
                        <span>🚪</span>
                        <span>Déconnexion</span>
                    </button>
                </li>

            </ul>
        </aside>
