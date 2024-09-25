
<!DOCTYPE html>
<html lang="es">
<head>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&family=Press+Start+2P&family=Rubik:wght@300;400&display=swap" rel="stylesheet">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Form. apuestas</title>

	<script>
			alert ("Escriu les caselles separades per comes (transversal, cavall, quadre i seisena), i les lletres sempre en MINÚSCULES. A dotzena i columna, marca el numero corresponent (1, 2 o 3)");
	</script>
<style>
	*{
		background-color:  #136b11;
		font-family: 'Rubik', sans-serif;
		
		
	}
	.container{
		background-color:  #136b11;
	}
	.imagenes{
		display: flex;
		margin-bottom: 50px;

	}
	
	.tapete{
		width: 700px;
		margin-left: 80px;
		margin-top: 30px;

	}
	form input{
		background-color: lightgray;
		padding: 10px;
		margin-right: 20px;
		border-radius: 10px;
		
	


	}
	option{
		background-color: #F0F8FF;



	}
	form select{
		background-color: lightgray;
		padding: 10px;
		margin-right: 20px;
		border-radius: 7px;
		
	}
	form{
		display: flex;
		padding: 20px;
		margin-left: 30px;
	}
	.btn_enviar:hover{
		background-color: orange;
		font-weight: bold;
		
	}
	
	@keyframes rotate {from {transform: rotate(0deg);}
	    to {transform: rotate(360deg);}}
	@-webkit-keyframes rotate {from {-webkit-transform: rotate(0deg);}
	  to {-webkit-transform: rotate(360deg);}}
	
	#rotar{
	    -webkit-animation: 3s rotate linear infinite;
	    animation: 3s rotate linear infinite;
	    -webkit-transform-origin: 50% 50%;
	    transform-origin: 50% 50%;
	    width: 350px;
	    height: 350px;
	    margin-top: 100px;
	   margin-left: 50px;

	 
	}

	


</style>
</head>
<body>

	<div class="container">

		<div class="imagenes">
			<img src="ruletaN.png"  id="rotar">
			<img src="tapete.png" alt="" class="tapete" >
		</div>

		<form action="ruleta2.php" method="post">

			<select type="select" name="tipo-apuesta">
				<option  name="Senzilla">Senzilla</option>
				<option name="Passa/Falta">Passa/Falta</option>
				<option name="Vermell/Negre">Vermell/Negre</option>
				<option name="Parell/Imparell">Parell/Imparell</option>
				<option name="Quadre">Quadre</option>
				<option name="Cavall">Cavall</option>
				<option name="Transversal">Transversal</option>
				<option name="Dotzena">Dotzena</option>
				<option name="Columna">Columna</option>
				<option name="Siaena">Sisena</option>
			</select><br>


			<input type="text" name="apuesta" placeholder="A que apostes?"><br>
			<input type="text" name="dinero" placeholder="Quantitat de diners? (€)">
			<input type="submit" value="ENVIAR" class="btn_enviar">

		</form>
	</div>
	
	

	
</body>
</html>

