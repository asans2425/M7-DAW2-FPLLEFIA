<?php
session_start();

// Usuaris permesos (pots afegir-ne més)
$usuaris = [
    "admin" => "1234",
    "maria" => "abcd",
    "tony"  => "ironman"
];

// Inicialitzem l’array de personatges si no existeix
if (!isset($_SESSION["personajes"])) {
    $_SESSION["personajes"] = [];
}
