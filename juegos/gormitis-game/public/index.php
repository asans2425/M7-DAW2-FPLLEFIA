<?php
include '../config/config.php';
include '../classes/Gormiti.php';

// Processar el formulari de creació
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_gormiti'])) {
    if (!empty($_POST['nom']) && !empty($_POST['salut']) && !empty($_POST['dany']) && !empty($_POST['imatge']) && !empty($_POST['habilitats'])) {
        $habilitats = explode(',', $_POST['habilitats']); // Separar habilitats per comes

        // Crear un nou Gormiti
        $nouGormiti = new Gormiti(
            $_POST['nom'],
            (int)$_POST['salut'],
            (int)$_POST['dany'],
            $_POST['imatge'],
            $habilitats
        );

        // Afegir el Gormiti a la sessió (serialitzat)
        $_SESSION['gormitis'][] = serialize($nouGormiti);

        // Redirigir per evitar duplicats en recarregar
        header("Location: index.php");
        exit();
    } else {
        $error = "Tots els camps són obligatoris.";
    }
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Gormitis</title>
</head>
<body>
    <h1>Crea el teu Gormiti</h1>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="nom">Nom:</label><br>
        <input type="text" name="nom" id="nom" required><br><br>

        <label for="salut">Salut:</label><br>
        <input type="number" name="salut" id="salut" required><br><br>

        <label for="dany">Dany:</label><br>
        <input type="number" name="dany" id="dany" required><br><br>

        <label for="imatge">URL de la imatge:</label><br>
        <input type="url" name="imatge" id="imatge" required><br><br>

        <label for="habilitats">Habilitats (separades per comes):</label><br>
        <input type="text" name="habilitats" id="habilitats" required><br><br>

        <button type="submit" name="crear_gormiti">Crear Gormiti</button>
    </form>

    <p><a href="characters.php">Veure Gormitis</a></p>
    <p><a href="reset.php">Reiniciar la sessió</a></p>
</body>
</html>
