<?php

class Jugador
{
    public $id;
    public $nom;
    public $gormiti;
    public $objecteEspecial;

    // Constructor
    public function __construct($id, $nom, $gormiti)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->gormiti = $gormiti;
        $this->objecteEspecial = null;  // Inicialment sense objecte especial
    }

    // Assignar objecte especial
    public function assignarObjecteEspecial($objecteEspecial)
    {
        $this->objecteEspecial = $objecteEspecial;
    }

    // Aplicar efecte de l'objecte especial
    public function aplicarObjecteEspecial()
    {
        if ($this->objecteEspecial) {
            $this->objecteEspecial->aplicarEfecte($this);
        }
    }

    // Descripció de l'estat del jugador
    public function descripcion()
    {
        $desc = "Nom: " . $this->nom . "<br>";
        $desc .= "Gormiti: " . $this->gormiti->nom . "<br>";
        $desc .= "Salut: " . $this->gormiti->salut . "<br>";
        $desc .= "Dany: " . $this->gormiti->dany . "<br>";

        if ($this->objecteEspecial) {
            $desc .= "Objecte Especial: " . $this->objecteEspecial->nom . "<br>";
        }

        return $desc;
    }
}
