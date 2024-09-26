<?php
// Inicializar la lista de frutas
$frutas = [
    ['nombre' => 'Manzana', 'seleccionada' => false, 'imagen' => 'https://static.vecteezy.com/system/resources/thumbnails/040/325/531/small/ai-generated-fresh-green-apple-fruit-isolated-on-transparent-background-free-png.png'],
    ['nombre' => 'Plátano', 'seleccionada' => false, 'imagen' => 'https://static.vecteezy.com/system/resources/thumbnails/040/325/537/small/ai-generated-fresh-yellow-banana-fruit-isolated-on-transparent-background-free-png.png'],
    ['nombre' => 'Naranja', 'seleccionada' => false, 'imagen' => 'https://static.vecteezy.com/system/resources/thumbnails/040/325/532/small/ai-generated-fresh-orange-fruit-isolated-on-transparent-background-free-png.png'],
    ['nombre' => 'Fresa', 'seleccionada' => false, 'imagen' => 'https://static.vecteezy.com/system/resources/thumbnails/040/325/535/small/ai-generated-fresh-strawberry-fruit-isolated-on-transparent-background-free-png.png'],
    ['nombre' => 'Kiwi', 'seleccionada' => false, 'imagen' => 'https://static.vecteezy.com/system/resources/thumbnails/040/325/530/small/ai-generated-fresh-kiwi-fruit-isolated-on-transparent-background-free-png.png']
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
                <td><a class='btn btn-primary' href='?seleccionar=$indice&color=" . ($_GET['color'] ?? 'white') . "'>Seleccionar</a></td>
              </tr>";
    }
}

// Establecer el color de fondo
$colorFondo = isset($_GET['color']) ? $_GET['color'] : 'white';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Frutas Favoritas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .color-palette {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1000;
        }
        .color-palette a {
            display: inline-block;
            width: 30px;
            height: 30px;
            margin-left: 5px;
            border: 1px solid #000;
            border-radius: 5px;
        }
    </style>
</head>
<body style="background-color: <?php echo $colorFondo; ?>;">
    <div class="color-palette">
      
        <a href="?color=red&seleccionar=<?php echo isset($_GET['seleccionar']) ? $_GET['seleccionar'] : ''; ?>" style="background-color: red;"></a>
        <a href="?color=blue&seleccionar=<?php echo isset($_GET['seleccionar']) ? $_GET['seleccionar'] : ''; ?>" style="background-color: blue;"></a>
        <a href="?color=green&seleccionar=<?php echo isset($_GET['seleccionar']) ? $_GET['seleccionar'] : ''; ?>" style="background-color: green;"></a>
        <a href="?color=yellow&seleccionar=<?php echo isset($_GET['seleccionar']) ? $_GET['seleccionar'] : ''; ?>" style="background-color: yellow;"></a>
        <a href="?color=orange&seleccionar=<?php echo isset($_GET['seleccionar']) ? $_GET['seleccionar'] : ''; ?>" style="background-color: orange;"></a>
        <a href="?color=pink&seleccionar=<?php echo isset($_GET['seleccionar']) ? $_GET['seleccionar'] : ''; ?>" style="background-color: pink;"></a>
    </div>

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
