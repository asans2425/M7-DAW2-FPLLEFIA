<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>resultados ruleta</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&family=Press+Start+2P&display=swap" rel="stylesheet">
	<style>
		.contenido{
			background-image: url("fondoruleta.jpg");
			background-size: cover;
			background-position: bottom top ;
			background-repeat: no-repeat;
            padding:230px;
            font-family: 'Press Start 2P', cursive;
            color:white;
		}
		*{
			padding: 0px;
			margin:0px;
		}
		.torna{
			padding: 10px;
			border-radius: 0px;
			background-color: tomato;
			font-family: "Press Start 2P"; 
			color: white
		}
		.torna:hover{
			background-color: white;
			color: tomato;
		}

	</style>
	

</head>
<body>
<div class="contenido">
<?php
 


if(isset($_REQUEST['tipo-apuesta'])){
	$numero=rand(0,36);
	
	//$numero=0;

	$t=$_REQUEST['tipo-apuesta'];
	$a=$_REQUEST['apuesta'];
	$d=$_REQUEST['dinero'];

	
	echo"Has escollit el tipus d'aposta: ".$t."<br><br>";
	echo"Has apostat al: ".$a."<br><br>";
	echo"Has apostat ".$d. "€ <br><br>";
	
	
function sacar_dinero($d,$x){
	$total = $d*$x;
	echo '<br><br>Si retires els diners, amb la aposta base, tens un total de '. $total . "€";
	return $total;
}
/*********************** SENCILLA ****************:)******/
	switch ($t) {

		case 'Senzilla':
			echo"La bola ha caigut en la casella número ".$numero."<br><br>";
			if($numero == $a) {
				echo 'Has guanyat '. $d*35 .' (€)';
				sacar_dinero($d,36);
			}else {
				echo 'Has perdut '. $d .' (€)';
				
			}break;
			
			

		
/*********************PASSA / FALTA ************** :)*******/
		case 'Passa/Falta':
		echo "<script> alert('".$infopassafalta."'); </script>";

			echo"La bola ha caigut en la casella número ".$numero."<br><br>";
			if($numero == 0){
				echo 'Ha caigut en el "0" per tant, perds la meitat del que has apostat; perds: '. $d/2 . "€";
			}if ($numero >= 19 && $numero <= 36){
				echo '--- PASSA --- ';
				if($a == "passa"){
					echo 'Has guanyat '. $d .' (€)';
					sacar_dinero($d,2);
				}elseif ($a== "falta"){
					echo 'Has perdut '. $d .' (€)';
				}
				
			}elseif ($numero < 19 && $numero >0){
				echo '--- FALTA --- ';
				if($a == "falta"){
					echo 'Has guanyat '. $d .' (€)';
				}elseif ($a == "passa"){
				echo 'Has perdut '. $d .' (€)';
				}
			}break;


/*********************PARELL / IMPARELL **********:)****/
		case 'Parell/Imparell':
			if($numero == 0){
				echo 'Ha caigut en el "0" per tant, només perds la meitat del que has apostat... ('. $d/2 . ") €";
			}elseif ($numero%2 == 0 && $numero !=0){
				echo"La bola ha caigut en el número ".$numero." (PARELL!)<br><br>";
			}else{
				echo"La bola ha caigut en el número ".$numero." (IMPARELL!)<br><br>";
			}
			
			if ($numero >= 0 && $numero <= 36){
				if($numero %2 == 0 && $numero !=0 && $a == "parell"){
					echo 'Has guanyat '. $d .' (€)';
					sacar_dinero($d,2);
				}
				elseif($numero %2 == 0 && $numero !=0 && $a == "imparell"){
					echo 'Has perdut '. $d .' (€)';
				}
				if($numero%2 != 0 &&  $numero !=0 && $a == "imparell"){
					echo 'Has guanyat '. $d .' (€)';
					sacar_dinero($d,2);
				}
				if($numero%2 != 0 && $numero !=0 && $a == "parell"){
					echo 'Has perdut '. $d .' (€)';
				}
			}else {
				echo 'Escriu un nombre que estigui dins la ruleta ...(0-36)';
				}break;
			
/*********************VERMELL Y NEGRE *******:)*******/

case 'Vermell/Negre':
	$vermells = [1,3,5,7,9,12,14,16,18,19,21,23,25,27,30,32,34,36];
	$negres = [2,4,6,8,10,11,13,15,17,20,22,24,26,28,29,31,33,35];

	echo"La bola ha caigut en la casella número ".$numero."<br><br>";
	if($numero == 0){
		echo 'Ha caigut en el "0" per tant, perds la meitat del que has apostat; perds: '. $d/2 . "€";
	}

	if (in_array($numero, $vermells) && $a == "vermell"){
		echo'Has dit vermell i ha caigut en... vermell!<br><br>';
		echo'Has guanyat '. $d . '€';
		sacar_dinero($d,2);
		
	}elseif(in_array($numero, $vermells) && $a == "negre"){
		echo'Has dit negre i ha caigut en... vermell <br><br>';
		echo'Has perdut '. $d . '€';
	}

	if (in_array($numero, $negres) && $a == "negre"){
		echo'Has dit negre i ha caigut en... negre!<br><br>';
		echo'Has guanyat '. $d . '€';
		sacar_dinero($d,2);

	}elseif(in_array($numero, $negres) && $a == "vermell"){
		echo'Has dit vermell i ha caigut en... negre <br><br>';
		echo'Has perdut '. $d . '€';
	}
	break;


/********************* QUADRE ******** :) ******/
case 'Quadre':
	
	$array_quadre = explode ( ',', $a);
	foreach ($array_quadre as $nums ){
	//echo $nums;
	}

   if (in_array($numero, $array_quadre)){
    	echo 'La bola ha caigut a la casella: '.$numero. ' <br><br>Dins el teu quadre!<br><br>';
    	echo'Has guanyat '. $d*8 . '€';
    	sacar_dinero($d,9);
    }
    else{
    	echo 'La bola ha caigut a la casella: '.$numero. '<br><br>Fora del teu quadre...<br><br>';
    	echo'Has perdut '. $d . '€';
    }
    break;

/********************* CAVALL ****** :) **********/

			
case 'Cavall':
	$array_cavall = explode ( ',', $a);
	foreach ($array_cavall as $nums ){
	//echo $nums;
	}

   if (in_array($numero, $array_cavall)){
    	echo 'La bola ha caigut a la casella: '.$numero. ' <br><br>A una de les dos que has apostat!!!<br><br>';
    	echo'Has guanyat '. $d*17 . '€';
    	sacar_dinero($d,18);
    }
    else{
    	echo 'La bola ha caigut a la casella: '.$numero. '<br><br>No has encertat...<br><br>';
    	echo'Has perdut '. $d . '€';
    }
    break;

    /********************* TRANSVERSAL ****** :) **********/

			
case 'Transversal':
	$array_transversal = explode ( ',', $a);
	foreach ($array_transversal as $nums ) {
	//echo $nums;
	}

   if (in_array($numero, $array_transversal)){
    	echo 'La bola ha caigut a la casella: '.$numero. ' <br><br>Dins la teva fila apostada!<br><br>';
    	echo'Has guanyat '. $d*11 . '€';
    	sacar_dinero($d,12);
    }
    else{
    	echo 'La bola ha caigut a la casella: '.$numero. '<br><br>Fora de la teva fila.<br><br>No has encertat...<br><br>';
    	echo'Has perdut '. $d . '€';
    }
    break;


     /********************* COLUMNA ****** :) **********/
     
     case 'Columna':
	    $columna1 = [1,4,7,10,13,16,19,22,25,28,31,34];
	    $columna2 = [2,5,8,11,14,17,20,23,26,29,32,35];
	    $columna3 = [3,6,9,12,15,18,21,24,27,30,33,36];

//SI SE APUESTA A LA COLUMNA 1
	    if (in_array($numero, $columna1)){
	    	echo 'Ha caigut a la Columna nº1 <br><br>';

			if ($a == 1 && in_array($numero, $columna1)){

		    	echo 'La bola ha caigut a la casella: '.$numero. ' <br><br>Dins la teva columna apostada!<br><br>';
		    	echo 'Has guanyat '. $d*2 .' (€)';
		    	sacar_dinero($d,3);

			}elseif ($a == 2 && in_array($numero, $columna1)){
		    	echo 'La bola ha caigut a la casella: '.$numero. '<br><br>Fora de la teva columna.<br><br>No has encertat...<br><br>';
	    		echo'Has perdut '. $d . '€';

			}elseif ($a == 3 && in_array($numero, $columna1)){
		    	echo 'La bola ha caigut a la casella: '.$numero. '<br><br>Fora de la teva columna.<br><br>No has encertat...<br><br>';
	    		echo'Has perdut '. $d . '€';
		    	}
		  	}
//SI SE APUESTA A LA COLUMNA 2
	    if (in_array($numero, $columna2)){
	    	echo 'Ha caigut a la Columna nº2<br><br>';
	    	if ($a == 1 && in_array($numero, $columna2)){
		    	echo 'La bola ha caigut a la casella: '.$numero. '<br><br>Fora de la teva columna.<br><br>No has encertat...<br><br>';
	    		echo'Has perdut '. $d . '€';
    		
			}elseif ($a == 2 && in_array($numero, $columna2)){
		    	echo 'La bola ha caigut a la casella: '.$numero. ' <br><br>Dins la teva columna apostada!<br><br>';
	    		echo 'Has guanyat '. $d*2 .' (€)';
	    		sacar_dinero($d,3);

			}elseif ($a == 3 && in_array($numero, $columna2)){
		    	echo 'La bola ha caigut a la casella: '.$numero. '<br><br>Fora de la teva columna.<br><br>No has encertat...<br><br>';
	    		echo'Has perdut '. $d . '€';
	    		}
	    }
//SI SE APUESTA A LA COLUMNA 3
	    if (in_array($numero, $columna3)){
	    	echo 'Ha caigut a la Columna nº3<br><br>';

			if ($a == 1 && in_array($numero, $columna3)){
				    	echo 'La bola ha caigut a la casella: '.$numero. '<br><br>Fora de la teva columna.<br><br>No has encertat...<br><br>';
			    		echo'Has perdut '. $d . '€';
			}elseif ($a == 2 && in_array($numero, $columna3)){
			    	echo 'La bola ha caigut a la casella: '.$numero. '<br><br>Fora de la teva columna.<br><br>No has encertat...<br><br>';
					echo'Has perdut '. $d . '€';


			}elseif ($a == 3 && in_array($numero, $columna3)){
				    	echo 'La bola ha caigut a la casella: '.$numero. ' <br><br>Dins la teva columna apostada!<br><br>';
			    		echo 'Has guanyat '. $d*2 .' (€)';
			    		sacar_dinero($d,3);
			    	}
		}break;


/********************* DOTZENA ****** :) **********/
     
     case 'Dotzena':
	    $dotzena1 = [1,2,3,4,5,6,7,8,9,10,11,12];
	    $dotzena2 = [13,14,15,16,17,18,19,20,21,22,23,24];
	    $dotzena3 = [25,26,27,28,29,30,31,32,33,34,35,36];

//SI SE APUESTA A LA DOTZENA 1
	    if (in_array($numero, $dotzena1)){
	    	//echo 'Ha caigut a la Dotzena nº1 <br><br>';

			if ($a == 1 && in_array($numero, $dotzena1)){

		    	echo 'La bola ha caigut a la casella: '.$numero. ' (Dotzena 1)<br><br>Dins la teva dotzena apostada!<br><br>';
		    	echo 'Has guanyat '. $d*2 .' (€)';
		    	sacar_dinero($d,3);

			}elseif ($a == 2 && in_array($numero, $dotzena1)){
		    	echo 'La bola ha caigut a la casella: '.$numero. ' (Dotzena 1)<br><br>Fora de la teva dotzena.<br><br>No has encertat...<br><br>';
	    		echo'Has perdut '. $d . '€';

			}elseif ($a == 3 && in_array($numero, $dotzena1)){
		    	echo 'La bola ha caigut a la casella: '.$numero. ' (Dotzena 1)<br><br>Fora de la teva dotzena.<br><br>No has encertat...<br><br>';
	    		echo'Has perdut '. $d . '€';
		    	}
		  	}
//SI SE APUESTA A LA DOTZENA 2
	    if (in_array($numero, $dotzena2)){
	    	//echo 'Ha caigut a la Dotzena nº2<br><br>';
	    	if ($a == 1 && in_array($numero, $dotzena2)){
		    	echo 'La bola ha caigut a la casella: '.$numero. ' (Dotzena 2)<br><br>Fora de la teva dotzena.<br><br>No has encertat...<br><br>';
	    		echo'Has perdut '. $d . '€';
    		
			}elseif ($a == 2 && in_array($numero, $dotzena2)){
		    	echo 'La bola ha caigut a la casella: '.$numero. ' (Dotzena 2)<br><br>Dins la teva dotzena apostada!<br><br>';
	    		echo 'Has guanyat '. $d*2 .' (€)';
	    		sacar_dinero($d,3);

			}elseif ($a == 3 && in_array($numero, $dotzena2)){
		    	echo 'La bola ha caigut a la casella: '.$numero. ' (Dotzena 2)<br><br>Fora de la teva dotzena.<br><br>No has encertat...<br><br>';
	    		echo'Has perdut '. $d . '€';
	    		}
	    }
//SI SE APUESTA A LA DOTZENA 3
	    if (in_array($numero, $dotzena3)){
	    	//echo 'Ha caigut a la Dotzena nº3<br><br>';

			if ($a == 1 && in_array($numero, $dotzena3)){
				    	echo 'La bola ha caigut a la casella: '.$numero. ' (Dotzena 3)<br><br>Fora de la teva dotzena.<br><br>No has encertat...<br><br>';
			    		echo'Has perdut '. $d . '€';
			}elseif ($a == 2 && in_array($numero, $dotzena3)){
			    	echo 'La bola ha caigut a la casella: '.$numero. ' (Dotzena 3)<br><br>Fora de la teva dotzena.<br><br>No has encertat...<br><br>';
					echo'Has perdut '. $d . '€';


			}elseif ($a == 3 && in_array($numero, $dotzena3)){
				    	echo 'La bola ha caigut a la casella: '.$numero. ' (Dotzena 3)<br><br>Dins la teva dotzena apostada!<br><br>';
			    		echo 'Has guanyat '. $d*2 .' (€)';
			    		sacar_dinero($d,3);
			    	}
		}break;


/********************* SISENA ****** :) **********/

case 'Sisena':
	$array_sisena = explode ( ',', $a);
	foreach ($array_sisena as $nums ) {
	//echo $nums;
	}

   if (in_array($numero, $array_sisena)){
    	echo 'La bola ha caigut a la casella: '.$numero. ' <br><br>A una de les dos que has apostat!!!<br><br>';
    	echo'Has guanyat '. $d*5 . '€';
    	sacar_dinero($d,6);
    }
    else{
    	echo 'La bola ha caigut a la casella: '.$numero. '<br><br>No has encertat...<br><br>';
    	echo'Has perdut '. $d . '€';
    }
    break;


/********************* FIN CASES SWITCH ****** :) **********/


		default:
			# code...
			break;
	
}
}


?>
<br><br><br><br><br>



<a href="ruleta.php"><button class="torna">Fes click aquí per tornar a apostar </button></a>
</div>



</body>
</html>
