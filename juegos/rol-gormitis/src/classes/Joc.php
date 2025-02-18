<?php

class Joc
{
    public $jugadors;

    // Constructor que inicialitza el joc amb els jugadors
    public function __construct($jugadors = [])
    {
        $this->jugadors = $jugadors;
    }

    // Mètode per iniciar el combat
    public function iniciarCombat()
    {
        // Aplicar efectes dels objectes especials als jugadors
        foreach ($this->jugadors as $jugador) {
            $jugador->aplicarObjecteEspecial();
        }

        // Simulació del combat
        $resultat = $this->combat();

        // Mostrar el resultat del combat
        echo "<h2>Resultat del Combat</h2>";
        foreach ($this->jugadors as $jugador) {
            echo $jugador->descripcion() . "<br>";
        }

        echo "<h3>Guanyador: " . $resultat . "</h3>";
    }

    // Mètode per gestionar el combat entre els jugadors
    private function combat()
    {
        // Simulació simple: cada jugador ataca amb el seu Gormiti i es compara el dany
        $jugador1 = $this->jugadors[0];
        $jugador2 = $this->jugadors[1];

        // Aplicar el dany als jugadors
        $danyJugador1 = $jugador1->gormiti->dany;
        $danyJugador2 = $jugador2->gormiti->dany;

        // Considerem la salut dels jugadors després del combat
        $jugador1->gormiti->salut -= $danyJugador2;
        $jugador2->gormiti->salut -= $danyJugador1;

        // Determinar el guanyador
        if ($jugador1->gormiti->salut > $jugador2->gormiti->salut) {
            return $jugador1->nom;
        } else {
            return $jugador2->nom;
        }
    }
}
