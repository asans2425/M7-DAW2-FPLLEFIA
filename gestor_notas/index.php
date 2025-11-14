<?php
include 'config.php';
echo '<h1>HOLA MUNDO UAB</h1>';


// Consulta para obtener lo de la tabla que consideres. formato de salida--> OBJECT.... NO ME INTERESA :( CAPA 1 
$users = $mysqli->query("SELECT * FROM users");

// CAPA 2: CONVIERTO EL RESULTADO ANTERIOR (OJETO) EN UN ARRAY ASOCAITIVO
$resultUsers = $users->fetch_all(MYSQLI_ASSOC);




print_r($resultUsers);
//recorro y muestro los users 



// $news = $resultNews->fetch_all(MYSQLI_ASSOC);

// // Consulta para obtener los proyectos
// $resultProjects = $mysqli->query("SELECT * FROM PROJECTS ORDER BY id DESC");
// $projects = $resultProjects->fetch_all(MYSQLI_ASSOC);
// ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRIMERA APP</title>
</head>
<body>
    <?php

// Capa 1: obtengo los usuarios (objeto)
$users = $mysqli->query("SELECT * FROM users");
// Capa 2: convierto a array asociativo
$resultUsers = $users->fetch_all(MYSQLI_ASSOC);

// --- Mostrar tabla ---
echo "<table border='1' cellpadding='8' cellspacing='0'>";
echo "<tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Email</th>
        <th>Rol</th>
      </tr>";

// Recorremos el array y mostramos
foreach ($resultUsers as $user) {
    echo "<tr>";
    echo "<td>" . $user['id'] . "</td>";
    echo "<td>" . htmlspecialchars($user['nombre']) . "</td>";
    echo "<td>" . htmlspecialchars($user['apellidos']) . "</td>";
    echo "<td>" . htmlspecialchars($user['email']) . "</td>";
    echo "<td>" . htmlspecialchars($user['role']) . "</td>";
    echo "</tr>";
}

echo "</table>";
?>


</body>
</html>
