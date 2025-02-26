<?php
session_start();
require_once 'config.php';

// 2. Comprobamos si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 2.1 Recogemos los datos del formulario

    $email = $_POST['email'];
    $password = $_POST['password'];

    // 2.2 Consulta para comprobar si el usuario existe
    $sql = "SELECT * FROM USERS WHERE email = '$email' LIMIT 1";
    $resultado = $mysqli->query($sql);

    // 2.3 Comprobamos si la consulta devolvió algo
    if ($resultado && $resultado->num_rows > 0) {
        // Obtenemos la fila como array asociativo
        $user = $resultado->fetch_assoc();

        // 2.4 Verificamos la contraseña con password_verify
        if (password_verify($password, $user['password'])) {
            // 2.5 Guardamos en $_SESSION la información del usuario para que esté disponible en toda la navegación
            $_SESSION['user_id']      = $user['id'];
            $_SESSION['user_email']   = $user['email'];
            $_SESSION['user_name']    = $user['name'];
            $_SESSION['user_surname'] = $user['surname'];
            $_SESSION['user_rol']     = $user['rol'];
            $_SESSION['user_avatar']  = $user['avatar'];

            header("Location: index.php");
            exit;
        } else {
            echo "La contraseña no es correcta.";
        }

        // Liberar el resultado en memoria (buena práctica)
        $resultado->free();
    } else {
        echo "El usuario no existe.";
    }

    // Cerrar la conexión
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
</head>

<body>
    <h1>Iniciar Sesión</h1>
    <form action="" method="POST">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Contraseña:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Iniciar Sesión">
    </form>
</body>

</html>