<?php
require_once 'config.php';
session_start();

// 2. Comprobar si se envió el formulario por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 2.1 Recoger los datos del formulario
    $name     = $_POST['name'];
    $surname  = $_POST['surname'];
    $email    = $_POST['email'];
    $avatar   = $_POST['avatar'];
    $password = $_POST['password'];
    $age      = $_POST['age'];
    $job      = $_POST['job'];

    // 2.2 Hashear la contraseña
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // 2.3 Preparar la sentencia SQL
    //    Nota: date_register lo seteamos con NOW(), rol por defecto "user".
    $stmt = $mysqli->prepare(
        "INSERT INTO USERS (name, surname, email, avatar, password, rol, age, job, date_register)
         VALUES (?, ?, ?, ?, ?, 'user', ?, ?, NOW())"
    );

    // Comprobar si la preparación tuvo éxito
    if (!$stmt) {
        die("Error al preparar la consulta: " . $mysqli->error);
    }

    // 2.4 Vincular parámetros con bind_param

    $stmt->bind_param(
        "sssssis",
        $name,
        $surname,
        $email,
        $avatar,
        $passwordHash,
        $age,
        $job
    );

    // 2.5 Ejecutar la sentencia
    if ($stmt->execute()) {

        header("Location: login.php");
        exit;
    } else {
        echo "Error al registrar el usuario: " . $stmt->error;
    }

    // 2.6 Cerrar statement y conexión
    $stmt->close();
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>

<body>
    <h1>Registro de Usuario</h1>
    <form action="" method="POST">
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="surname">Apellido:</label>
        <input type="text" id="surname" name="surname" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="avatar">Avatar (URL):</label>
        <input type="text" id="avatar" name="avatar"><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="age">Edad:</label>
        <input type="number" id="age" name="age"><br>

        <label for="job">Trabajo:</label>
        <input type="text" id="job" name="job"><br>

        <input type="submit" value="Registrar">
    </form>
</body>

</html>