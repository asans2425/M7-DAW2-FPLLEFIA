<?php
session_start();

// Inicialización de la sesión
if (!isset($_SESSION['contador'], $_SESSION['basura'], $_SESSION['container'])) {
    $_SESSION['contador'] = 0;    
    $_SESSION['basura'] = ['Plastic', 'Glass', 'Plastic', 'Paper', 'Organic']; 
    $_SESSION['container'] = ['Paper' => 0, 'Glass' => 0, 'Organic' => 0, 'Plastic' => 0];
}

// Manejo de acciones
if (isset($_REQUEST['accion'])) {
    if ($_REQUEST['accion'] == $_SESSION['basura'][0]) {
        if ($_SESSION['container'][$_REQUEST['accion']] < 7) {
            $_SESSION['container'][$_REQUEST['accion']]++;  
            $_SESSION['contador']++;
            array_shift($_SESSION['basura']);
            $tiposBasura = ['Glass', 'Plastic', 'Paper', 'Organic'];
            array_push($_SESSION['basura'], $tiposBasura[array_rand($tiposBasura)]);
        } else {
            $_SESSION['mensaje'] = "El contenedor de {$_REQUEST['accion']} está lleno.";
        }
    }

    if ($_REQUEST['accion'] == 'vaciarCamion') {
        $_SESSION['container'] = ['Paper' => 0, 'Glass' => 0, 'Organic' => 0, 'Plastic' => 0];
        $_SESSION['contador']++;
    }
}
?>
