<!DOCTYPE html>
<html>
<head>
    <title>Nuevo Mensaje de Contacto</title>
</head>
<body>
    <h2>Has recibido un nuevo mensaje desde tu portafolio:</h2>
    <p><strong>Nombre:</strong> {{ $datos['name'] }}</p>
    <p><strong>Email:</strong> {{ $datos['email'] }}</p>
    <p><strong>Asunto:</strong> {{ $datos['subject'] }}</p>
    <hr>
    <p><strong>Mensaje:</strong></p>
    <p>{{ $datos['message'] }}</p>
</body>
</html>