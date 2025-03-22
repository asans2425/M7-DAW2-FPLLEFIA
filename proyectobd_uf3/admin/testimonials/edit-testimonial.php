<?php
require_once '../../config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

// Corregir la asignación del ID
$id = (int) $_GET['id'];
$result = $mysqli->query("SELECT * FROM TESTIMONIALS WHERE id = $id");

$testimonial = $result->fetch_assoc();



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $mysqli->$_POST['name'];
    $surname = $mysqli->$_POST['surname'];
    $description = $mysqli->$_POST['description'];
    $rating = $mysqli->$_POST['rating'];
}
$query = "UPDATE TESTIMONIALS SET name = ?, surname = ?, description = ?, rating = ? WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ssssi", $name, $surname, $description, $rating, $id);
$stmt->execute();

header("Location: ../adminPanel.php");
exit();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit testimonial</title>
</head>

<body>

    <form action="" method="post">

        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?= $testimonial['name'] ?>" required><br><br>

        <label for="surname">Surname:</label><br>
        <input type="text" id="surname" name="surname" value="<?= $testimonial['surname'] ?>" required><br><br>

        <label for="description">Description:</label><br>
        <input type="text" id="description" name="description" value="<?= $testimonial['description'] ?>" required><br><br>

        <label for="rating">Rating:</label><br>
        <input type="number" id="rating" name="rating" value="<?= $testimonial['rating'] ?>" required><br><br>

        <input type="submit" value="Submit">
    </form>

</body>

</html>