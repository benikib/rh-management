<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <title>Connexion</title>
    <!-- Inclure Bootstrap via Vite -->
    <link href="{{ asset('assets/css/argon-dashboard-tailwind.min.css') }}" rel="stylesheet" />
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>

<body class="bg-light d-flex justify-content-center align-items-center min-vh-100">

    <button class="btn btn-primary position-absolute top-0 end-0 m-3"
        onclick="document.body.classList.toggle('bg-dark');document.body.classList.toggle('text-white')">
        🌗 Thème
    </button>

    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
        <h2 class="text-center mb-4">Connexion</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Adresse Email</label>
                <input type="email" class="form-control" id="email" name="email" required autofocus>
                <x-input-error :messages="$errors->get('email')" class="text-danger small mt-1" />
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <x-input-error :messages="$errors->get('password')" class="text-danger small mt-1" />
            </div>

            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label" for="remember">
                        Se souvenir de moi
                    </label>
                </div>
                <a href="{{ route('password.request') }}" class="text-decoration-none">Mot de passe oublié ?</a>
            </div>

            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
        </form>

        {{-- <p class="text-center mt-3 small">
            Pas encore inscrit ? <a href="{{ route('register') }}" class="text-decoration-none">Créer un compte</a>
        </p> --}}
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
