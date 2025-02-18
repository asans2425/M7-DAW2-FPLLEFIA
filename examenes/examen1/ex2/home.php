<?php
include 'array.php';
include 'funciones.php';
if (!isset($_SESSION['productos'])) {
    $_SESSION['productos'] = $productos;
}

if ($_POST['nombre'] && $_POST['precio'] && $_POST['descripcion']) {
    agregar_producto($_POST['nombre'], $_POST['precio'], $_POST['descripcion']);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex2 CRUD</title>
</head>

<body>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($_SESSION['productos'] as $key => $p): ?>
            <tr>
                <td><?php echo $p['nombre'] ?></td>
                <td><?php echo $p['precio'] ?></td>
                <td><?php echo $p['descripcion'] ?></td>
                <td><a href="eliminar.php?id=<?= $key ?>"><?= 'Eliminar'; ?></a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre">
        <input type="number" name="precio" placeholder="Precio">
        <input type="text" name="descripcion" placeholder="Descripción">
        <input type="submit" value="Agregar">
    </form>
</body>

</html>