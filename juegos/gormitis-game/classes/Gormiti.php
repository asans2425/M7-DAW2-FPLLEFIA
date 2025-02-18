<?php

class Gormiti {
    public $nom;
    public $salut;
    public $dany;
    public $imatge;
    public $habilitats;

    public function __construct($nom, $salut, $dany, $imatge, $habilitats = []) {
        $this->nom = $nom;
        $this->salut = $salut;
        $this->dany = $dany;
        $this->imatge = $imatge;
        $this->habilitats = $habilitats;
    }

    public function obtenirHabilitats() {
        return implode(', ', $this->habilitats); // Retorna les habilitats com una cadena separada per comes
        //explica perque implode 
        //implode — Concatena elements de un array en una cadena
        //https://www.php.net/manual/en/function.implode.php
    }
}
?>
