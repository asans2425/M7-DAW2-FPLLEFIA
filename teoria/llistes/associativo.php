<?php


$alumno = [
    'nombre' => 'Juan',
    'apellido' => 'Pérez',
    'edad' => 21,
    'curso' => 'DAW2',
    'inteligente'=> true
    // 'notas' => [8, 7.5, 9, 6.5]
];

print_r($alumno);


echo $alumno['nombre']; // Juan
echo $alumno['edad']; // 21
echo $alumno['inteligente']; // 1 (true)



//añadir un elemento
$alumno['email'] = 'juan.perez@example.com';

echo '<br><br>';
print_r($alumno);


//recorrer con foreach
foreach($alumno as $clave => $valor){
    echo "<h1>$clave: $valor</h1>";
}
?>