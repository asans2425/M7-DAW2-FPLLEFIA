<?php
require_once('config.php');
session_start();

//0. COMPROBAR SI EL FORMULARIO HA SIDO ENVIADO
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //1. RECOGER DATOS DEL FORMULARIO
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $avatar = $_POST['avatar'];

    //2. cifrar la password con password_hash
    $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

    //3. preparar la consulta antes de insertar para evitar el sql injection
    $stmt = $mysqli->prepare(
        "INSERT INTO USERS (name, surname, email, avatar, password, rol, age, job, date_register) VALUES (?, ?, ?, ?,?, 'user', ?, ?, NOW())"
    );
    //4. COMPROBAR QUE LA PREPARACION TUVO EXITO
    if (!$stmt) {
        die('Error en la preparacion: ' . $mysqli->error);
    }

    //5. BINDEAR LOS PARAMETROS
    $stmt->bind_param('sssssis', $name, $surname, $email, $avatar, $passwordHashed, $age, $job);

    //6. EJECUTAR LA CONSULTA
    if ($stmt->execute()) {
        echo 'Usuario registrado correctamente';
    } else {
        echo 'Error al registrar el usuario';


        //7. CERRAR LA CONEXION
        $stmt->close();
        $mysqli->close();
    }
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>

<body>
    <h1>Reegistro</h1>
    <form action="" method="POST">

        <label for="name">Nombre:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="surname">Apellidos:</label><br>
        <input type="text" id="surname" name="surname" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Contraseña:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <label for="avatar">Avatar:</label><br>
        <input type="text" id="avatar" name="avatar" required><br><br>

        <input type="submit" value="Registrarse">

    </form>
</body>

</html>