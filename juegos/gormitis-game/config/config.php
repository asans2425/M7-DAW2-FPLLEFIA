<?php
session_start();
// Inicialitzem l'array de Gormitis si no existeix
if (!isset($_SESSION['gormitis'])) {
    $_SESSION['gormitis'] = []; // Aquí s'emmagatzemaran els personatges creats
}
?>
