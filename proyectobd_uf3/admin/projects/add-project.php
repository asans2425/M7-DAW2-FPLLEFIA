<?php
session_start();
require_once('../../config.php');

//1. verificar que el rol sea administrador
if (($_SESSION['user_rol']) !== 'admin') {
    echo 'No tienes permisos para acceder a esta página';
    exit;
}



//2. comprobar si el formulario ha sido enviado
if(isset($_POST['title'])) {
    //3. recoger los datos del formulario
    $title = $_POST['title'];
    $url = $_POST['url'];
    $description = $_POST['description'];
    $thumbnail = $_POST['thumbnail'];

    //4. preparar la consulta antes de insertar para evitar el sql injection
    $stmt = $mysqli->prepare(
        "INSERT INTO PROJECTS (title, url, description, thumbnail) VALUES (?, ?, ?, ?)"
    );

    //5. comprobar que la preparacion tuvo exito
    if (!$stmt) {
        die('Error en la preparacion: ' . $mysqli->error);
    }

    //6. bindear los parametros
    $stmt->bind_param('ssss', $title, $url, $description, $thumbnail);

    //7. ejecutar la consulta
    if ($stmt->execute()) {
        echo 'Proyecto añadido correctamente';
    } else {
        echo 'Error al añadir el proyecto';
    }

    //8. cerrar la conexion
    $stmt->close();
    $mysqli->close();
}

?>







<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario add project</title>
</head>

<body>


    <h1>Formulario add project</h1>
    <form action="" method="POST">

        <label for="title">Título:</label><br>
        <input type="text" id="title" name="title" required><br><br>

        <label for="url">URL:</label><br>
        <input type="text" id="url" name="url" required><br><br>

        <label for="description">Descripción:</label><br>
        <textarea name="description" id="description" cols="30" rows="10" required></textarea><br><br>

        <label for="thumbnail">Imagen:</label><br>
        <input type="text" id="thumbnail" name="thumbnail" required><br><br>

        <input type="submit" value="Enviar">
    </form>
</body>

</html>