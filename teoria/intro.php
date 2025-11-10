<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>p1 php</title>
</head>
<body>
    <h1>hola pp1 teoria</h1>

    <?php
    echo '<h2>Hola subitulo</h2>';
    echo "hola mundo con dos comillas";

    $nom = 'Miguel Ángel';
    $apellido = "Saiz";
    
    $edad = 21;
    
    
    echo "Hola me llamo" . $nom . "tengo" . $edad . "años";
    echo "<br>";
    echo "hola me llamo {$nom} tengo {$edad} y me apellido  {$apellido}";
    //ho $frase;

    



//condicionales

//if

if($edad<22){
    echo "eres mayor de edad";
}else{
    echo "eres menor de edad";
}
//==
//%
//!=
//<= <= < >
?>

<section class="div-padre">
    <h1>Numeros 0-10</h1>
    <?php
//BUCLES
for ($i= 0; $i<=10;$i++){
// echo "<div class="num-box">Numero: $i <br></div>";
//opcion 1
echo "<div class=\"num-box\">Número: $i <br></div>";
//opcion 2
echo '<div class="num-box">Número: ' . $i . '<br></div>';
//opcion 3
echo "<div class='num-box'>Número: $i <br></div>";

}
?>
</section>

<style>
.num-box{
background-color: red;
padding: 2rem;

}
.div-padre{
    background-color: green;
    gap: 1em;
    display: flex;
    flex-wrap: wrap;
}
</style>


</body>
</html>