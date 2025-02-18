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
       
        


        

    // Redirige de vuelta a la página principal
    header("Location: home.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $id === null ? "Agregar Nuevo Libro" : "Editar Libro" ?> - Biblioteca Virtual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Encabezado del formulario -->
    <header class="bg-light py-3 mb-4 shadow-sm">
        <div class="container d-flex align-items-center justify-content-between">
            <div>
                <h4 class="m-0">👋 Bienvenido, <?= $_SESSION['username'] ?>!</h4>
                <p class="text-muted m-0"><i class="fas fa-user-shield text-success"></i> <?= $_SESSION['role'] === 'admin' ? "Administrador" : "Lector" ?></p>
            </div>
            <a href="home.php" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Volver a la Biblioteca
            </a>
        </div>
    </header>

    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold"><?= $id === null ? "Agregar Nuevo Libro" : "Editar Libro" ?></h2>
            <p class="lead"><?= $id === null ? "Complete los detalles para añadir un nuevo libro a la colección." : "Edite los detalles del libro seleccionado." ?></p>
        </div>

        <!-- Formulario para agregar o editar libro -->
        <form method="POST" class="mx-auto" style="max-width: 600px;">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?= $titulo ?>" placeholder="Título" required>
                <label for="titulo">Título</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="autor" name="autor" value="<?= $autor ?>" placeholder="Autor" required>
                <label for="autor">Autor</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="imagen" name="imagen" value="<?= $imagen ?>" placeholder="URL de la Imagen">
                <label for="imagen">URL de la Imagen</label>
            </div>
            <div class="form-floating mb-4">
                <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripción" style="height: 150px;"><?= $descripcion ?></textarea>
                <label for="descripcion">Descripción</label>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg"><?= $id === null ? "Agregar Libro" : "Guardar Cambios" ?></button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
