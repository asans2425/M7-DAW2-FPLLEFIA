<?php
class Jugador
{

    //Propiedades
    public $mano;
    public $id;

    //Métodos
    function __construct($ID)
    {
        $this->mano = new Baraja(); // Mano es un objeto de la clase baraja. 
        $this->id = $ID;
    }
}
