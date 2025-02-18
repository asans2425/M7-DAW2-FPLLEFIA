<?php

class ObjecteEspecial
{
    public $nom;
    public $tipus;
    public $descripcio;
    public $valor;
    public $imatge; // URL de la imatge associada

    public function __construct($nom, $tipus, $descripcio, $valor, $imatge)
    {
        $this->nom = $nom;
        $this->tipus = $tipus;
        $this->descripcio = $descripcio;
        $this->valor = $valor;
        $this->imatge = $imatge;
    }

    // Aplica l'efecte de l'objecte especial a un jugador
    public function aplicarEfecte($jugador)
    {
        switch ($this->tipus) {
            case 'Augmenta atac':
                // Augmentem el dany de l'atacant
                if (isset($jugador->gormiti)) {
                    $jugador->gormiti->dany += ($jugador->gormiti->dany * $this->valor / 100);
                }
                break;
            case 'Redueix dany':
                // Reduïm el dany rebut pel jugador, basant-nos en el percentatge de l'objecte
                $jugador->dany_rebut_percentatge = $this->valor;
                break;
            case 'Augmenta salut':
                // Exemple d'augment de salut
                if (isset($jugador->gormiti)) {
                    $jugador->gormiti->salut += ($jugador->gormiti->salut * $this->valor / 100);
                }
                break;
            default:
                echo "Efecte desconegut per aquest objecte especial.";
                break;
        }
    }
}
