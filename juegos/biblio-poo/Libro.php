<?php
class Libro
{
    // Propiedades del libro
    public $titulo;
    public $autor;
    public $anioPublicacion;
    public $foto;

    // Constructor para inicializar las propiedades
    public function __construct($titulo, $autor, $anioPublicacion, $foto)
    {
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->anioPublicacion = $anioPublicacion;
        $this->foto = $foto;
    }

    // Método para mostrar los detalles del libro (devuelve un string HTML)
    public function mostrarDetalles()
    {
        return "
        <div class='p-4 border rounded bg-gray-100'>
            <h2 class='font-bold text-lg'>{$this->titulo}</h2>
            <p>Autor: {$this->autor}</p>
            <p>Año: {$this->anioPublicacion}</p>
            <img src='{$this->foto}' alt='Portada de {$this->titulo}' class='w-32 h-auto mt-2'>
        </div>";
    }
}
