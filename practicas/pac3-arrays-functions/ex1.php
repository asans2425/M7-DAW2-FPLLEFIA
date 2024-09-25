<?php
// Inicializar la lista de frutas
$frutas = [
    ['nombre' => 'Manzana', 'seleccionada' => false, 'imagen' => 'https://static.vecteezy.com/system/resources/thumbnails/040/325/531/small/ai-generated-fresh-green-apple-fruit-isolated-on-transparent-background-free-png.png'],
    ['nombre' => 'Plátano', 'seleccionada' => false, 'imagen' => 'https://example.com/platano.jpg'],
    ['nombre' => 'Naranja', 'seleccionada' => false, 'imagen' => 'https://example.com/naranja.jpg'],
    ['nombre' => 'Fresa', 'seleccionada' => false, 'imagen' => 'https://example.com/fresa.jpg'],
    ['nombre' => 'Kiwi', 'seleccionada' => false, 'imagen' => 'https://example.com/kiwi.jpg']
];

// Marcar fruta como seleccionada
$frutaSeleccionada = null;
if (isset($_GET['seleccionar'])) {
    $indice = $_GET['seleccionar'];
    foreach ($frutas as &$fruta) {
        $fruta['seleccionada'] = false; // Desmarcar todas
    }
    if (isset($frutas[$indice])) {
        $frutas[$indice]['seleccionada'] = true; // Marcar la seleccionada
        $frutaSeleccionada = $frutas[$indice]; // Guardar la fruta seleccionada
    }
}

// Función para mostrar frutas
function mostrarFrutas($frutas) {
    foreach ($frutas as $indice => $fruta) {
        $estado = $fruta['seleccionada'] ? '✔ Seleccionada' : '✖ No seleccionada';
        $clase = $fruta['seleccionada'] ? 'table-success' : 'table-danger';
        echo "<tr class='$clase'>
                <td>{$fruta['nombre']}</td>
                <td>$estado</td>
                <td><a class='btn btn-primary' href='?seleccionar=$indice'>Seleccionar</a></td>
              </tr>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Frutas Favoritas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Selecciona tu Fruta Favorita</h1>

        <table class="table table-bordered mt-4">
            <thead class="thead-dark">
                <tr>
                    <th>Fruta</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php mostrarFrutas($frutas); ?>
            </tbody>
        </table>

        <!-- Mostrar tarjeta de la fruta seleccionada -->
        <?php if ($frutaSeleccionada): ?>
            <div class="card mt-4 w-25 shadow-lg">
                <img src="<?php echo $frutaSeleccionada['imagen']; ?>" class="card-img-top" alt="<?php echo $frutaSeleccionada['nombre']; ?>">
                <div class="card-body bg-warning">
                    <h5 class="card-title"><?php echo $frutaSeleccionada['nombre']; ?></h5>
                    <p class="card-text">¡Esta es tu fruta favorita!</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
