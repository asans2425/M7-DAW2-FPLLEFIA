<?php
$host = 'mysql-asans.alwaysdata.net';
$dbname = 'asans_gestor_notas_uab';
$username = 'asans';
$password = 'soydaw2026';




$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}else{
    echo '<br><br>';
    echo "Conexión exitosa a la base de datos gestor_notas_uab";
}

