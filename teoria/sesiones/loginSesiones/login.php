<?php

session_start();

//simulo bbdd con usuarios
$users = [
    [
        "username" => "user1",
        "password" => "pass1"
    ],
    [
        "username" => "user2",
        "password" => "pass2"
    ],
    [
        "username" => "user3",
        "password" => "pass3"
    ]
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //obtengo los datos del formulario

    $username = $_POST['username'];
    $password = $_POST['password'];

    //valido que no esten vacios
    // var_dump($username);
    // var_dump($password);


    //verifico si existe el usuario
    foreach ($users as $user) {
        if ($user['username'] === $username && $user['password'] === $password) {
            // Si existe, guardar en la sesión el usuario y redirigir a la página de bienvenida
            $_SESSION['username'] = $username;
            header('Location: bienvenida.php');
        }
    }

    // Si el usuario no fue encontrado, mostrar el mensaje de error
    echo "<p>Usuario o contraseña incorrectos</p>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h2>Inicio de sesión</h2>
    <form action="login.php" method="POST">
        <label for="username">Usuario: </label>
        <input type="text" name="username" required>
        <label for="password">Contraseña: </label>
        <input type="password" name="password" required>

        <button type="submit">Iniciar sesión</button>
    </form>
</body>

</html>