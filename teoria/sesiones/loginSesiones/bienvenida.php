
<?php


session_start();

if (!isset($_SESSION['username'])) {

    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenida</title>
</head>

<body>
    <header>
        <h1>Bienvenido <?= $_SESSION['username'] ?></h1>
        <a href="logout.php">Cerrar sesión</a>
    </header>
</body>

</html>