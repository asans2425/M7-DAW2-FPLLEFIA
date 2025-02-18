<?php
session_start();
require 'functions.php';

// Verifica si el usuario ha iniciado sesión; si no, redirige a login.php.
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Verifica el rol del usuario
$isAdmin = ($_SESSION['role'] === 'admin');

// Obtener la lista de libros desde la sesión
$libros = $_SESSION['libros'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca Virtual - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Bienvenido a la Biblioteca Virtual</h1>
        <p class="text-center">Usuario: <?= $_SESSION['username'] ?> | Rol: <?= ucfirst($_SESSION['role']) ?></p>

        <!-- Botón de agregar libro (solo visible para el admin) -->
        <?php if ($isAdmin): ?>
            <div class="text-center mb-4">
                <a href="add_edit_book.php" class="btn btn-success">Agregar Nuevo Libro</a>
            </div>
        <?php endif; ?>

        <!-- Mostrar lista de libros en formato de tarjetas Bootstrap -->
        <div class="row">
            <?php foreach ($libros as $index => $libro): ?>
                <div class="col-md-3">
                    <div class="card mb-4">
                        <img src="<?= $libro['imagen'] ?>" class="card-img-top" alt="<?= $libro['titulo'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $libro['titulo'] ?></h5>
                            <p class="card-text"><strong>Autor:</strong> <?= $libro['autor'] ?></p>
                            <p class="card-text"><?= $libro['descripcion'] ?></p>

                            <!-- Botones de editar y eliminar (solo para el admin) -->
                            <?php if ($isAdmin): ?>
                                <a href="add_edit_book.php?id=<?= $index ?>" class="btn btn-primary">Editar</a>
                                <a href="delete_book.php?id=<?= $index ?>" class="btn btn-danger">Eliminar</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Botón de cerrar sesión -->
        <div class="text-center mt-4">
            <a href="logout.php" class="btn btn-secondary">Cerrar Sesión</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
