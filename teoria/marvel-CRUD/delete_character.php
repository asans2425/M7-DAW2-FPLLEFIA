<?php
session_start();
require_once "functions.php";

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    eliminarPersonaje($id);
}

header("Location: index.php");
exit;
