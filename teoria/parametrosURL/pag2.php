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
    if(isset($_GET['nom']) && isset($_GET['edat'])){
        $nom = $_GET['nom'];
        $edat = $_GET['edat'];

        echo "<p>Nom: $nom</p>";
        echo "<p>Edat: $edat</p>";
    }
    
    ?>
</body>
</html>