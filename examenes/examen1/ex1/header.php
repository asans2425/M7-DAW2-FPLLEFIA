<?php
session_start();

if (isset($_SESSION['user'])) {
    echo '<h1>
       Bienvenido ' . $_SESSION['user'] . '!!
    </h1>';
}
?>

<header>

    <nav>
        <ul>
            <li><a href="contacto.php">Contacto</a></li>
            <li><a href="inicio.php">Inicio</a></li>
            <li><a href="productos.php">Inicio</a></li>
        </ul>
    </nav>
</header>