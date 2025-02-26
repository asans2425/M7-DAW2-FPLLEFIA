<?php
session_start();
require_once '../config.php';

// 1. Verificar acceso
if (!isset($_SESSION['user_id']) || $_SESSION['user_rol'] !== 'admin') {
    echo "<h1>No tienes permisos para acceder aquí</h1>";
    exit;
}

// 2. Aquí ya sabemos que es admin.
// Preparar datos para mostrarlos en el HTML
$result = $mysqli->query("SELECT * FROM PROJECTS");
$projects = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
</head>

<body>
    <header class="bg-gray-800 p-8 text-white flex justify-between items-center ">
        <h1 class="text-3xl font-bold text-center">Sitio de pruebas</h1>
        <nav class="flex items-center">
            <?php if (isset($_SESSION['user_id'])): ?>
                <img src="<?= htmlspecialchars($_SESSION['user_avatar']) ?>" alt="Avatar" class="w-10 h-10 rounded-full mr-4">
                <span class="text-sm font-semibold mr-4"><?= htmlspecialchars($_SESSION['name']) ?></span>
                <a href="logout.php" class="text-sm font-semibold hover:underline">Cerrar Sesión</a>
                <?php if ($_SESSION['user_rol'] === 'admin'): ?>
                    <a href="admin/adminPanel.php" class="text-sm font-semibold hover:underline ml-4">
                        <img class="w-[64px]" src="./assets/admin.png" alt="">
                    </a>
                <?php endif; ?>
            <?php else: ?>
                <a href="login.php" class="text-sm font-semibold hover:underline">Iniciar Sesión</a>
                <a href="register.php" class="text-sm font-semibold hover:underline ml-4">Registrarse</a>
            <?php endif; ?>
        </nav>
    </header>
    <h1>Panel de administración</h1>
    <ul>
        <li><a href="adminUsers.php">Gestión de usuarios</a></li>
        <li><a href="adminNews.php">Gestión de noticias</a></li>
        <li><a href="adminProjects.php">Gestión de proyectos</a></li>
    </ul>

    <h1>Proyectos</h1>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Id</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Thumbnail</th>
                <th>URL del proyecto</th>
                <!-- Ejemplo: Botones para Editar/Borrar -->
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $project): ?>
                <tr>
                    <td><?= $project['id'] ?></td>
                    <td><?= htmlspecialchars($project['title']) ?></td>
                    <td><?= htmlspecialchars($project['description']) ?></td>
                    <td><?= htmlspecialchars($project['thumbnail']) ?></td>
                    <td><?= htmlspecialchars($project['url']) ?></td>
                    <td>
                        <!-- Link/botón para Editar -->
                        <a href="editProject.php?id=<?= $project['id'] ?>">Editar</a>
                        <!-- Link/botón para Borrar -->
                        <a href="deleteProject.php?id=<?= $project['id'] ?>"
                            onclick="return confirm('¿Estás seguro de eliminar este proyecto?')">
                            Borrar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Botón o link para crear uno nuevo -->
    <p><a href="addProject.php">Añadir nuevo proyecto</a></p>
</body>

</html>