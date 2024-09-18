<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo 7 - Práctica 1</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<style>

</style>
</head>
<body class="d-flex flex-column justify-content-between" style="height:100vh" >

    <!-- Header -->
    <header class="bg-dark p-5 d-flex justify-content-between align-items-center">
        <img src="img/logo40web-.png" alt="Logo FP Llefià" class="img-fluid">
        <h1 class="mt-3 text-white ">Módulo 7 - Práctica 1. Mi primera aplicación en PHP</h1>
    </header>

    <!-- Main content -->
    <main class="container mt-5 h-100 my-auto">
        <div class="row">
            <!-- Columna 1: Foto rodona i nom -->
            <div class="col-md-6 text-center">
                <img src="https://media.licdn.com/dms/image/v2/D4E03AQGSMymaNMAIeQ/profile-displayphoto-shrink_100_100/profile-displayphoto-shrink_100_100/0/1700211893380?e=1731542400&v=beta&t=UUaHGHqLC6B3Oz2VMUNJm-wRFSmoaX-fdhxQ_qXw0Ks" class="rounded-circle img-fluid" alt="Foto personal" width="200">
                <h2 class="mt-3">Albert Arrebola</h2>
            </div>

            <!-- Columna 2: Paràgraf explicatiu -->
            <div class="col-md-6">
                <p>
                    Aquesta pàgina **hola.php** forma part de la **pràctica 1** del mòdul 7. 
                    En el fitxer **index.php**, normalment s'hi defineixen les parts bàsiques d'una pàgina PHP, 
                    com ara el **header**, que conté informació inicial de la pàgina, així com el logo o títol, 
                    i el **body**, on es mostren els continguts principals. També es pot veure l'estructura de 
                    **columnes** que separen les diferents seccions del disseny.
                </p>
            </div>
        </div>
</main>
    <footer class="bg-dark text-white text-center">
<p>Albert Arrebola Sans</p>
<p>
<?= 'La fecha de hoy es: '. date('y-d-m') ?>

</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
