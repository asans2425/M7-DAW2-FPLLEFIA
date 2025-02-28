<?php
session_start();
require_once('config.php');

//1. comprobar si el formulario ha sido enviado

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //2. GUARDAMOSDATOS DEL FORMULARIO EN VARIABLES
    $email = $_POST['email'];
    $password = $_POST['password'];

    //3. EJECUTAR LA CONSULTA
    $result = $mysqli->query("SELECT * FROM USERS WHERE email = '$email' LIMIT 1");

    //4. COMPROBAR SI HAY RESULTADOS
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        //5. COMPROBAR SI LA CONTRASEÑA ES CORRECTA
        if (password_verify($password, $user['password'])) {
            //6. INICIAR SESION
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_surname'] = $user['surname'];
            $_SESSION['user_avatar'] = $user['avatar'];
            $_SESSION['user_rol'] = $user['rol'];
            $_SESSION['user_age'] = $user['age'];
            $_SESSION['user_job'] = $user['job'];

            //7. REDIRIGIR A LA PAGINA DE INICIO
            header('Location: index.php');
        } else {
            echo 'Contraseña incorrecta';
        }

        //
        header('Location: index.php');
    } else {
        echo 'Usuario no encontrado';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
</head>

<body>
    <h1>INICIO DE SESIÓN</h1>
    <form action="" method="POST">

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Contraseña:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Iniciar sesión">

    </form>
</body>

</html>