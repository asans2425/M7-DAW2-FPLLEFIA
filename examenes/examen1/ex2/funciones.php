<?php
session_start();

function agregar_producto($n, $p, $d)
{
    array_push(
        $_SESSION['productos'],
        ['nombre' => $n, 'precio' => $p, 'descripcion' => $d]
    );
}

function eliminar_producto($id)

{
    array_splice($_SESSION['productos'], $id, 1);
}
