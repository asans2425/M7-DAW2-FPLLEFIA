<?php
session_start();
include 'header.php';

if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}

$id = $_GET["id"] ?? null;
if (!$id) {
    header("Location: personajes.php");
    exit;
}

foreach ($_SESSION["personajes"] as &$p) {
    if ($p["id"] === $id) {
        $personatge = &$p;
        break;
    }
}

if (!isset($personatge)) {
    echo "❌ Personatge no trobat.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nouNom = trim($_POST["nom"]);
    $nouPoder = trim($_POST["poder"]);

    if ($nouNom !== "" && $nouPoder !== "") {
        $personatge["nom"] = $nouNom;
        $personatge["poder"] = $nouPoder;
        header("Location: personajes.php");
        exit;
    } else {
        $missatge = "❌ Omple tots els camps.";
    }
}
?>

<h2>Editar personatge</h2>
<form method="POST">
    Nom: <input type="text" name="nom" value="<?php echo htmlspecialchars($personatge["nom"]); ?>"><br><br>
    Poder: <input type="text" name="poder" value="<?php echo htmlspecialchars($personatge["poder"]); ?>"><br><br>
    <button type="submit">Guardar canvis</button>
</form>
<p><?php echo $missatge ?? ""; ?></p>
