<?php
session_start();

// Verificar si el usuario ha iniciado sesión y si su rol es "admin"
//otra opción sería comprobar si el rol es admin para mostrar o no el icono de admin. Pero eso no garantiza que no se pueda acceder a la página por url. 
if (!isset($_SESSION['user_id']) || $_SESSION['user_rol'] !== 'admin') {
    echo '
     <h1>No tienes permisos para acceder aquí</h1>';
} else {
    echo '
    <h1>Panel de administración</h1>
    <ul>
        <li><a href="adminUsers.php">Gestión de usuarios</a></li>
        <li><a href="adminNews.php">Gestión de noticias</a></li>
        <li><a href="adminProjects.php">Gestión de proyectos</a></li>
    </ul>';


    //tabla de usuarios
    //tabla de noticias
    //tabla de proyectos
    //tabla de testimonios

  


   





}
