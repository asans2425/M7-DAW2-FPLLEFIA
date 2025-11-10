<?php
require 'data.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = trim($_POST["user"]);
    $pass = trim($_POST["pass"]);

    if (isset($usuaris[$user]) && $usuaris[$user] === $pass) {
        $_SESSION["user"] = $user;
        header("Location: home.php");
        exit;
    } else {
        $error = "❌ Usuari o contrasenya incorrectes.";
    }
}
include 'header.php';
?>

<h2>Inici de sessió</h2>
<form method="POST">
    Usuari: <input type="text" name="user"><br><br>
    Contrasenya: <input type="password" name="pass"><br><br>
    <button type="submit">Entrar</button>
</form>

<p style="color:red;"><?php echo $error ?? ""; ?></p>
