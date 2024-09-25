<!-- <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Selecció de Color</title>
</head>
<body style="background-color: 
    <?php 
    echo isset($_GET['color']) ? $_GET['color'] : 'white'; 
    ?>;">

    <h1>Selecciona un color per al fons</h1>
    <a href="?color=red">Vermell</a> |
    <a href="?color=blue">Blau</a> |
    <a href="?color=green">Verd</a> |
    <a href="?color=yellow">Groc</a>
</body>
</html> -->

<?php
$animales = ["Perro", "Gato", "Conejo"];
unset($animales[1]); // Elimina "Gato"
print_r($animales); // Muestra ["Perro", "Conejo"]
print_r( $animales[1]);
var_dump($animales);
?>
