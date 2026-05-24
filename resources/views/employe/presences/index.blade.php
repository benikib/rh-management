<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pointage Présence</title>

    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
        }

        .container {
            max-width: 400px;
            margin: auto;
            margin-top: 80px;
            text-align: center;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        button {
            background: #2563eb;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #1e40af;
        }

        .success {
            color: green;
            margin-bottom: 10px;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Pointage Présence</h1>

    <p>Veuillez valider votre identité</p>

    {{-- Messages --}}
    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="error">
            {{ session('error') }}
        </div>
    @endif

    {{-- Bouton biométrie --}}
    <button onclick="pointerPresence()">
        Pointer ma présence
    </button>

</div>

<script>
async function pointerPresence() {

    try {
        // 🔐 Déclenche Face ID / empreinte
        const credential = await navigator.credentials.get({
            publicKey: {
                challenge: new Uint8Array([1,2,3,4]), // remplacé plus tard par Laravel
                timeout: 60000,
                userVerification: "required"
            }
        });

        // 📡 Envoi vers Laravel
        const response = await fetch("/presence/check", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                credential: credential
            })
        });

        const data = await response.json();

        alert(data.message);

    } catch (error) {
        console.log(error);
        alert("Authentification échouée ou annulée");
    }
}
</script>

</body>
</html>