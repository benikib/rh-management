<!DOCTYPE html>
<html>
<head>
    <title>QR Présence</title>
</head>
<body>

    <h1>Scanner pour signaler présence</h1>

    {!! QrCode::size(300)->generate(url('/presence')) !!}

</body>
</html> 