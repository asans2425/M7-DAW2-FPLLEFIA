<?php 
session_start();
require_once "functions.php";

$editMode = false;
$id = null;
$nombre = $img = $poder = $desc = "";

// Si tenim ?id=..., estem editant
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (isset($_SESSION['personajes'][$id])) {
        $editMode = true;
        $p = $_SESSION['personajes'][$id];
        $nombre = $p['nombre'];
        $img = $p['imagen'];
        $poder = $p['poder'];
        $desc = $p['descripcion'];
    }
}

// Si enviem el formulari
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $nombre = $_POST['nombre'];
    $img = $_POST['imagen'];
    $poder = $_POST['poder'];
    $desc = $_POST['descripcion'];

    if ($editMode) {
        editarPersonaje($id, $nombre, $img, $poder, $desc);
    } else {
        agregarPersonaje($nombre, $img, $poder, $desc);
    }

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title><?= $editMode ? "Editar personatge" : "Afegir personatge" ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <a href="index.php" class="btn btn-outline-secondary mb-3">← Tornar</a>
    <h1 class="h4 mb-3"><?= $editMode ? " Editar el personatge" : " Afegeix un nou personatge" ?></h1>

    <form method="POST" class="card p-3 shadow-sm">
        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($nombre) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Imatge (URL)</label>
            <input type="url" name="imagen" class="form-control" value="<?= htmlspecialchars($img) ?>" placeholder="https://...">
        </div>

        <div class="mb-3">
            <label class="form-label">Poder</label>
            <input type="text" name="poder" class="form-control" value="<?= htmlspecialchars($poder) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripció</label>
            <textarea name="descripcion" class="form-control" rows="4"><?= htmlspecialchars($desc) ?></textarea>
        </div>

        <button class="btn btn-primary">
            <?= $editMode ? "💾 Guardar canvis" : "➕ Afegir personatge" ?>
        </button>
    </form>
</div>
</body>
</html>
