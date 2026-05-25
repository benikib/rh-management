<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pointage {{ isset($type) && $type === 'arrivee' ? 'Arrivée' : 'Départ' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 450px;
            width: 100%;
            text-align: center;
        }
        h1 { color: #333; margin-bottom: 10px; }
        .type {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 30px;
            color: {{ isset($type) && $type === 'arrivee' ? '#10b981' : '#ef4444' }};
        }
        input {
            width: 100%;
            padding: 15px;
            font-size: 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        button {
            width: 100%;
            padding: 15px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
        }
        button:disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 10px;
            display: none;
        }
        .message.success { background: #d1fae5; color: #059669; display: block; }
        .message.error { background: #fee2e2; color: #dc2626; display: block; }
        .message.info { background: #dbeafe; color: #1e40af; display: block; }
        
        .employe-info {
            background: #f3f4f6;
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
            text-align: left;
            display: none;
        }
        .employe-info.show {
            display: block;
            animation: fadeIn 0.5s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .employe-info h3 {
            color: #333;
            margin-bottom: 15px;
            text-align: center;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }
        .info-row {
            display: flex;
            margin-bottom: 12px;
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-label {
            font-weight: bold;
            width: 100px;
            color: #667eea;
        }
        .info-value {
            flex: 1;
            color: #333;
        }
        .btn-valider {
            background: #10b981;
            margin-top: 10px;
        }
        .btn-valider:hover {
            background: #059669;
        }
        .btn-annuler {
            background: #6b7280;
            margin-top: 10px;
        }
        .btn-annuler:hover {
            background: #4b5563;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Pointage {{ isset($type) && $type === 'arrivee' ? 'Arrivée' : 'Départ' }}</h1>
        <div class="type">{{ isset($type) ? strtoupper($type) : 'POINTAGE' }}</div>
        
        <!-- Étape 1: Entrer le matricule -->
        <div id="step1">
            <input type="text" id="matricule" placeholder="Entrez votre matricule" autofocus>
            <button onclick="verifierEmploye()">Vérifier</button>
        </div>
        
        <!-- Étape 2: Confirmation employé -->
        <div id="step2" style="display:none;">
            <div class="employe-info" id="employeInfo"></div>
            <button class="btn-valider" onclick="confirmerPointage()">✅ Confirmer mon pointage</button>
            <button class="btn-annuler" onclick="annuler()">❌ Annuler</button>
        </div>
        
        <div id="message" class="message"></div>
    </div>
    
    <script>
    const token = '{{ $token ?? '' }}';
    const type = '{{ $type ?? '' }}';
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    let currentEmploye = null;
    
    async function verifierEmploye() {
        const matricule = document.getElementById('matricule').value.trim();
        if (!matricule) {
            showMessage('Entrez votre matricule', 'error');
            return;
        }
        
        const btn = event.target;
        btn.disabled = true;
        btn.innerHTML = 'Vérification... <span class="loading"></span>';
        
        try {
            const response = await fetch('/qr/verifier-employe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ matricule: matricule })
            });
            
            const result = await response.json();
            
            if (result.success) {
                currentEmploye = result.employe;
                afficherInfosEmploye(result.employe);
                document.getElementById('step1').style.display = 'none';
                document.getElementById('step2').style.display = 'block';
                showMessage('Veuillez confirmer vos informations', 'info');
            } else {
                showMessage(result.message, 'error');
                document.getElementById('matricule').value = '';
                document.getElementById('matricule').focus();
            }
        } catch (error) {
            showMessage('Erreur de connexion', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = 'Vérifier';
        }
    }
    
    function afficherInfosEmploye(employe) {
        const html = `
            <h3>👤 Confirmez votre identité</h3>
            <div class="info-row">
                <div class="info-label">Matricule:</div>
                <div class="info-value"><strong>${employe.matricule}</strong></div>
            </div>
            <div class="info-row">
                <div class="info-label">Nom complet:</div>
                <div class="info-value">${employe.nom_complet}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Département:</div>
                <div class="info-value">${employe.departement || '-'}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Poste:</div>
                <div class="info-value">${employe.poste || '-'}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value">${employe.email || '-'}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Téléphone:</div>
                <div class="info-value">${employe.telephone || '-'}</div>
            </div>
        `;
        document.getElementById('employeInfo').innerHTML = html;
        document.getElementById('employeInfo').classList.add('show');
    }
    
    async function confirmerPointage() {
        if (!currentEmploye) return;
        
        const btn = event.target;
        btn.disabled = true;
        btn.innerHTML = 'Pointage en cours... <span class="loading"></span>';
        
        try {
            const response = await fetch('/qr/pointage', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    token: token,
                    matricule: currentEmploye.matricule
                })
            });
            
            const result = await response.json();
            
            if (result.success) {
                showMessage(result.message, 'success');
                setTimeout(() => window.close(), 2000);
            } else {
                showMessage(result.message, 'error');
                btn.disabled = false;
                btn.innerHTML = '✅ Confirmer mon pointage';
            }
        } catch (error) {
            showMessage('Erreur de connexion', 'error');
            btn.disabled = false;
            btn.innerHTML = '✅ Confirmer mon pointage';
        }
    }
    
    function annuler() {
        currentEmploye = null;
        document.getElementById('step2').style.display = 'none';
        document.getElementById('step1').style.display = 'block';
        document.getElementById('matricule').value = '';
        document.getElementById('matricule').focus();
        document.getElementById('message').style.display = 'none';
    }
    
    function showMessage(msg, type) {
        const div = document.getElementById('message');
        div.textContent = msg;
        div.className = `message ${type}`;
        div.style.display = 'block';
        setTimeout(() => {
            div.style.display = 'none';
        }, 3000);
    }
    
    document.getElementById('matricule').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') verifierEmploye();
    });
    </script>
</body>
</html>