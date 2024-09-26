<?php 

// // //1.1  ARRAY ESCALAR INDEXADO
// // $estudiantes = array('Dídac', 'David', 'Lucía');
// // $lista = array("Suleiman", "Brian", "Dani");

// // // var_dump($lista);
// // print_r($lista);

// // //DESDE LA VERSION 5.4 PHP
// // $lista2 = ["Dídac", "Kevin", "David", 87, 32, 78.23, true];

// // echo $lista2[1];


// // //añadir elementos a un array
// // $colores = ['rojo', 'azul', 'verde'];

// // $colores[] = 'Naranja';
// // print_r($colores);




// //2. array asociativo

// //2. ARRAYS ASOCIATIVOS
// $tutor = [
//     "nombre" => "Albert", 
//     "apellidos" => "Arrebola Sans",
//     "edad" => 36
// ];

// echo $tutor["apellidos"];

// $tutor["edad"] = 18;

// // print_r( array_keys($tutor));


// //RECORRER ARRAY CON UN FOR
// $numeros = [1,2,3,4,5,6,7,8,9];
// for ($i = 0; $i < count($numeros); $i++){
//     echo $numeros[$i] . "<br>";
    
// }

// //RECORRER NARRAY CON UN FOREACH
// $numeros = [1,2,3,4,5,6,7,8,9];
// foreach($numeros as $num){
//     echo ($num * 2) . ' ';

// }

// //recorrer un array asociativo
// $ciudades = [
//     "París" => "Francia",
//     "Barcelona" => "Espanya",
//     "Londres" => "Reino Unido"
// ];

// foreach ($ciudades as $ciudad => $pais ) {

//     if($ciudad == 'Barcelona'){
//         echo "La ciudad de $ciudad está en $pais";
//     }
// }


//forach en arrays multidimensionales
//Crea un array multidimensional de estudiantes y sus notas, y recorre cada estudiante con foreach para mostrar sus datos.
$estudiantes = [
    ["nombre" => "Anna", "nota" => 10, "genero" => 'm'],
    ["nombre" => "Dani", "nota" => 10, "genero" => 'h'],
    ["nombre" => "Yehor", "nota" => 11, "genero" => 'h'],
    ["nombre" => "Lucía", "nota" => 9,"genero" => 'm'],
    ["nombre" => "David", "nota" => 12,"genero" => 'h'],
    
];

foreach ($estudiantes as $estudiante){
    if($estudiante['genero'] == 'h'){
        echo "El estudiante: {$estudiante['nombre']} ha sacado un {$estudiante['nota']}<br>";
    } else{
        echo "La estudiante: {$estudiante['nombre']} ha sacado un {$estudiante['nota']}<br>";
    }
    
}


















