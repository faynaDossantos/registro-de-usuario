<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formulario de Registro</title>
    <link href="estilos.css" type="text/css" rel="stylesheet">
</head>
<body>
    <div class="group">
        <form method="POST" action="">
            <h2>Formulario de Registro</h2>
            <label for="nombre">Nombre<span><em>(requerido)</em></span></label>
            <input type="text" id="nombre" name="nombre" class="form-input" required/>

            <label for="apellido1">Primer Apellido<span><em>(requerido)</em></span></label>
            <input type="text" id="apellido1" name="apellido1" class="form-input" required/>

            <label for="apellido2">Segundo Apellido<span><em>(requerido)</em></span></label>
            <input type="text" id="apellido2" name="apellido2" class="form-input" required/>

            <label for="email">Email<span><em>(requerido)</em></span></label>
            <input type="email" id="email" name="email" class="form-input" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Por favor, introduce un correo electrónico válido" />

            <label for="login">Login<span><em>(requerido)</em></span></label>
            <input type="text" id="login" name="login" class="form-input" required/>

            <label for="password">Contraseña<span><em>(requerido)</em></span></label>
            <input type="password" id="password" name="password" class="form-input" required pattern=".{4,8}" title="La contraseña debe tener entre 4 y 8 caracteres" />

            <input type="submit" value="Registrarse">
        </form>
    </div>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $email = $_POST['email'];
    $login = $_POST['login'];
    $userPassword = $_POST['password']; // Usar una variable diferente para la contraseña

    // conexión con PDO
    $servername = "localhost";
    $username = "root";
    $dbPassword = "";
    $dbname = "formulario";

    // Crear conexión
    $conn = new mysqli($servername, $username, $dbPassword, $dbname);
    // Verificar conexión
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Realizar consulta en la tabla de usuarios
$sqlConsulta = "SELECT * FROM usuarios";
$resultado = $conn->query($sqlConsulta);

// Mostrar los registros obtenidos
if ($resultado->num_rows > 0) {
    echo "<h2>Registros de usuarios:</h2>";
    while ($fila = $resultado->fetch_assoc()) {
        echo "Nombre: " . $fila['nombre'] . "<br>";
        echo "Primer Apellido: " . $fila['apellido1'] . "<br>";
        echo "Segundo Apellido: " . $fila['apellido2'] . "<br>";
        echo "Email: " . $fila['email'] . "<br>";
        echo "Login: " . $fila['acceso'] . "<br>";
        echo "Contraseña: " . $fila['contraseña'] . "<br>";
        echo "<br>";
    }
} else {
    echo "No hay registros de usuarios.";
}

    // Validar el campo de email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Por favor, introduce un correo electrónico válido";
    exit;
}

// Validar el campo de password
if (strlen($userPassword) < 4 || strlen($userPassword) > 8) {
    echo "La contraseña debe tener entre 4 y 8 caracteres";
    exit;
}

    $sql = "INSERT INTO usuarios (nombre, apellido1, apellido2, email, acceso, contraseña)
            VALUES ('$nombre', '$apellido1', '$apellido2', '$email', '$login', '$userPassword')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
}
?>
