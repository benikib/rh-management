<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>RH Manager - Gestion des Ressources Humaines</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind via CDN -->
    <script src="https://cdn.tailwindcss.com"></script> --}}

    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">

    <!-- NAVBAR -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between h-20">

                <!-- Logo -->
                <a href="/" class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-indigo-600 flex items-center justify-center">
                        <span class="text-white font-bold text-xl">RH</span>
                    </div>

                    <div>
                        <h1 class="font-bold text-xl text-slate-900">
                            RH Manager
                        </h1>
                        <p class="text-xs text-slate-500">
                            Human Resources
                        </p>
                    </div>
                </a>

                <!-- Menu -->
                <nav class="hidden md:flex items-center gap-8">
                    <a href="#accueil"
                       class="text-sm font-medium text-slate-600 hover:text-indigo-600">
                        Accueil
                    </a>

                    <a href="#fonctionnalites"
                       class="text-sm font-medium text-slate-600 hover:text-indigo-600">
                        Fonctionnalités
                    </a>

                    <a href="#apropos"
                       class="text-sm font-medium text-slate-600 hover:text-indigo-600">
                        À propos
                    </a>

                    <a href="#contact"
                       class="text-sm font-medium text-slate-600 hover:text-indigo-600">
                        Contact
                    </a>
                </nav>

                <!-- Actions -->
                <div class="flex items-center gap-3">

                    <a href="{{ route('login') }}"
                       class="hidden sm:block px-5 py-2.5 text-sm font-semibold text-slate-700 hover:text-indigo-600">
                        Connexion
                    </a>

                    <a href="{{ route('register') }}"
                       class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition">
                        Commencer
                    </a>

                </div>
            </div>
        </div>
    </header>


    <!-- HERO -->
    <section id="accueil" class="pt-32 pb-20 lg:pt-40 lg:pb-28">

        <div class="max-w-7xl mx-auto px-6">

            <div class="grid lg:grid-cols-2 gap-16 items-center">

                <!-- Texte -->
                <div>

                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 text-indigo-700 text-sm font-semibold mb-6">
                        <span class="w-2 h-2 bg-indigo-600 rounded-full"></span>
                        Solution moderne de gestion RH
                    </div>

                    <h2 class="text-5xl lg:text-6xl font-bold tracking-tight text-slate-900 leading-tight">
                        Gérez vos
                        <span class="text-indigo-600">
                            ressources humaines
                        </span>
                        simplement.
                    </h2>

                    <p class="mt-6 text-lg text-slate-600 leading-relaxed max-w-xl">
                        RH Manager centralise toutes vos opérations de ressources humaines
                        dans une plateforme simple, moderne et sécurisée.
                    </p>

                    <div class="mt-8 flex flex-col sm:flex-row gap-4">

                        <a href="{{ route('login') }}"
                           class="px-7 py-3.5 bg-indigo-600 text-white rounded-xl font-semibold text-center hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                            Accéder à mon espace
                        </a>

                        <a href="#fonctionnalites"
                           class="px-7 py-3.5 bg-white border border-slate-300 text-slate-700 rounded-xl font-semibold text-center hover:bg-slate-100 transition">
                            Découvrir la plateforme
                        </a>

                    </div>

                    <!-- Stats -->
                    <div class="mt-12 grid grid-cols-3 gap-6 max-w-lg">

                        <div>
                            <p class="text-3xl font-bold text-slate-900">
                                100%
                            </p>
                            <p class="text-sm text-slate-500 mt-1">
                                Digital
                            </p>
                        </div>

                        <div>
                            <p class="text-3xl font-bold text-slate-900">
                                24/7
                            </p>
                            <p class="text-sm text-slate-500 mt-1">
                                Accessible
                            </p>
                        </div>

                        <div>
                            <p class="text-3xl font-bold text-slate-900">
                                🔒
                            </p>
                            <p class="text-sm text-slate-500 mt-1">
                                Sécurisé
                            </p>
                        </div>

                    </div>

                </div>


                <!-- Dashboard -->
                <div class="relative">

                    <div class="absolute -top-10 -right-10 w-72 h-72 bg-indigo-200 rounded-full blur-3xl opacity-40"></div>

                    <div class="relative bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden">

                        <!-- Dashboard header -->
                        <div class="px-6 py-5 border-b border-slate-200 flex justify-between items-center">

                            <div>
                                <p class="text-sm text-slate-500">
                                    Tableau de bord
                                </p>

                                <h3 class="font-bold text-lg text-slate-900">
                                    Gestion RH
                                </h3>
                            </div>

                            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                👤
                            </div>

                        </div>

                        <!-- Cards -->
                        <div class="p-6 grid grid-cols-2 gap-4">

                            <div class="p-5 bg-indigo-50 rounded-xl">
                                <p class="text-sm text-indigo-600">
                                    Employés
                                </p>

                                <p class="text-3xl font-bold text-slate-900 mt-2">
                                    248
                                </p>

                                <p class="text-xs text-green-600 mt-2">
                                    ↑ 8% ce mois
                                </p>
                            </div>

                            <div class="p-5 bg-emerald-50 rounded-xl">
                                <p class="text-sm text-emerald-600">
                                    Présents
                                </p>

                                <p class="text-3xl font-bold text-slate-900 mt-2">
                                    221
                                </p>

                                <p class="text-xs text-slate-500 mt-2">
                                    Aujourd'hui
                                </p>
                            </div>

                            <div class="p-5 bg-amber-50 rounded-xl">
                                <p class="text-sm text-amber-600">
                                    Congés
                                </p>

                                <p class="text-3xl font-bold text-slate-900 mt-2">
                                    12
                                </p>

                                <p class="text-xs text-slate-500 mt-2">
                                    En attente
                                </p>
                            </div>

                            <div class="p-5 bg-purple-50 rounded-xl">
                                <p class="text-sm text-purple-600">
                                    Départements
                                </p>

                                <p class="text-3xl font-bold text-slate-900 mt-2">
                                    18
                                </p>

                                <p class="text-xs text-slate-500 mt-2">
                                    Actifs
                                </p>
                            </div>

                        </div>

                        <!-- Activity -->
                        <div class="px-6 pb-6">

                            <h4 class="font-semibold text-slate-900 mb-4">
                                Activité récente
                            </h4>

                            <div class="space-y-3">

                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center">
                                        👤
                                    </div>

                                    <div class="flex-1">
                                        <p class="text-sm font-medium">
                                            Nouvel employé ajouté
                                        </p>

                                        <p class="text-xs text-slate-500">
                                            Il y a 15 minutes
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-green-100 flex items-center justify-center">
                                        ✓
                                    </div>

                                    <div class="flex-1">
                                        <p class="text-sm font-medium">
                                            Congé approuvé
                                        </p>

                                        <p class="text-xs text-slate-500">
                                            Il y a 1 heure
                                        </p>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>


    <!-- FONCTIONNALITÉS -->
    <section id="fonctionnalites" class="py-24 bg-white">

        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center max-w-2xl mx-auto">

                <span class="text-indigo-600 font-semibold text-sm">
                    FONCTIONNALITÉS
                </span>

                <h2 class="mt-3 text-4xl font-bold text-slate-900">
                    Tout ce dont votre service RH a besoin
                </h2>

                <p class="mt-4 text-slate-600">
                    Une plateforme centralisée pour simplifier la gestion quotidienne
                    de vos collaborateurs.
                </p>

            </div>


            <div class="mt-14 grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Employee -->
                <div class="p-7 rounded-2xl border border-slate-200 hover:border-indigo-300 hover:shadow-lg transition">

                    <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center text-xl">
                        👥
                    </div>

                    <h3 class="mt-5 text-lg font-bold">
                        Gestion des employés
                    </h3>

                    <p class="mt-3 text-sm text-slate-600 leading-relaxed">
                        Centralisez les informations personnelles et professionnelles
                        de tous vos collaborateurs.
                    </p>

                </div>


                <!-- Attendance -->
                <div class="p-7 rounded-2xl border border-slate-200 hover:border-indigo-300 hover:shadow-lg transition">

                    <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-xl">
                        🕐
                    </div>

                    <h3 class="mt-5 text-lg font-bold">
                        Présences & absences
                    </h3>

                    <p class="mt-3 text-sm text-slate-600 leading-relaxed">
                        Suivez les présences, absences, retards et horaires
                        de vos employés.
                    </p>

                </div>


                <!-- Leave -->
                <div class="p-7 rounded-2xl border border-slate-200 hover:border-indigo-300 hover:shadow-lg transition">

                    <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center text-xl">
                        🏖️
                    </div>

                    <h3 class="mt-5 text-lg font-bold">
                        Gestion des congés
                    </h3>

                    <p class="mt-3 text-sm text-slate-600 leading-relaxed">
                        Gérez les demandes de congés et facilitez leur validation.
                    </p>

                </div>


                <!-- Contracts -->
                <div class="p-7 rounded-2xl border border-slate-200 hover:border-indigo-300 hover:shadow-lg transition">

                    <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center text-xl">
                        📄
                    </div>

                    <h3 class="mt-5 text-lg font-bold">
                        Contrats & documents
                    </h3>

                    <p class="mt-3 text-sm text-slate-600 leading-relaxed">
                        Stockez et gérez facilement les contrats et documents
                        administratifs.
                    </p>

                </div>


                <!-- Payroll -->
                <div class="p-7 rounded-2xl border border-slate-200 hover:border-indigo-300 hover:shadow-lg transition">

                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-xl">
                        💰
                    </div>

                    <h3 class="mt-5 text-lg font-bold">
                        Paie
                    </h3>

                    <p class="mt-3 text-sm text-slate-600 leading-relaxed">
                        Centralisez les informations nécessaires au traitement
                        de la paie.
                    </p>

                </div>


                <!-- Reports -->
                <div class="p-7 rounded-2xl border border-slate-200 hover:border-indigo-300 hover:shadow-lg transition">

                    <div class="w-12 h-12 rounded-xl bg-rose-100 flex items-center justify-center text-xl">
                        📊
                    </div>

                    <h3 class="mt-5 text-lg font-bold">
                        Rapports & statistiques
                    </h3>

                    <p class="mt-3 text-sm text-slate-600 leading-relaxed">
                        Visualisez les indicateurs clés de votre organisation
                        grâce aux rapports RH.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- À PROPOS -->
    <section id="apropos" class="py-24 bg-slate-50">

        <div class="max-w-7xl mx-auto px-6">

            <div class="grid lg:grid-cols-2 gap-16 items-center">

                <div>

                    <span class="text-indigo-600 font-semibold text-sm">
                        POURQUOI RH MANAGER ?
                    </span>

                    <h2 class="mt-4 text-4xl font-bold text-slate-900">
                        Une gestion RH plus simple et plus efficace.
                    </h2>

                    <p class="mt-6 text-slate-600 leading-relaxed">
                        RH Manager permet aux responsables des ressources humaines
                        de centraliser leurs opérations et de gagner du temps
                        grâce à une plateforme unique.
                    </p>

                    <div class="mt-8 space-y-5">

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                ✓
                            </div>

                            <div>
                                <h3 class="font-semibold">
                                    Centralisation
                                </h3>

                                <p class="text-sm text-slate-500 mt-1">
                                    Toutes vos données RH dans un seul espace.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                ✓
                            </div>

                            <div>
                                <h3 class="font-semibold">
                                    Sécurité
                                </h3>

                                <p class="text-sm text-slate-500 mt-1">
                                    Vos données restent protégées et accessibles
                                    uniquement aux personnes autorisées.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                ✓
                            </div>

                            <div>
                                <h3 class="font-semibold">
                                    Gain de temps
                                </h3>

                                <p class="text-sm text-slate-500 mt-1">
                                    Automatisez les tâches administratives répétitives.
                                </p>
                            </div>
                        </div>

                    </div>

                </div>


                <div class="bg-white rounded-3xl p-8 shadow-xl border border-slate-200">

                    <h3 class="text-xl font-bold">
                        Votre espace RH
                    </h3>

                    <p class="mt-2 text-slate-500 text-sm">
                        Accédez rapidement aux principales fonctionnalités.
                    </p>

                    <div class="mt-8 grid grid-cols-2 gap-4">

                        <div class="p-5 rounded-xl bg-slate-50">
                            <span class="text-2xl">👤</span>
                            <p class="mt-3 font-semibold">
                                Employés
                            </p>
                        </div>

                        <div class="p-5 rounded-xl bg-slate-50">
                            <span class="text-2xl">📅</span>
                            <p class="mt-3 font-semibold">
                                Planning
                            </p>
                        </div>

                        <div class="p-5 rounded-xl bg-slate-50">
                            <span class="text-2xl">💼</span>
                            <p class="mt-3 font-semibold">
                                Contrats
                            </p>
                        </div>

                        <div class="p-5 rounded-xl bg-slate-50">
                            <span class="text-2xl">📈</span>
                            <p class="mt-3 font-semibold">
                                Rapports
                            </p>
                        </div>

                    </div>

                    <a href="{{ route('login') }}"
                       class="block mt-8 w-full text-center py-3.5 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition">
                        Ouvrir mon espace RH
                    </a>

                </div>

            </div>

        </div>

    </section>


    <!-- CTA -->
    <section class="py-24">

        <div class="max-w-5xl mx-auto px-6">

            <div class="rounded-3xl bg-indigo-600 px-8 py-16 text-center">

                <h2 class="text-4xl font-bold text-white">
                    Prêt à moderniser votre gestion RH ?
                </h2>

                <p class="mt-5 text-indigo-100 max-w-xl mx-auto">
                    Centralisez vos collaborateurs, automatisez vos processus
                    et prenez de meilleures décisions.
                </p>

                <div class="mt-8">

                    <a href="{{ route('login') }}"
                       class="inline-block px-8 py-4 bg-white text-indigo-700 rounded-xl font-bold hover:bg-indigo-50 transition">
                        Accéder à la plateforme
                    </a>

                </div>

            </div>

        </div>

    </section>


    <!-- FOOTER -->
    <footer id="contact" class="bg-slate-900 text-slate-400">

        <div class="max-w-7xl mx-auto px-6 py-12">

            <div class="grid md:grid-cols-3 gap-10">

                <div>

                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10 rounded-lg bg-indigo-600 flex items-center justify-center">
                            <span class="text-white font-bold">
                                RH
                            </span>
                        </div>

                        <span class="text-white font-bold text-lg">
                            RH Manager
                        </span>

                    </div>

                    <p class="mt-4 text-sm leading-relaxed">
                        Solution moderne pour la gestion des ressources humaines.
                    </p>

                </div>


                <div>

                    <h3 class="text-white font-semibold">
                        Navigation
                    </h3>

                    <div class="mt-4 space-y-3 text-sm">

                        <a href="#accueil" class="block hover:text-white">
                            Accueil
                        </a>

                        <a href="#fonctionnalites" class="block hover:text-white">
                            Fonctionnalités
                        </a>

                        <a href="#apropos" class="block hover:text-white">
                            À propos
                        </a>

                    </div>

                </div>


                <div>

                    <h3 class="text-white font-semibold">
                        Contact
                    </h3>

                    <div class="mt-4 space-y-3 text-sm">

                        <p>
                            📧 contact@rh-manager.com
                        </p>

                        <p>
                            📞 +243 847 473 745
                        </p>

                        <p>
                            📍 Kinshasa, RDC
                        </p>

                    </div>

                </div>

            </div>


            <div class="mt-12 pt-8 border-t border-slate-800 text-sm text-center">
                © {{ date('Y') }} RH Manager. Tous droits réservés.
            </div>

        </div>

    </footer>

</body>
</html>