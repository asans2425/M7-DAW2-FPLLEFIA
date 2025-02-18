<?php
// Inclou les classes necessàries
include_once '../src/config/config.php';
include_once '../src/classes/Gormiti.php';
include_once '../src/classes/ObjecteEspecial.php';
include_once '../src/classes/Jugador.php';
include_once '../src/classes/Joc.php';

// Recuperar els noms dels personatges seleccionats des de la sessió
$selectedGormitis = $_SESSION['selected_gormitis'] ?? [];

// Recuperar els objectes Gormiti desats a la sessió
$gormitis = array_map(function ($gormitiSerialized) {
    return unserialize($gormitiSerialized);
}, $_SESSION['gormitis']);

// Filtrar només els seleccionats
$gormitisSeleccionats = array_filter($gormitis, function ($gormiti) use ($selectedGormitis) {
    return in_array($gormiti->nom, $selectedGormitis);
});

// Definir els objectes especials disponibles
$objectesEspecials = [
    new ObjecteEspecial('Espasa de Foc', 'Augmenta atac', 'Augmenta el dany d\'atac del Gormiti', 5, 'https://www.pngitem.com/pimgs/m/8-89549_fortis-rex-horse-combat-and-new-weapons-news.png'),
    new ObjecteEspecial('Escut d’Aigua', 'Redueix dany', 'Redueix el dany rebut pel Gormiti', 8, 'https://www.freeiconspng.com/uploads/vintage-gun-png-11.png'),
    new ObjecteEspecial('Capa d’Ombra', 'Redueix dany', 'Redueix el dany rebut pel Gormiti', 10, 'https://www.pngitem.com/pimgs/m/8-89549_fortis-rex-horse-combat-and-new-weapons-news.png'),
];

// Comprovem que hi hagi almenys dos personatges seleccionats
if (count($gormitisSeleccionats) < 2) {
    die('Cal seleccionar almenys dos personatges per començar el combat.');
}

// Quan s'envia el formulari, desar les dades a la sessió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Guardar les seleccions d'objectes especials a la sessió
    $objectesSeleccionats = $_POST['objectes'] ?? [];
    $_SESSION['objectesSeleccionats'] = $objectesSeleccionats;

    // Redirigir a combat.php
    header('Location: combat.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Precombat: Assigna un objecte especial</title>
    <style>
        .objecte-card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .objecte-card img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }

        .objecte-card div {
            display: flex;
            flex-direction: column;
        }

        .objecte-list {
            margin-top: 20px;
        }

        .flex-container {
            display: flex;
            justify-content: space-between;
        }

        .flex-container div {
            width: 45%;
        }

        .gormiti-info {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
        }

        .objecte-info {
            margin-top: 20px;
        }

        .objecte-info p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <h1>Precombat: Assigna un objecte especial</h1>

    <!-- Mostrar objectes especials -->
    <div class="objecte-info">
        <h2>Objectes Especials Disponibles</h2>
        <div class="objecte-list">
            <?php foreach ($objectesEspecials as $objecte): ?>
                <div class="objecte-card">
                    <img src="<?= htmlspecialchars($objecte->imatge) ?>" alt="<?= htmlspecialchars($objecte->nom) ?>">
                    <div>
                        <h4><?= htmlspecialchars($objecte->nom) ?></h4>
                        <p><strong>Efecte:</strong> <?= htmlspecialchars($objecte->tipus) ?></p>
                        <p><strong>Descripció:</strong> <?= htmlspecialchars($objecte->descripcio) ?></p>
                        <p><strong>Valor:</strong> <?= htmlspecialchars($objecte->valor) ?>%</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Formulari per assignar objectes als Gormitis -->
    <form method="POST" action="precombat.php">
        <div class="flex-container">
            <?php foreach ($gormitisSeleccionats as $gormiti): ?>
                <div class="gormiti-info">
                    <img src="<?= $gormiti->imatge ?>" alt="img-gormiti">
                    <h3><?= htmlspecialchars($gormiti->nom) ?></h3>
                    <p><strong>Salut:</strong> <?= htmlspecialchars($gormiti->salut) ?></p>
                    <p><strong>Dany:</strong> <?= htmlspecialchars($gormiti->dany) ?></p>
                    <p><strong>Habilitats:</strong> <?= htmlspecialchars($gormiti->obtenirHabilitats()) ?></p>

                    <label for="objecte-<?= htmlspecialchars($gormiti->nom) ?>">Selecciona un objecte:</label>
                    <select name="objectes[<?= htmlspecialchars($gormiti->nom) ?>]" id="objecte-<?= htmlspecialchars($gormiti->nom) ?>" required>
                        <option value="">-- Tria un objecte --</option>
                        <?php foreach ($objectesEspecials as $objecte): ?>
                            <option value="<?= $objecte->nom ?>"><?= $objecte->nom ?> - <?= $objecte->valor ?>%</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endforeach; ?>
        </div>

        <button type="submit">Continuar al Combat</button>
    </form>
</body>

</html>