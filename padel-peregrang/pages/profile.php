<?php
$user = getUserData($_SESSION['user_id']);
$stats = getPlayerStats($_SESSION['user_id']);

// Get user's leagues
$leagues = getUserLeagues($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error = '';
    $success = '';

    // Update profile
    if (isset($_POST['update_profile'])) {
        $name = sanitize($_POST['name']);

        $query = "UPDATE users SET name = '$name' WHERE id = {$_SESSION['user_id']}";

        if ($conn->query($query)) {
            // Handle avatar upload if exists
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = 'uploads/avatars/';

                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $file_name = time() . '_' . basename($_FILES['avatar']['name']);
                $target_file = $upload_dir . $file_name;

                $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

                if (in_array($file_type, $allowed_types)) {
                    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file)) {
                        // Delete old avatar if exists
                        if (!empty($user['avatar'])) {
                            @unlink($upload_dir . $user['avatar']);
                        }

                        $query = "UPDATE users SET avatar = '$file_name' WHERE id = {$_SESSION['user_id']}";
                        $conn->query($query);
                    }
                }
            }

            $success = 'Perfil actualizado correctamente.';
            $user = getUserData($_SESSION['user_id']); // Refresh user data
        } else {
            $error = 'Error al actualizar el perfil.';
        }
    }

    // Change password
    if (isset($_POST['change_password'])) {
        $current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
        $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
        $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            $error = 'Todos los campos de contraseña son requeridos.';
        } elseif ($new_password !== $confirm_password) {
            $error = 'Las nuevas contraseñas no coinciden.';
        } elseif (strlen($new_password) < 6) {
            $error = 'La nueva contraseña debe tener al menos 6 caracteres.';
        } else {
            $query = "SELECT password FROM users WHERE id = {$_SESSION['user_id']}";
            $result = $conn->query($query);
            $current = $result->fetch_assoc();

            if (verifyPassword($current_password, $current['password'])) {
                $hashed_password = hashPassword($new_password);
                $query = "UPDATE users SET password = '$hashed_password' WHERE id = {$_SESSION['user_id']}";

                if ($conn->query($query)) {
                    $success = 'Contraseña actualizada correctamente.';
                } else {
                    $error = 'Error al actualizar la contraseña.';
                }
            } else {
                $error = 'La contraseña actual es incorrecta.';
            }
        }
    }
}
?>

<div class="max-w-4xl mx-auto">
    <?php if (!empty($error)): ?>
        <div class="bg-red-50 text-red-600 p-4 rounded-md mb-6">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="bg-green-50 text-green-600 p-4 rounded-md mb-6">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 space-y-6">
            <!-- Profile Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Información del Perfil</h2>

                <form method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" name="update_profile" value="1">

                    <div class="mb-6">
                        <div class="flex items-center">
                            <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-200 mr-4">
                                <?php if (!empty($user['avatar'])): ?>
                                    <img src="uploads/avatars/<?php echo $user['avatar']; ?>" alt="Avatar" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-gray-400 p-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                <?php endif; ?>
                            </div>
                            <div>
                                <label for="avatar" class="block text-sm font-medium text-gray-700 mb-2">Cambiar Avatar</label>
                                <input type="file" id="avatar" name="avatar" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                        <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de usuario</label>
                        <input type="text" value="<?php echo $user['username']; ?>" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-md text-gray-500" disabled>
                    </div>

                    <button type="submit" class="w-full bg-primary-600 text-white py-2 px-4 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                        Actualizar Perfil
                    </button>
                </form>
            </div>

            <!-- Change Password -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Cambiar Contraseña</h2>

                <form method="POST" action="">
                    <input type="hidden" name="change_password" value="1">

                    <div class="mb-6">
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña Actual</label>
                        <input type="password" id="current_password" name="current_password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    </div>

                    <div class="mb-6">
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">Nueva Contraseña</label>
                        <input type="password" id="new_password" name="new_password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    </div>

                    <div class="mb-6">
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">Confirmar Nueva Contraseña</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    </div>

                    <button type="submit" class="w-full bg-primary-600 text-white py-2 px-4 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                        Cambiar Contraseña
                    </button>
                </form>
            </div>
        </div>

        <div>
            <!-- Statistics -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Mis Estadísticas</h2>

                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-primary-600"><?php echo $stats['total_matches']; ?></div>
                        <div class="text-sm text-gray-600">Partidos</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600"><?php echo $stats['wins']; ?></div>
                        <div class="text-sm text-gray-600">Victorias</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-red-600"><?php echo $stats['losses']; ?></div>
                        <div class="text-sm text-gray-600">Derrotas</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <?php $winrate = $stats['total_matches'] > 0 ? round(($stats['wins'] / $stats['total_matches']) * 100) : 0; ?>
                        <div class="text-2xl font-bold text-blue-600"><?php echo $winrate; ?>%</div>
                        <div class="text-sm text-gray-600">% Victoria</div>
                    </div>
                </div>
            </div>

            <!-- Leagues -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Mis Ligas</h2>

                <?php if (count($leagues) > 0): ?>
                    <ul class="space-y-3">
                        <?php foreach ($leagues as $league): ?>
                            <li>
                                <a href="index.php?page=leagues&id=<?php echo $league['id']; ?>" class="flex items-center p-2 hover:bg-gray-50 rounded-md">
                                    <div class="w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                                            <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
                                            <line x1="6" y1="1" x2="6" y2="4"></line>
                                            <line x1="10" y1="1" x2="10" y2="4"></line>
                                            <line x1="14" y1="1" x2="14" y2="4"></line>
                                        </svg>
                                    </div>
                                    <span class="text-gray-700"><?php echo $league['name']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div class="text-center py-4">
                        <p class="text-gray-500">No estás en ninguna liga</p>
                        <a href="index.php?page=leagues" class="mt-2 inline-block text-sm text-primary-600 hover:text-primary-700">Unirse a una liga</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>