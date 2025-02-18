<?php
// Inicialitza la sessió
session_start();

// Comprova si l'array de Gormitis ja existeix a la sessió
if (!isset($_SESSION['gormitis'])) {
    $_SESSION['gormitis'] = []; // Crea un array buit si no existeix
}
