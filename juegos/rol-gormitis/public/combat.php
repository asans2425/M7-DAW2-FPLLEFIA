<?php
// Inclou les classes necessàries
include_once '../src/config/config.php';
include_once '../src/classes/Gormiti.php';
include_once '../src/classes/ObjecteEspecial.php';
include_once '../src/classes/Jugador.php';
include_once '../src/classes/Joc.php';

// Recuperar els noms dels personatges seleccionats des de la sessió
$selectedGormitis = $_SESSION['selected_gormitis'] ?? [];

// Recuperar els objectes Gormiti desats a la sessió
$gormitis = array_map(function ($gormitiSerialized) {
    return unserialize($gormitiSerialized);
}, $_SESSION['gormitis']);

// Filtrar només els seleccionats
$gormitisSeleccionats = array_filter($gormitis, function ($gormiti) use ($selectedGormitis) {
    return in_array($gormiti->nom, $selectedGormitis);
});

// Recuperar els objectes especials seleccionats a la sessió
$objectesSeleccionats = $_SESSION['objectesSeleccionats'] ?? [];

// Crear una llista de jugadors i assignar els objectes especials
$jugadors = [];
foreach ($gormitisSeleccionats as $gormiti) {
    $jugador = new Jugador(uniqid(), "Jugador " . $gormiti->nom, $gormiti);
    // Assignar objecte especial seleccionat
    if (isset($objectesSeleccionats[$gormiti->nom])) {
        $objecteNom = $objectesSeleccionats[$gormiti->nom];
        foreach ($objectesEspecials as $objecte) {
            if ($objecte->nom == $objecteNom) {
                $jugador->assignarObjecteEspecial($objecte);
                break;
            }
        }
    }
    $jugadors[] = $jugador;
}

// Crear la instància del joc i iniciar el combat
$joc = new Joc($jugadors);
$joc->iniciarCombat();

// Mostrar informació de l'estat del combat
foreach ($jugadors as $jugador) {
    echo $jugador->descripcion() . "<br>";
}
