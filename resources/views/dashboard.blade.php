<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Tableau de bord</h2>
    </x-slot>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ([
            ['route' => 'employes.index', 'label' => 'Employés', 'icon' => 'fa-id-card', 'color' => 'bg-blue-500'],
            ['route' => 'departements.index', 'label' => 'Départements', 'icon' => 'fa-building', 'color' => 'bg-indigo-500'],
            ['route' => 'postes.index', 'label' => 'Postes', 'icon' => 'fa-briefcase', 'color' => 'bg-purple-500'],
            ['route' => 'presences.index', 'label' => 'Présences', 'icon' => 'fa-clock', 'color' => 'bg-green-500'],
            ['route' => 'conges.index', 'label' => 'Congés', 'icon' => 'fa-calendar-days', 'color' => 'bg-amber-500'],
            ['route' => 'carrieres.index', 'label' => 'Carrières', 'icon' => 'fa-chart-line', 'color' => 'bg-teal-500'],
            ['route' => 'documents.index', 'label' => 'Documents', 'icon' => 'fa-file', 'color' => 'bg-orange-500'],
            ['route' => 'users.index', 'label' => 'Utilisateurs', 'icon' => 'fa-users', 'color' => 'bg-slate-600'],
            ['route' => 'roles.index', 'label' => 'Rôles', 'icon' => 'fa-user-shield', 'color' => 'bg-rose-500'],
        ] as $module)
            <a href="{{ route($module['route']) }}"
               class="block rounded-xl shadow p-6 text-white {{ $module['color'] }} hover:opacity-90 transition">
                <i class="fa-solid {{ $module['icon'] }} text-2xl mb-3"></i>
                <h3 class="text-lg font-semibold">{{ $module['label'] }}</h3>
            </a>
        @endforeach
    </div>
</x-app-layout>
