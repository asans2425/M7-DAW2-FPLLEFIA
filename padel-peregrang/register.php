<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate input
    if (empty($name) || empty($username) || empty($password) || empty($confirm_password)) {
        $error = 'Por favor, completa todos los campos.';
    } elseif ($password !== $confirm_password) {
        $error = 'Las contraseñas no coinciden.';
    } elseif (strlen($password) < 6) {
        $error = 'La contraseña debe tener al menos 6 caracteres.';
    } elseif (userExists($username)) {
        $error = 'Este nombre de usuario ya está en uso.';
    } else {
        // Process avatar upload if exists
        $avatar = '';
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/avatars/';

            // Create directory if it doesn't exist
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_name = time() . '_' . basename($_FILES['avatar']['name']);
            $target_file = $upload_dir . $file_name;

            $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($file_type, $allowed_types)) {
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file)) {
                    $avatar = $file_name;
                }
            }
        }

        // Hash password
        $hashed_password = hashPassword($password);

        // Insert user
        $query = "INSERT INTO users (name, username, password, avatar, created_at) 
                  VALUES ('$name', '$username', '$hashed_password', '$avatar', NOW())";

        if ($conn->query($query)) {
            $success = 'Registro exitoso. Ahora puedes iniciar sesión.';
        } else {
            $error = 'Error al registrar el usuario: ' . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Peregrang App</title>
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

<body class="bg-gray-50 min-h-screen flex items-center justify-center py-12">
    <div class="max-w-md w-full mx-4">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Peregrang App</h1>
            <p class="text-gray-600 mt-2">Crea una cuenta para empezar</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-8">
            <?php if (!empty($error)): ?>
                <div class="bg-red-50 text-red-600 p-4 rounded-md mb-6">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="bg-green-50 text-green-600 p-4 rounded-md mb-6">
                    <?php echo $success; ?>
                    <p class="mt-2">
                        <a href="login.php" class="text-primary-600 hover:text-primary-700 font-medium">Ir a iniciar sesión</a>
                    </p>
                </div>
            <?php else: ?>
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre completo</label>
                        <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    </div>

                    <div class="mb-6">
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Nombre de usuario</label>
                        <input type="text" id="username" name="username" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña</label>
                        <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    </div>

                    <div class="mb-6">
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">Confirmar contraseña</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    </div>

                    <div class="mb-6">
                        <label for="avatar" class="block text-sm font-medium text-gray-700 mb-2">Avatar (opcional)</label>
                        <input type="file" id="avatar" name="avatar" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>

                    <button type="submit" class="w-full bg-primary-600 text-white py-2 px-4 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                        Registrarse
                    </button>
                </form>
            <?php endif; ?>

            <div class="mt-6 text-center">
                <p class="text-gray-600">¿Ya tienes una cuenta? <a href="login.php" class="text-primary-600 hover:text-primary-700">Inicia sesión</a></p>
            </div>
        </div>
    </div>
</body>

</html>