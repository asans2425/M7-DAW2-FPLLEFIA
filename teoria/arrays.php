<?php

//1. ESCALAR
$estudiantes = array('Dídac', 'David', 'Lucía');

// $estudiantes[3] --> ERROR!!!

echo $estudiantes[2]; //Lucía
$estudiantes[2] = 'Dani'; 
echo $estudiantes[2]; //Dani


//1.1. NUEVA SINTAXIS
$estudiantes = ["Alberto", "Hicham", "Jesús", 9, 38];
echo $estudiantes[4];

//1.2. ARRAY VACÍO 
$estudiantes = [];


//2. ARRAYS ASOCIATIVOS
$tutor = [
    "nombre" => "Albert", 
    "apellidos" => "Arrebola Sans",
    "edad" => 36 
];

echo $tutor["apellidos"];
$tutor["edad"] = 18;

// print_r( array_keys($tutor));


//3. MULTIDIMENSIONALES
$tutor_2 = [
    "nombre" => "Vanesa", 
    "apellido" => "Del Pilar", 
    "edad" => 64, 
    "tutor1" => [
        "nombre" => "Albert", 
        "apellidos" => "Arrebola Sans",
        "edad" => 36 
    ]
];


echo $tutor_2['cursos'][2]; //html 5

echo $tutor_2["tutor1"]["edad"];








