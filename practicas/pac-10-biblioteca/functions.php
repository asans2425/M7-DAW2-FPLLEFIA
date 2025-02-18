<?php
session_start(); // Inicia la sesión en functions.php para que esté disponible en todos los archivos

// Verificar si ya existe la lista de libros en la sesión
if (!isset($_SESSION['libros'])) {
    // Libros iniciales
    $_SESSION['libros'] = [
        ["titulo" => "1984", "autor" => "George Orwell", "imagen" => "https://i.scdn.co/image/ab67616d0000b2731f66a14c95f686040b212aa8", "descripcion" => "Distopía clásica sobre el totalitarismo."],
        ["titulo" => "Orgullo y Prejuicio", "autor" => "Jane Austen", "imagen" => "https://edicionesinvisibles.com/sites/default/files/orgullo_y_prejuicio.jpg", "descripcion" => "Historia de amor en la Inglaterra rural."],
        ["titulo" => "Cien Años de Soledad", "autor" => "Gabriel García Márquez", "imagen" => "https://www.planetadelibros.com/usuaris/libros/fotos/129/m_libros/portada_cien-anos-de-soledad_gabriel-garcia-marquez_201808091332.jpg", "descripcion" => "Una saga familiar en el pueblo ficticio de Macondo."]
    ];
}

// Función para agregar un nuevo libro
function agregarLibro($titulo, $autor, $imagen, $descripcion) {
    array_push($_SESSION['libros'], ["titulo" => $titulo, "autor" => $autor, "imagen" => $imagen, "descripcion" => $descripcion]);
}

// Función para editar un libro existente
function editarLibro($id, $titulo, $autor, $imagen, $descripcion) {
    if (isset($_SESSION['libros'][$id])) {
        $_SESSION['libros'][$id] = ["titulo" => $titulo, "autor" => $autor, "imagen" => $imagen, "descripcion" => $descripcion];
    }
}

// Función para eliminar un libro
function eliminarLibro($id) {
    if (isset($_SESSION['libros'][$id])) {
        unset($_SESSION['libros'][$id]);
        $_SESSION['libros'] = array_values($_SESSION['libros']); // Reindexar el array después de eliminar
    }
}
