<?php
session_start();
require 'functions.php'; // Incluye las funciones de manejo de libros

// Verifica si el usuario tiene el rol de admin; si no, redirige a home.php.
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: home.php");
    exit;
}

// Verifica si se ha pasado un ID en la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Llama a la función para eliminar el libro
    eliminarLibro($id);
}

// Redirige de vuelta a la página principal después de eliminar el libro
header("Location: home.php");
exit;
?>
