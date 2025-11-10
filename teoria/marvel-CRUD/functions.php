<?php
session_start();
if (!isset($_SESSION['personajes'])) {
    $_SESSION['personajes'] = [
        [
            "nombre" => "Iron Man",
            "imagen" => "https://i.blogs.es/10d884/captura-de-pantalla-2025-07-09-a-las-14.34.52/375_375.jpeg",
            "poder" => "Volar amb armadura",
            "descripcion" => "Tony Stark, geni, multimilionari i filantrop."
        ],
        [
            "nombre" => "Spider-Man",
            "imagen" => "https://i.blogs.es/10d884/captura-de-pantalla-2025-07-09-a-las-14.34.52/375_375.jpeg",
            "poder" => "Sentit aràcnid",
            "descripcion" => "Peter Parker, heroi de Queens."
        ]
    ];
}


//FUNCÓN PARA AÑADIR PERSONAJE (CREATE EN BDD)
function agregarPersonaje($nombre, $img, $poder, $desc) {
    $_SESSION['personajes'][] = [
        "nombre" => $nombre,
        "imagen" => $img,
        "poder" => $poder,
        "descripcion" => $desc
    ];
}

//EDITAR PERSONAJE

function editarPersonaje($id, $nombre, $img, $poder, $desc) {
    if (isset($_SESSION['personajes'][$id])) {
        $_SESSION['personajes'][$id] = [
            "nombre" => $nombre,
            "imagen" => $img,
            "poder" => $poder,
            "descripcion" => $desc
        ];
    }
}

/* Eliminar un personatge (DELETE) */
function eliminarPersonaje($id) {
    if (isset($_SESSION['personajes'][$id])) {
        unset($_SESSION['personajes'][$id]);
        $_SESSION['personajes'] = array_values($_SESSION['personajes']);
    }
}
