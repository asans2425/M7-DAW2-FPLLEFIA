

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="inicio.php" method="post">
        <input type="text" name="nom" placeholder="nombre">
        <input type="number" name="edat" placeholder="edad">
        <input type="submit" value="Enviar">
    </form>
</body>
</html>


<?php

//recoger los datos del formulario
echo $_GET['nom'];


echo '<br>';


echo $_GET['edat'];

//ahora con post
echo '<br>';
echo $_POST['nom'];
echo '<br>';
echo $_POST['edat'];

?>



