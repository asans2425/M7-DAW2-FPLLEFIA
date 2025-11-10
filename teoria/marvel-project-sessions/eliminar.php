<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}

$id = $_GET["id"] ?? null;

if ($id) {
    foreach ($_SESSION["personajes"] as $key => $p) {
        if ($p["id"] === $id) {
            unset($_SESSION["personajes"][$key]);
            $_SESSION["personajes"] = array_values($_SESSION["personajes"]); // reindexem
            break;
        }
    }
}

header("Location: personajes.php");
exit;
