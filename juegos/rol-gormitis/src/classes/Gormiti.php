<?php

// Crear la clase Gormiti
class Gormiti
{
    public $id;           // ID único del Gormiti
    public $nom;          // Nombre del Gormiti
    public $salut;        // Salud del Gormiti
    public $dany;         // Daño de ataque del Gormiti
    public $imatge;       // Imagen asociada al Gormiti (URL de la imagen)
    public $habilitats;   // Array de habilidades del Gormiti

    // Constructor para inicializar el Gormiti con sus propiedades
    public function __construct($id, $nom, $salut, $dany, $imatge, $habilitats = [])
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->salut = $salut;
        $this->dany = $dany;
        $this->imatge = $imatge;
        $this->habilitats = $habilitats;
    }

    // Método para obtener las habilidades del Gormiti como una cadena separada por comas
    public function obtenirHabilitats()
    {
        return implode(', ', $this->habilitats);
    }

    // Método para aplicar daño al Gormiti (reducir salud)
    public function aplicarDany($dany)
    {
        $this->salut -= $dany;
        if ($this->salut < 0) {
            $this->salut = 0; // Aseguramos que la salud no sea negativa
        }
    }

    // Método para aumentar el daño del Gormiti (porcentaje de incremento)
    public function augmentarDany($porcentaje)
    {
        $this->dany += ($this->dany * $porcentaje / 100);
    }

    // Método para aumentar la salud del Gormiti (porcentaje de incremento)
    public function augmentarSalut($porcentaje)
    {
        $this->salut += ($this->salut * $porcentaje / 100);
    }

    // Método para obtener la descripción del Gormiti (para pruebas o mostrar en interfaz)
    public function descripcion()
    {
        return "Gormiti: " . $this->nom . ", Salud: " . $this->salut . ", Daño: " . $this->dany . ", Habilidades: " . $this->obtenirHabilitats();
    }
}
