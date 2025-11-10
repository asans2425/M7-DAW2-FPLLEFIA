

<?php

$dies=['Dilluns', 'Dimarts', 'Dimecres', 'Dijous', 'Divendres'];

echo $dies[0]; // Dilluns
echo $dies[2]; // Dimecres
echo $dies[4]; // Divendres


// afegir un element al final
$dies[]='Dissabte';
array_push($dies, 'Diumenge');
// eliminar l'últim element
array_pop($dies);
 


//recorrer con foreach
foreach($dies as $juanpedro){
    echo "<h1>$juanpedro</h1>";
}
?>