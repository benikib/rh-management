<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>QR Codes - {{ date('d/m/Y') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 { text-align: center; color: white; margin-bottom: 10px; }
        .date { text-align: center; color: white; margin-bottom: 5px; font-size: 18px; }
        .heure-rdc {
            text-align: center;
            color: #fbbf24;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .qr-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }
        .qr-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
        }
        .qr-card.arrivee { border-top: 5px solid #10b981; }
        .qr-card.depart { border-top: 5px solid #ef4444; }
        .type {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .arrivee .type { color: #10b981; }
        .depart .type { color: #ef4444; }
        .qr-code { margin: 20px 0; }
        .expiration { font-size: 12px; color: #666; margin-top: 10px; }
        .btn {
            margin-top: 20px;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover { background: #5a67d8; }
        
        /* Style pour le formulaire manuel */
        .manual-section {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-top: 20px;
        }
        .manual-section h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }
        .manual-section h2 span {
            background: #f59e0b;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            margin-left: 10px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            transition: border-color 0.3s;
        }
        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .btn-pointage {
            width: 100%;
            padding: 15px;
            background: #f59e0b;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn-pointage:hover {
            background: #d97706;
        }
        .btn-pointage:disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }
        .message {
            margin-top: 20px;
            padding: 15px;
            border-radius: 10px;
            display: none;
        }
        .message.success {
            background: #d1fae5;
            color: #059669;
            display: block;
        }
        .message.error {
            background: #fee2e2;
            color: #dc2626;
            display: block;
        }
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #fff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 0.6s linear infinite;
            margin-left: 10px;
            vertical-align: middle;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .flag {
            display: inline-block;
            margin-right: 10px;
        }
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            .heure-rdc {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📱 QR Codes Pointage</h1>
        <div class="date">{{ date('d/m/Y') }} - {{ date('l') }}</div>
        
        <!-- Affichage de l'heure de la RDC -->
        <div class="heure-rdc">
            🇨🇩 Heure de Kinshasa (RDC) : <span id="heureRDC">--:--:--</span>
        </div>
        
        <div class="qr-grid">
            <div class="qr-card arrivee">
                <div class="type">✅ ARRIVÉE</div>
                <div class="qr-code">{!! QrCode::size(200)->generate($arriveeUrl) !!}</div>
                <div class="expiration">Valable jusqu'à {{ $arriveeToken->expires_at->format('H:i') }}</div>
                <button class="btn" onclick="window.location.href='{{ $arriveeUrl }}'">Tester le lien</button>
            </div>
            
            <div class="qr-card depart">
                <div class="type">👋 DÉPART</div>
                <div class="qr-code">{!! QrCode::size(200)->generate($departUrl) !!}</div>
                <div class="expiration">Valable jusqu'à {{ $departToken->expires_at->format('H:i') }}</div>
                <button class="btn" onclick="window.location.href='{{ $departUrl }}'">Tester le lien</button>
            </div>
        </div>
        
        <!-- Formulaire pour pointage manuel -->
        <div class="manual-section">
            <h2>⌨️ Pointage manuel <span>sans QR code</span></h2>
            <form id="manualPointageForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="matricule">📝 Matricule</label>
                        <input type="text" id="matricule" name="matricule" placeholder="Ex: EMP001" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="type">🔄 Type de pointage</label>
                        <select id="type" name="type" required>
                            <option value="arrivee">✅ Arrivée</option>
                            <option value="depart">👋 Départ</option>
                        </select>
                    </div>
                </div>
                <button type="button" class="btn-pointage" onclick="pointageManuel()">🎯 Pointer ma présence</button>
            </form>
            <div id="manualMessage" class="message"></div>
        </div>
    </div>
    
    <script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    
    // Fonction pour obtenir l'heure de la RDC (UTC+1 / UTC+2 selon la saison)
    // La RDC a 2 fuseaux: UTC+1 (Kinshasa) et UTC+2 (Lubumbashi)
    // Nous utilisons Kinshasa (UTC+1 toute l'année)
    function getHeureRDC() {
        const now = new Date();
        // Convertir en UTC+1 (Kinshasa)
        const options = {
            timeZone: 'Africa/Kinshasa',
            hour12: false,
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        return new Date().toLocaleTimeString('fr-FR', options);
    }
    
    // Mettre à jour l'heure chaque seconde
    function updateHeureRDC() {
        const heureElement = document.getElementById('heureRDC');
        if (heureElement) {
            heureElement.textContent = getHeureRDC();
        }
    }
    
    // Mettre à jour toutes les secondes
    setInterval(updateHeureRDC, 1000);
    updateHeureRDC();
    
    async function pointageManuel() {
        const matricule = document.getElementById('matricule').value.trim();
        const type = document.getElementById('type').value;
        const btn = document.querySelector('.btn-pointage');
        
        if (!matricule) {
            showMessage('Veuillez entrer votre matricule', 'error');
            return;
        }
        
        btn.disabled = true;
        btn.innerHTML = 'Chargement... <span class="loading"></span>';
        
        try {
            const response = await fetch('/qr/pointage-manuel', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    matricule: matricule,
                    type: type
                })
            });
            
            const result = await response.json();
            
            if (result.success) {
                showMessage(result.message + ' (Heure RDC: ' + getHeureRDC() + ')', 'success');
                document.getElementById('matricule').value = '';
                document.getElementById('matricule').focus();
                
                // Recharger la page après 2 secondes pour mettre à jour
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                showMessage(result.message, 'error');
            }
        } catch (error) {
            showMessage('Erreur de connexion', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '🎯 Pointer ma présence';
        }
    }
    
    function showMessage(msg, type) {
        const div = document.getElementById('manualMessage');
        div.textContent = msg;
        div.className = `message ${type}`;
        setTimeout(() => {
            div.style.display = 'none';
        }, 4000);
    }
    
    // Enter key dans le champ matricule
    document.getElementById('matricule').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            pointageManuel();
        }
    });
    </script>
</body>
</html>