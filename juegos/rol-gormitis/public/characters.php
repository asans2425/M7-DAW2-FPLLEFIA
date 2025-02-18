<?php
// Inclou la configuració per inicialitzar la sessió i la classe Gormiti
include '../src/config/config.php';
include '../src/classes/Gormiti.php';

// Recuperar els objectes Gormiti desats a la sessió
$gormitis = []; // Inicialitzem un array buit
if (!empty($_SESSION['gormitis'])) {
    // Fem un array_map per deserialitzar cada objecte serialitzat
    $gormitis = array_map(function ($gormitiSerialized) {
        return unserialize($gormitiSerialized); // Convertim cada cadena a un objecte Gormiti
    }, $_SESSION['gormitis']);
}

// Quan es seleccionen els personatges i s'envia el formulari
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Guardem els personatges seleccionats a la sessió
    $_SESSION['selected_gormitis'] = $_POST['selected_gormitis'] ?? [];
    header('Location: precombat.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veure Gormitis</title>
    <style>
        /* Estils senzills per donar format a les targetes */
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

    <!-- Formulari per seleccionar personatges -->
    <form method="POST" action="characters.php">
        <div class="gormiti-list">
            <!-- Comprovem si hi ha Gormitis a mostrar -->
            <?php if (!empty($gormitis)): ?>
                <?php foreach ($gormitis as $gormiti): ?>
                    <?php if ($gormiti instanceof Gormiti): ?>
                        <!-- Targeta de cada Gormiti -->
                        <div class="gormiti-card">
                            <img src="<?= htmlspecialchars($gormiti->imatge) ?>" alt="<?= htmlspecialchars($gormiti->nom) ?>">
                            <h3><?= htmlspecialchars($gormiti->nom) ?></h3>
                            <p><strong>Salut:</strong> <?= htmlspecialchars($gormiti->salut) ?></p>
                            <p><strong>Dany:</strong> <?= htmlspecialchars($gormiti->dany) ?></p>
                            <p><strong>Habilitats:</strong> <?= htmlspecialchars($gormiti->obtenirHabilitats()) ?></p>
                            <!-- Checkbox per seleccionar el Gormiti -->
                            <input type="checkbox" name="selected_gormitis[]" value="<?= $gormiti->nom ?>">
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Missatge si no hi ha cap Gormiti -->
                <p>No has creat cap Gormiti encara.</p>
            <?php endif; ?>
        </div>
        <!-- Botó per enviar els personatges seleccionats -->
        <button type="submit">Anar al precombat</button>
    </form>

    <!-- Enllaços per tornar o reiniciar la sessió -->
    <p><a href="index.php">Crear un altre Gormiti</a></p>
    <p><a href="reset.php">Reiniciar la sessió</a></p>
</body>

</html>
