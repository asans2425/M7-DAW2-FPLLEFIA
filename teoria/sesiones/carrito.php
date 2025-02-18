<?php
session_start();
//inicializar el carrito 
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// var_dump($_SESSION['carrito']);

//añadir productos al carrito
$item = $_POST['item'];

//manera 1 de hacer push
// $_SESSION['carrito'][] = $item;

//manera 2 de hacer push
array_push($_SESSION['carrito'], $item);
var_dump($_SESSION['carrito']);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
</head>

<body>
    <h2>Carrito compra con sesiones</h2>
    <form action="carrito.php" method="POST">
        <input type="text" placeholder="Añade un producto: " required name="item">
        <button type="submit">Agregar producto</button>
    </form>


    <section>
        <h3>Productos del carrito</h3>
        <table>
            <thead>
                <tr>
                    <th>Nombre del producto</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['carrito'] as $item) : ?>
                    <tr>
                        <td><?= $item ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</body>

</html>