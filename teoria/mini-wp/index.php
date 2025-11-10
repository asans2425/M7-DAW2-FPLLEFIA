<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mini-wp</title>
    <link rel="stylesheet" href="../styles/index.css">
</head>
<body>
    <?php
include_once 'inc/header.php';
?>

<main>
    <!-- AQUI IRÁ EL GRID DE NOTICIAS -->
     <section class="news-grid-display">
        <?php
        include_once 'data.php';

        foreach($noticies as $noticia){
            echo '<article class="news-item">';
            echo '<h2>' . htmlspecialchars($noticia['title']) . '</h2>';
            echo '<img src="' . htmlspecialchars($noticia['image']) . '" alt="' . htmlspecialchars($noticia['title']) . '">';
            echo '<p>' . htmlspecialchars($noticia['content']) . '</p>';
            echo '<p><strong>Data:</strong> ' . htmlspecialchars($noticia['date']) . '</p>';
            echo '<p><strong>Categoria:</strong> ' . htmlspecialchars($noticia['category']) . '</p>';
            echo '</article>';
        }
        ?>
     </section>
     <?= var_dump($noticies) ?>
</main>


<?php
include_once 'inc/footer.php';
?>

</body>
</html>
