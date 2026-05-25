<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Erreur QR Code</title>
    <style>
        body {
            font-family: Arial;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
        }
        .error { color: #dc2626; font-size: 18px; margin: 20px 0; }
        button {
            padding: 10px 20px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>❌ Erreur</h1>
        <div class="error">{{ $message }}</div>
        <button onclick="window.close()">Fermer</button>
    </div>
    <script>setTimeout(() => window.close(), 3000);</script>
</body>
</html>