<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id']) && !in_array(basename($_SERVER['PHP_SELF']), ['login.php', 'register.php'])) {
    header('Location: login.php');
    exit;
}

// Get current page for navigation highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peregrang App - Control de Partidas de Pádel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        },
                        secondary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                },
            },
        }
    </script>
    <style type="text/css">
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <?php if (isset($_SESSION['user_id'])): ?>
        <?php include 'includes/header.php'; ?>
    <?php endif; ?>

    <div class="container mx-auto px-4 py-8">
        <?php
        // Simple router
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';
        $allowed_pages = ['home', 'leagues', 'matches', 'profile', 'rankings'];

        if (in_array($page, $allowed_pages)) {
            include "pages/{$page}.php";
        } else {
            include "pages/home.php";
        }
        ?>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>

</html>