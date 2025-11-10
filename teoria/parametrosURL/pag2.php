<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>esta es la página 2</h1>
    <?php
    echo $_GET['edat'];
    echo '<br>';
    echo $_GET['nom'];
    


    //isset: lo usamos para comprobar que existe un parametro con ese nombre 
    
    if(isset($_GET['nom'])){

        $n = $_GET['nom'];

        echo $n;
    }
    else{
        echo 'no existe el parametro nombre';
    }
    ?>
</body>
</html>