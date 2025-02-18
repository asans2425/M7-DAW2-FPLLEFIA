<?php

//saiyajin.php
//sin parentesis como en las funciones
//definimos los atributos

class Saiyajin
{
    //primero modificaciones de acceso (siempre publico de momento) protected o private...
    //no dejan de ser variables $
    //se puede definir o no (null)
    //se puede tipar estricto o no (sino php entiende el tipo)
    // public $nombre;
    // public $nombre; 
    public string $nombre = "Goku";
    public int $nivel_pelea = 1000;

    //primer metodo o funcion
    //siempre en mayusculas la primera ej: Saludar();
    //podemos devolver ya mediante el return. 
    //Si queremos usar atributos o metodos de dentro de nuestra clase hay que usar el $this
    //podemos TIPAR LA FUNCIÓN. obligo a devolver el tipo que le pongas
    public function Saludar() : int
    {
        return "Hola, mi nombre es " . $this->nombre;
    }
    //segundo metodo
    public function NivelDePelea() 
    {
        return $this->nombre . "tiene un nivel de pelea de " . $this->nivel_pelea;
    }
}


//fuera de la clase
//INSTANCIO UNA CLASE
//CREanDO ASÍ UN OBJETO con new Clase()
$objeto1 = new Saiyajin();


// //$goku ahora tiene un nivel de pelea mil y un nombre saiyajin
// //provamos a verlo con un var_dump()
// // var_dump($goku);
// // var_dump($goku2);

echo $goku->Saludar();
 echo '<br>';
 echo "Mi nivel de pelea es: " . $goku->NivelDePelea();




// var_dump($vegeta);
// //vemos que las propiedad seran las mismas. siempre lo seran porque son fijas... para eso existe el constructores: vamos a la sesión 2

