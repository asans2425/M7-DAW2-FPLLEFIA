<?php


// array multidimendsional

$alumnos = [
    [
        'nombre' => 'Juan',
        'apellido' => 'Pérez',
        'edad' => 21,
        'curso' => 'DAW2',
        'inteligente'=> true
    ],
    [
        'nombre' => 'María',
        'apellido' => 'García',
        'edad' => 22,
        'curso' => 'DAW1',
        'inteligente'=> false
    ],
    [
        'nombre' => 'Luis',
        'apellido' => 'López',
        'edad' => 20,
        'curso' => 'DAW2',
        'inteligente'=> true
    ]
];

foreach($alumnos as $alumno){
    echo "<h1>{$alumno['nombre']} {$alumno['apellido']}</h1>";
    echo "<p>Edad: {$alumno['edad']}</p>";
    echo "<p>Curso: {$alumno['curso']}</p>";
    echo "<p>Inteligente: " . ($alumno['inteligente'] ? 'Sí' : 'No') . "</p>";
    echo "<hr>";
}

?>