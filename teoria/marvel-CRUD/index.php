<?php
session_start();
require_once "functions.php";
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marvel CRUD 24-10</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">
<div class="container py-4">
    <a class="btn btn-success" href="destroy.php">Destruir sessió</a>
    <h1 class="mb-4">🦸 Marvel Personatges</h1>

    <a href="add_edit_character.php" class="btn btn-warning mb-4">
        ➕ Clica per afegir un nou personatge
    </a>

    <div class="row g-3">
        <?php foreach ($_SESSION['personajes'] as $id => $p): ?>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="<?= htmlspecialchars($p['imagen']) ?>" 
                         class="card-img-top" 
                         alt="<?= htmlspecialchars($p['nombre']) ?>">

                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($p['nombre']) ?></h5>
                        <p class="text-muted"><?= htmlspecialchars($p['poder']) ?></p>
                        <p><?= htmlspecialchars($p['descripcion']) ?></p>
                    </div>

                    <div class="card-footer d-flex gap-2">
                        <a href="add_edit_character.php?id=<?= $id ?>" 
                           class="btn btn-warning btn-sm">✏️ Editar</a>

                        <a href="delete_character.php?id=<?= $id ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Vols eliminar <?= htmlspecialchars($p['nombre']) ?>?')">
                           🗑️ Eliminar
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
