<?php
require 'actions.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Basura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'components/navbar.php'; ?>

    <div class="container mt-4">
        <h1 class="text-center">Gestión del reciclaje</h1>

        <!-- Mensaje de contenedores llenos -->
        <?php if (!empty($_SESSION['mensaje'])): ?>
            <div class="alert alert-warning">
                <?= $_SESSION['mensaje']; ?>
            </div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>

        <!-- Contador de basura procesada -->
       
        <button type="button" class="btn p-3 btn-secondary text-white">
        Basura procesada: <span class="badge bg-danger"><?= $_SESSION['contador']; ?></span>
</button>
        <hr>

      <!-- Visualización de la cola de basura -->
<div class="mt-4">
    <h3>¿Qué toca reciclar ahora?</h3>
    <div class="d-flex align-items-center justify-content-center mb-4">
        <!-- Basura actual -->
        <div class="text-center p-3 mx-2 border border-success rounded" style="background-color: #d4edda;">
            <h4 class="text-success">Ahora: <?= $_SESSION['basura'][0]; ?></h4>
            <img src="images/<?= strtolower($_SESSION['basura'][0]); ?>.jpg" alt="<?= $_SESSION['basura'][0]; ?>" class="img-fluid" style="width: 80px;">
        </div>
        <!-- Cola de basura -->
        <div class="d-flex gap-2">
            <?php for ($i = 1; $i < count($_SESSION['basura']); $i++): ?>
                <div class="text-center p-3 mx-2 border rounded" style="background-color: #f8f9fa;">
                    <h6><?= $_SESSION['basura'][$i]; ?></h6>
                    <img src="images/<?= strtolower($_SESSION['basura'][$i]); ?>.jpg" alt="<?= $_SESSION['basura'][$i]; ?>" class="img-fluid" style="width: 50px;">
                </div>
            <?php endfor; ?>
        </div>
    </div>
</div>


        <!-- Botones de contenedores -->
        <div class="d-flex justify-content-center flex-wrap gap-3">
            <a href="index.php?accion=Glass" class="btn btn-success">
                 Glass
            </a>
            <a href="index.php?accion=Organic" class="btn btn-secondary">
               Organic
            </a>
            <a href="index.php?accion=Paper" class="btn btn-primary">
                Paper
            </a>
            <a href="index.php?accion=Plastic" class="btn btn-warning">
               Plastic
            </a>
            <a href="index.php?accion=vaciarCamion" class="btn btn-danger">
                <img src="images/camion.png" alt="Vaciar Camión" class="img-fluid" style="width: 50px;"> Vaciar Camión
            </a>
        </div>

        <!-- Estado de los contenedores -->
        <h2 class="mt-5">Estado de los Contenedores</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['container'] as $key => $value): ?>
                    <tr>
                        <td><?= $key; ?></td>
                        <td><?= $value; ?> / 7</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php include 'components/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
