<?php
include_once 'data.php';

//compruebo si el formulario ha sido enviado
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //RECOJO LOS DATOS DEL FORMULARIO
    $title = $_POST['title'];
    $content = $_POST['content'];
    $date = $_POST['date'];
    $image = $_POST['image'];
    $category = $_POST['category'];

    //validamos con trim i con empty i con isset
    if(isset($title) && !empty(trim($title)) &&
       isset($content) && !empty(trim($content)) &&
         isset($date) && !empty(trim($date)) &&
           isset($image) && !empty(trim($image)) &&
             isset($category) && !empty(trim($category))
    ){
        //afegim dades al array
        array_push($noticies, [
            'title' => $title,
            'content' => $content,
            'date' => $date,
            'image' => $image,
            'category' => $category
        ]);

        echo "Noticia afegida correctament";
        echo '<p style="color:green"> Noticia afegida correctament</p>';
    } else {
        echo '<p style="color:red"> Error: Tots els camps son obligatoris</p>';
    }
}else{
    echo '<p style="color:red"> Error: El formulari no ha sigut enviat correctament</p>';
}

//ARA AFEGIREM EL FORMULARI HTML PER A AFEGIR NOTICIES
?>
<form method="POST" action="">
    <label for="title">Títol:</label>
    <input type="text" id="title" name="title" required>

    <label for="content">Contingut:</label>
    <textarea id="content" name="content" required></textarea>

    <label for="date">Data:</label>
    <input type="date" id="date" name="date" required>

    <label for="image">Imatge:</label>
    <input type="text" id="image" name="image" required>

    <label for="category">Categoria:</label>
    <input type="text" id="category" name="category" required>

    <input type="submit" value="Afegir Noticia">
</form>

<?php
//mostrem el array per veure que s'ha afegit la nova noticia
echo '<h2>Notícies Actualitzades:</h2>';
echo '<pre>';
print_r($noticies);
echo '</pre>';
?>