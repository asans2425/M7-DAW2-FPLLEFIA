<?php
class Biblioteca
{
    // Ahora es un array de detalles de libros
    public $libros = [];

    // Método para agregar un libro
    public function agregarLibro($libro)
    {
        $this->libros[] = $libro;
    }

    // Método para mostrar todos los libros, ahora devuelve un array
    public function mostrarLibros()
    {
        // Creamos un array de detalles de libros

        // Si no hay libros, devolvemos un mensaje
        return count($this->libros) > 0 ? $this->libros : ["No hay libros en la biblioteca."];
    }

    // Método para buscar libros por título
    public function buscarLibroPorTitulo($titulo)
    {
        // Creamos un array de resultados
        $resultado = [];
        foreach ($this->libros as $libro) {
            if (stripos($libro->titulo, $titulo) !== false) {
                // Si el título coincide, lo agregamos al resultado
                $resultado[] = $libro->mostrarDetalles();
            }
        }
        return count($resultado) > 0 ? $resultado : ["No se encontró ningún libro con ese título."];
    }
}
