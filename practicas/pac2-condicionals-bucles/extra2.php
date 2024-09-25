<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classificació de Temperatures</title>
    <!-- Incloem Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <h1 class="text-center mb-4">Classificació de Temperatures</h1>

    <div class="row justify-content-center">
        <?php
        // Inicialitzem la variable per calcular la suma de totes les temperatures
        $suma_temperatures = 0;

        // Nombre de temperatures a generar
        $num_temperatures = 10;

        // Bucle per generar i mostrar les temperatures
        for ($i = 0; $i < $num_temperatures; $i++) {
            // Generem una temperatura aleatòria entre -10 i 40 graus
            $temperatura = rand(-10, 40);
            
            // Afegim la temperatura a la suma per calcular la mitjana després
            $suma_temperatures += $temperatura;

            // Classifiquem la temperatura i canviem el color de fons segons la categoria
            if ($temperatura < 10) {
                $classe = "Fred";
                $color = "bg-primary text-white";
            } elseif ($temperatura <= 25) {
                $classe = "Temperatura Suau";
                $color = "bg-warning";
            } else {
                $classe = "Calor";
                $color = "bg-danger text-white";
            }

            // Mostrem la temperatura en un bloc amb el color de fons corresponent
            echo "
            <div class='col-md-3 m-2'>
                <div class='card {$color}'>
                    <div class='card-body text-center'>
                        <h2 class='card-title'>{$temperatura}°C</h2>
                        <p class='card-text'>{$classe}</p>
                    </div>
                </div>
            </div>";
        }

        // Calculem la mitjana de les temperatures
        $mitjana = $suma_temperatures / $num_temperatures;
        ?>
    </div>

    <div class="text-center mt-5">
        <h3 class="fw-bold">Mitjana de les temperatures: <?php echo number_format($mitjana, 2); ?>°C</h3>
    </div>
</div>

<!-- Incloem JavaScript de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
