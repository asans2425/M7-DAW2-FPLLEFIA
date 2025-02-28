<?php
session_start();
require_once('../config.php');

//1. verificar que el rol sea administrador
if (($_SESSION['user_rol']) !== 'admin') {
    echo 'No tienes permisos para acceder a esta página';
    exit;
}

//aqui irn todas las tablas de la base de datos para que el admin pueda gestionarlas

//extraccion de testimonios
$resultTestimonios = $mysqli->query("SELECT * FROM TESTIMONIALS");
$testimonios = $resultTestimonios->fetch_all(MYSQLI_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Panel de administrador</h1>

    <h2>Testimonios</h2>


    <!-- aqui va la tabla dinamica mostrando los testimonios de la bbdd -->
    <table class="table" border="1">
        <tr>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Testimonio</th>
            <th>Valoración</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($testimonios as $item) : ?>
            <tr>
                <td><?= $item['name'] ?></td>
                <td><?= $item['surname'] ?></td>
                <td><?= $item['description'] ?></td>
                <td><?= $item['rating'] ?></td>
                <td>
                    <a href="edit-testimonial.php?id=<?= $item['id'] ?>">Editar</a>
                    <a href="delete-testimonial.php?id=<?= $item['id'] ?>">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>


    <h2>Usuarios</h2>
    <h2>Noticias</h2>
    <h2>Proyectos</h2>
</body>

</html>