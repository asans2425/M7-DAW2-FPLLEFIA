<?php
session_start();
require 'functions.php'; // Incluye las funciones de manejo de libros

// Verifica si el usuario tiene el rol de admin; si no, redirige a home.php.
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: home.php");
    exit;
}

// Variables para almacenar la información del libro.
$titulo = $autor = $imagen = $descripcion = "";
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id !== null && isset($_SESSION['libros'][$id])) {
    $libro = $_SESSION['libros'][$id];
    $titulo = $libro['titulo'];
    $autor = $libro['autor'];
    $imagen = $libro['imagen'];
    $descripcion = $libro['descripcion'];
}

// Procesar el formulario al enviarse
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $imagen = $_POST['imagen'];
    $descripcion = $_POST['descripcion'];

    if ($id === null) {
        agregarLibro($titulo, $autor, $imagen, $descripcion);
    } else {
        editarLibro($id, $titulo, $autor, $imagen, $descripcion);
    }

    // Redirige de vuelta a la página principal
    header("Location: home.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar o Editar Libro</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2><?= $id === null ? "Agregar Nuevo Libro" : "Editar Libro" ?></h2>
        <form method="POST">
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?= $titulo ?>" required>
            </div>
            <div class="form-group">
                <label for="autor">Autor</label>
                <input type="text" class="form-control" id="autor" name="autor" value="<?= $autor ?>" required>
            </div>
            <div class="form-group">
                <label for="imagen">URL de la Imagen</label>
                <input type="text" class="form-control" id="imagen" name="imagen" value="<?= $imagen ?>">
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion"><?= $descripcion ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
