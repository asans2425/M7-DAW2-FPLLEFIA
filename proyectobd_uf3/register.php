<?php
require_once('config.php');
session_start();

// Definir la carpeta donde se guardarán las fotos
$uploadDir = 'uploads/';


//0. COMPROBAR SI EL FORMULARIO HA SIDO ENVIADO
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //1. RECOGER DATOS DEL FORMULARIO
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    //2. COMPROBAR SI SE HA SUBIDO UN ARCHIVO
    
    // 2. Procesar el archivo subido (la foto del avatar)
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        // Obtener información del archivo
        $fileTmpPath = $_FILES['avatar']['tmp_name'];  // Ruta temporal
        $fileName    = $_FILES['avatar']['name'];      // Nombre original

        // Separar el nombre y la extensión del archivo
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Definir las extensiones permitidas (solo imágenes)
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileExtension, $allowedExtensions)) {
            // Renombrar el archivo para evitar duplicados (usamos md5 y time)
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            // Ruta final en la carpeta uploads
            $dest_path = $uploadDir . $newFileName;

            // Mover el archivo de la carpeta temporal a la carpeta uploads
            if (!move_uploaded_file($fileTmpPath, $dest_path)) {
                die('Error: No se pudo mover el archivo a la carpeta de destino.');
            }
        } else {
            die('Error: Solo se permiten archivos de imagen (jpg, jpeg, png, gif).');
        }
    } else {
        die('Error: La foto no se subió correctamente.');
    }


    //2. cifrar la password con password_hash
    $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

    //3. preparar la consulta antes de insertar para evitar el sql injection
    $stmt = $mysqli->prepare(
        "INSERT INTO USERS (name, surname, email, avatar, password, rol, age, job, date_register) VALUES (?, ?, ?, ?,?, 'user', ?, ?, NOW())"
    );
    //4. COMPROBAR QUE LA PREPARACION TUVO EXITO
    if (!$stmt) {
        die('Error en la preparacion: ' . $mysqli->error);
    }

    //5. BINDEAR LOS PARAMETROS
    $stmt->bind_param('sssssis', $name, $surname, $email, $dest_path, $passwordHashed, $age, $job);


    //6. EJECUTAR LA CONSULTA
    if ($stmt->execute()) {
        echo 'Usuario registrado correctamente';
    } else {
        echo 'Error al registrar el usuario';


        //7. CERRAR LA CONEXION
        $stmt->close();
        $mysqli->close();
    }
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>

<body>
    <h1>Reegistro</h1>
    <!-- AÑADIMOS EL ATRIBUTO ENCTYPE PARA PERMITIR AL SUBIDA DE ARCHIVOS -->
    <form action="" method="POST" enctype="multipart/form-data">

        <label for="name">Nombre:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="surname">Apellidos:</label><br>
        <input type="text" id="surname" name="surname" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Contraseña:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <label for="avatar">Avatar:</label><br>
        <input type="file" id="avatar" name="avatar" accept="image/*" required><br><br>

        <input type="submit" value="Registrarse">

    </form>
</body>

</html>