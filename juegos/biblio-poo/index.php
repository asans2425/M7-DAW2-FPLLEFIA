<?php
session_start();
require_once "Libro.php";
require_once "Biblioteca.php";

// Crear o restaurar la biblioteca desde la sesión
if (!isset($_SESSION['biblioteca'])) {
    $_SESSION['biblioteca'] = serialize(new Biblioteca());
}
$biblioteca = unserialize($_SESSION['biblioteca']);

// Gestionar las peticiones del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Si la acción es agregar libro
    if (isset($_POST['accion']) && $_POST['accion'] === 'afegir') {
        $titulo = $_POST['titulo'];
        $autor = $_POST['autor'];
        $anio = $_POST['anio'];
        $foto = $_POST['foto'];

        $libro = new Libro($titulo, $autor, $anio, $foto);
        $biblioteca->agregarLibro($libro);
    }

    // Si la acción es buscar libro
    if (isset($_POST['accion']) && $_POST['accion'] === 'buscar') {
        $resultadoBusqueda = $biblioteca->buscarLibroPorTitulo($_POST['busqueda']);
    }

    // Guardar la biblioteca actualizada en la sesión
    $_SESSION['biblioteca'] = serialize($biblioteca);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col items-center p-6">
    <h1 class="text-2xl font-bold mb-4">Gestió de llibres</h1>

    <!-- Formulari per afegir llibres -->
    <form method="POST" class="mb-6 bg-white shadow rounded p-4 w-full max-w-md">
        <h2 class="text-lg font-bold mb-2">Afegir llibre</h2>
        <input type="hidden" name="accion" value="afegir">
        <label class="block mb-2">
            Títol:
            <input type="text" name="titulo" required class="border rounded w-full p-2">
        </label>
        <label class="block mb-2">
            Autor:
            <input type="text" name="autor" required class="border rounded w-full p-2">
        </label>
        <label class="block mb-2">
            Any de publicació:
            <input type="number" name="anio" required class="border rounded w-full p-2">
        </label>
        <label class="block mb-2">
            Foto (URL):
            <input type="url" name="foto" required class="border rounded w-full p-2">
        </label>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-2 hover:bg-blue-700">
            Afegir llibre
        </button>
    </form>

    <!-- Formulari per buscar llibres -->
    <form method="POST" class="mb-6 bg-white shadow rounded p-4 w-full max-w-md">
        <h2 class="text-lg font-bold mb-2">Buscar llibre</h2>
        <input type="hidden" name="accion" value="buscar">
        <label class="block mb-2">
            Cerca per títol:
            <input type="text" name="busqueda" required class="border rounded w-full p-2">
        </label>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded mt-2 hover:bg-green-700">
            Cercar
        </button>
    </form>

    <!-- Mostrar resultats -->
    <div class="w-full max-w-2xl">
        <?php
        // Si hay resultados de búsqueda, se muestran
        if (isset($resultadoBusqueda)) {
            // Mostramos cada libro de los resultados de búsqueda
            foreach ($resultadoBusqueda as $detalle) {
                echo $detalle;
            }
        } else {
            // Si no hay búsqueda, mostramos todos los libros de la biblioteca
            foreach ($biblioteca->mostrarLibros() as $book) {
                echo $book;
            }
        }
        ?>
    </div>
</body>

</html>