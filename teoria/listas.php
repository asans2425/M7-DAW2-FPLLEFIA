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


// //forach en arrays multidimensionales
// //Crea un array multidimensional de estudiantes y sus notas, y recorre cada estudiante con foreach para mostrar sus datos.
// $estudiantes = [
//     ["nombre" => "Anna", "nota" => 10, "genero" => 'm'],
//     ["nombre" => "Dani", "nota" => 10, "genero" => 'h'],
//     ["nombre" => "Yehor", "nota" => 11, "genero" => 'h'],
//     ["nombre" => "Lucía", "nota" => 9,"genero" => 'm'],
//     ["nombre" => "David", "nota" => 12,"genero" => 'h'],
    
// ];

// foreach ($estudiantes as $estudiante){
//     if($estudiante['genero'] == 'h'){
//         echo "El estudiante: {$estudiante['nombre']} ha sacado un {$estudiante['nota']}<br>";
//     } else{
//         echo "La estudiante: {$estudiante['nombre']} ha sacado un {$estudiante['nota']}<br>";
//     }
    
// }


// Definimos 5 películas y sus puntuaciones SIN ARRAYS
// $nom_peli_1 = "Interstellar";
// $punts_peli_1 = 10;

// $nom_peli_2 = "Titanic";
// $punts_peli_2 = 4;

// $nom_peli_3 = "Avatar";
// $punts_peli_3 = 7;

// $nom_peli_4 = "The Room";
// $punts_peli_4 = 2;

// $nom_peli_5 = "Inception";
// $punts_peli_5 = 9;



$llista_pelis_nombres = ['inerestelar', 'dfsdfsdf', 'sdfsdfsdfsdfsdf'];
$lista_valoraciones = [7,2,6,9,10];


?>
<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <title>Taula de pel·lícules</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #222;
      color: #fff;
      text-align: center;
      padding: 40px;
    }
    h1 { margin-bottom: 5px; }
    h2 { margin-top: 0; font-weight: normal; color: #ddd; }
    table {
      margin: 30px auto;
      border-collapse: collapse;
      width: 60%;
      background: #333;
      box-shadow: 0 0 10px rgba(0,0,0,.5);
    }
    thead {
      background: gold;
      color: black;
    }
    th, td {
      padding: 12px 18px;
      border: 1px solid #555;
    }
    .vermell {
      background: #d9534f;
      color: white;
    }
    .verd {
      background: #5cb85c;
      color: white;
    }
  </style>
</head>
<body>
  <h1>Llistat de pel·lícules</h1>
  <h2>Sense arrays (variables variables)</h2>

  
  <table>
    <thead>
      <tr>
        <th>Títol</th>
        <th>Puntuació</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Recorrem de l’1 al 5 amb un for
      for ($i = 0; $i <= count($lista_valoraciones)-1; $i++) {
         echo $i;

         

          // Classe segons puntuació
          $classe = ($punts < 5) ? "vermell" : "verd";

          echo "<tr>";
          echo "<td>$i -- $llista_pelis_nombres[$i]</td>";
          echo "<td class='$classe'>$lista_valoraciones[$i]</td>";
          echo "</tr>";
      }

      //llista associativa
      $assoc = [
        'fruita' => 'poma',
        'menjar' => 'macarrons'
      ];

      foreach( $assoc as $a => $b){
        echo "<div class='red'>
      {$a} es una {$b}";
      }
      //llista multidimensional


      ?>
    </tbody>
  </table>
</body>
</html>






