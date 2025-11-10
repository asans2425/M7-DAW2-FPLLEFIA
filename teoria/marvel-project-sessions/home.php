<?php
session_start();
include 'header.php';

// Comprovem que hi ha usuari loguejat
if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST["nom"]);
    $poder = trim($_POST["poder"]);

    if ($nom !== "" && $poder !== "") {
       array_push($_SESSION["personajes"], [
            "id" => uniqid(),
            "nom" => $nom,
            "poder" => $poder
        ]);
        $missatge = "Personatge creat correctament!";
    } else {
        $missatge = " Has d’omplir tots els camps.";
    }
}
?>

<h2>Crea el teu personatge Marvel</h2>

<form method="POST">
    Nom del personatge: <input type="text" name="nom"><br><br>
    Poder principal: <input type="text" name="poder"><br><br>
    <button type="submit">Afegir</button>
</form>

<p><?php echo $missatge ?? ""; ?></p>

<p><a href="personajes.php">Veure col·lecció</a></p>
