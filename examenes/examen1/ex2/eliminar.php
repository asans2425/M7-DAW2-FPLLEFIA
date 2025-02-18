<?php

//include 'array.php';
include 'funciones.php';

if (isset($_GET['id'])) {
    eliminar_producto($_GET['id']);
    header('Location: home.php');
}
