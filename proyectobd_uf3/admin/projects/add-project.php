<?php
session_start();
require_once '../../config.php';

// 1. Verificar que sea un usuario con rol "admin"
if (!isset($_SESSION['user_id']) || $_SESSION['user_rol'] !== 'admin') {
    echo "<h1>No tienes permisos para acceder aquí</h1>";
    exit;
}

// 2. Si el formulario se envía por método POST, procesamos la inserción
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los campos del formulario
    $title       = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $thumbnail   = $_POST['thumbnail'] ?? '';
    $url         = $_POST['url'] ?? '';

    // Insertar en la base de datos
    // (Recomendado usar prepared statements para mayor seguridad)
    $sqlInsert = "INSERT INTO PROJECTS (title, description, thumbnail, url)
                  VALUES ('$title', '$description', '$thumbnail', '$url')";

    if ($mysqli->query($sqlInsert)) {
        // Redirigir a la página de proyectos tras insertar con éxito
        header("Location: ../adminPanel.php");
        exit;
    } else {
        echo "<p>Error al insertar el proyecto: " . $mysqli->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Añadir Nuevo Proyecto</title>
    <!-- Estilos Tailwind si lo deseas -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-4">
    <h1 class="text-2xl font-bold mb-4">Añadir nuevo proyecto</h1>

    <form action="" method="POST" class="max-w-md bg-white p-4 rounded shadow-md">
        <div class="mb-4">
            <label for="title" class="block font-semibold mb-1">Título:</label>
            <input type="text" name="title" id="title" required
                class="border border-gray-300 p-2 w-full"
                placeholder="Ej: Mi Proyecto Increíble">
        </div>

        <div class="mb-4">
            <label for="description" class="block font-semibold mb-1">Descripción:</label>
            <textarea name="description" id="description" rows="4"
                class="border border-gray-300 p-2 w-full"
                placeholder="Describe tu proyecto aquí..."></textarea>
        </div>

        <div class="mb-4">
            <label for="thumbnail" class="block font-semibold mb-1">Thumbnail (URL de la imagen):</label>
            <input type="text" name="thumbnail" id="thumbnail"
                class="border border-gray-300 p-2 w-full"
                placeholder="Ej: https://misitio.com/imagen.jpg">
        </div>

        <div class="mb-4">
            <label for="url" class="block font-semibold mb-1">URL del proyecto:</label>
            <input type="text" name="url" id="url"
                class="border border-gray-300 p-2 w-full"
                placeholder="Ej: https://github.com/miProyecto">
        </div>

        <div>
            <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Guardar
            </button>
            <a href="adminProjects.php"
                class="ml-4 text-blue-600 hover:underline">
                Volver
            </a>
        </div>
    </form>
</body>

</html>