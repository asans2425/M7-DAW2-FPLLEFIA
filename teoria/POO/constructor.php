<?php

//saiyajin.php
//sin parentesis como en las funciones
//definimos los atributos

class Saiyajin
{

    public string $nombre;
    public int $nivel_pelea;
    //aqui va le constructor; después de las propeidades o atributos
    public function __construct($nombre, $nivel_pelea)
    {
        // echo 'Método constructor';
        $this->nombre = $nombre;
        $this->nivel_pelea = $nivel_pelea;
        //ojo que si no pasamos parametros, se tomarán los valores por defecto (null). como en el caso anterior.
    }
    //para que sirve? para definir o darle un valor a los atributos iniciales de la clase
    //si no pasamos parametros en el constructor, se tomarán los valores por defecto



    //esto se puede sustituir por parametros, en lugar de poner el string fijo 
    //podemos poner $texto como parametro y retornar $texto.$this->nombre
    //pero luego habrá que pasarle un texto a saludar
    public function Saludar($texto)
    {
        return $texto . $this->nombre;
    }
    //segundo metodo
    public function NivelDePelea()
    {
        return $this->nombre . "tiene un nivel de pelea de " . $this->nivel_pelea;
    }
}


//fuera de la clase
//INSTANCIO UNA CLASE
//CRENADO ASÍ UN OBJETO con new Clase()
$goku = new Saiyajin('Goku ', 1400);

echo $goku->NivelDePelea();
echo '<br>';
echo $goku->Saludar('Hola, mi nombre es ');
echo '<br>';
$vegeta = new Saiyajin('Vegeta ', 1800);
echo $vegeta->NivelDePelea();
echo '<br>';
echo $vegeta->Saludar('Buenas, que sepas que me llamo: ');
