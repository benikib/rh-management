<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome Icons -->
   
   
   
   
   
   
   
   
   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />

    <!-- Tom Select CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- Argon Dashboard CSS -->
    <link href="{{ asset('assets/css/argon-dashboard-tailwind.min.css') }}" rel="stylesheet" />

    <!-- Skeleton Loaders -->
    @include('components.skeleton-loaders')

    <!-- Vite Scripts -->
   
</head>

<body class="m-0 font-sans text-base antialiased font-normal leading-default bg-gray-50 text-slate-500">
    
    <!-- Global Loader -->
    @if(!isset($disableGlobalLoader) || !$disableGlobalLoader)
        @include('components.global-loader', ['context' => $loaderContext ?? 'general'])
    @endif
    
    <div class="absolute w-full bg-blue-500 min-h-12"></div>
    
    <!-- Main Container - Flex layout for sidebar + content -->
    <div class="flex min-h-screen">
        <!-- Mobile Menu Button -->
        <button id="mobileMenuButton" class="fixed top-4 left-4 z-50 md:hidden bg-gray-900 text-white p-2 rounded-lg shadow-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- Overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden transition-opacity duration-300 md:hidden"></div>

        <!-- Sidebar -->
        @include('layouts.aside')
        <!-- Main Content Area -->
        <main class="flex-1 overflow-x-hidden">
            <!-- Page Header -->
            @isset($header)
                <header class="bg-blue-500 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Content Slot -->
            <div class="p-6">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- MODAL LOGOUT -->
    <dialog id="logoutModal" class="rounded-2xl p-0 w-full max-w-md bg-white shadow-xl">
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <div class="bg-red-600 text-white p-4 rounded-t-2xl flex justify-between items-center">
                <span class="font-semibold">Confirmation de déconnexion</span>
                <button type="button" onclick="logoutModal.close()" class="hover:bg-red-700 rounded-full p-1 transition">
                    ✕
                </button>
            </div>

            <div class="p-6 text-gray-700">
                <p>Voulez-vous vraiment vous déconnecter ?</p>
                <p class="text-sm text-gray-500 mt-2">Vous devrez vous reconnecter pour accéder à votre compte.</p>
            </div>

            <div class="flex justify-end gap-2 p-4 bg-gray-100 rounded-b-2xl">
                <button type="button" onclick="logoutModal.close()" 
                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg transition">
                    Annuler
                </button>
                <button type="submit" 
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                    Déconnexion
                </button>
            </div>
        </form>
    </dialog>

    <style>
        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 1rem;
            border-radius: 0.5rem;
            color: #d1d5db;
            transition: all 0.2s ease;
            font-size: 0.875rem;
        }

        .sidebar-item:hover {
            background-color: #374151;
            color: white;
        }

        .sidebar-item.active {
            background-color: #4f46e5;
            color: white;
        }

        .sidebar-item span:first-child {
            font-size: 1.25rem;
        }

        dialog::backdrop {
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        @media (max-width: 768px) {
            .sidebar-item {
                padding: 0.75rem 1rem;
            }
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const closeButton = document.getElementById('closeSidebarButton');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', openSidebar);
        }

        if (closeButton) {
            closeButton.addEventListener('click', closeSidebar);
        }

        if (overlay) {
            overlay.addEventListener('click', closeSidebar);
        }

        const sidebarLinks = sidebar.querySelectorAll('a, button');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 768) {
                    closeSidebar();
                }
            });
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.style.overflow = '';
            } else if (!sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.add('-translate-x-full');
            }
        });
    });
    </script>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}" async></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}" async></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script src="{{ asset('assets/js/argon-dashboard-tailwind.min.js') }}" async></script>
    
    <script>
        document.querySelectorAll('.search-select').forEach(el => {
            new TomSelect(el, {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        });
    </script>
</body>
</html>