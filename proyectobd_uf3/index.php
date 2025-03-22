<?php
session_start();
require_once 'config.php';

// Consulta para obtener las noticias ordenadas por fecha (descendente)
$resultNews = $mysqli->query("SELECT * FROM NEWS ORDER BY new_data DESC");
$news = $resultNews->fetch_all(MYSQLI_ASSOC);

// Consulta para obtener los proyectos
$resultProjects = $mysqli->query("SELECT * FROM PROJECTS ORDER BY id DESC");
$projects = $resultProjects->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tarjetas de Datos - Noticias y Proyectos</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <header class="bg-gray-800 p-8 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-white">Agen Bootstrap</h1>
        <nav class="flex items-center">
            <?php if (isset($_SESSION['user_id'])): ?>
                <p class="text-white" style="font-size: 18px; font-weight:bold; padding:10px">Bienvenido <?= $_SESSION['user_name'] ?> !</p>
                <img class="w-[25%]" src="<?= $_SESSION['user_avatar'] ?>" alt="">
                <a href="logout.php" class="text-white ml-4">Cerrar Sesión</a>
                <?php if ($_SESSION['user_rol'] === 'admin'): ?>
                    <a href="admin/adminPanel.php" class="text-white ml-4"><img src="./assets/admin.png" alt=""></a>
                <?php endif; ?>
            <?php endif; ?>
        </nav>
    </header>


    <div class="container mx-auto p-4">
        <!-- Sección de Noticias -->
        <h1 class="text-3xl font-bold mb-6 text-center">Noticias Recientes</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <?php foreach ($news as $item): ?>
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <img src="<?= htmlspecialchars($item['thumbnail']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-bold mb-2"><?= htmlspecialchars($item['title']) ?></h2>
                        <p class="text-gray-600 mb-2"><?= htmlspecialchars($item['subtitle']) ?></p>
                        <p class="text-gray-700 text-sm"><?= htmlspecialchars($item['description']) ?></p>
                        <p class="text-xs text-gray-500 mt-2"><?= htmlspecialchars($item['new_data']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>



        <!-- Sección de Proyectos -->
        <h1 class="text-3xl font-bold mb-6 text-center">Proyectos Recientes</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($projects as $project): ?>
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <img src="<?= htmlspecialchars($project['thumbnail']) ?>" alt="<?= htmlspecialchars($project['title']) ?>" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-bold mb-2"><?= htmlspecialchars($project['title']) ?></h2>
                        <p class="text-gray-700 text-sm mb-2"><?= htmlspecialchars($project['description']) ?></p>
                        <a href="<?= htmlspecialchars($project['url']) ?>" target="_blank" class="text-blue-500 hover:text-blue-700 text-sm font-semibold">
                            Visitar Proyecto
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>