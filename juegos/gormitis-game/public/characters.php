<?php
include '../config/config.php';
include '../classes/Gormiti.php';

// Recuperar els objectes Gormiti de la sessió
$gormitis = array_map(function($serializedGormiti) {
    return unserialize($serializedGormiti);
}, $_SESSION['gormitis']);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veure Gormitis</title>
    <style>
        .gormiti-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }
        .gormiti-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            width: 200px;
            text-align: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .gormiti-card img {
            max-width: 100%;
            border-radius: 10px;
        }
        .gormiti-card h3 {
            margin: 10px 0 5px;
        }
    </style>
</head>
<body>
    <h1>Gormitis Creats</h1>

    <form method="POST" action="precombat.php">
        <div class="gormiti-list">
            <?php if (!empty($gormitis)): ?>
                <?php foreach ($gormitis as $gormiti): ?>
                    <div class="gormiti-card">
                        <img src="<?= htmlspecialchars($gormiti->imatge) ?>" alt="<?= htmlspecialchars($gormiti->nom) ?>">
                        <h3><?= htmlspecialchars($gormiti->nom) ?></h3>
                        <p><strong>Salut:</strong> <?= htmlspecialchars($gormiti->salut) ?></p>
                        <p><strong>Dany:</strong> <?= htmlspecialchars($gormiti->dany) ?></p>
                        <p><strong>Habilitats:</strong> <?= htmlspecialchars($gormiti->obtenirHabilitats()) ?></p>
                        <input type="checkbox" name="selected_gormitis[]" value="<?= htmlspecialchars($gormiti->nom) ?>">
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No has creat cap Gormiti encara.</p>
            <?php endif; ?>
        </div>
        <button type="submit">Anar al precombat</button>
    </form>

    <p><a href="index.php">Crear un altre Gormiti</a></p>
</body>
</html>
