<?php
// Incloem la configuració i la classe Gormiti
include '../src/config/config.php';
include '../src/classes/Gormiti.php';

// Processar el formulari de creació
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_gormiti'])) {
    // Comprovar que tots els camps estan plens
    if (!empty($_POST['nom']) && !empty($_POST['salut']) && !empty($_POST['dany']) && !empty($_POST['imatge']) && !empty($_POST['habilitats'])) {
        // Crear el nou objecte Gormiti
        $nouGormiti = new Gormiti(
            uniqid(),                                // ID únic
            $_POST['nom'],                          // Nom
            (int)$_POST['salut'],                   // Salut
            (int)$_POST['dany'],                    // Dany
            $_POST['imatge'],                       // Imatge
            explode(',', $_POST['habilitats'])      // Habilitats separades per comes
        );

        // Desa el Gormiti a la sessió (serialitzat)
        $_SESSION['gormitis'][] = serialize($nouGormiti);

        // Redirigeix per evitar duplicats en recarregar
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

    <!-- Mostrar errors si hi ha -->
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <!-- Formulari per crear Gormitis -->
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

    <!-- Enllaços a altres pàgines -->
    <p><a href="characters.php">Veure Gormitis</a></p>
    <p><a href="reset.php">Reiniciar la sessió</a></p>
</body>

</html>