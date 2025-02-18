<?php
session_start();

if (isset($_POST[
    
    'user'])) {
    $_SESSION['user'] = $_POST['user'];
    header('Location: inicio.php');
    exit;
}
require_once('header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EX1</title>
</head>

<body>
    <form method="post">
        <input name="user" type="text">
        <button type="submit">Enviar</button>
    </form>
</body>

</html>