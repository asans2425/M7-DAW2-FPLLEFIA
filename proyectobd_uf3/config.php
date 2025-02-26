<?php
$host = 'mysql-asans.alwaysdata.net';
$dbname = 'asans_proyecto_prueba';
$username = 'asans';
$password = 'soydaw2025';

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

$mysqli->set_charset("utf8mb4");
