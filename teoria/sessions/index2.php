<?php
session_start();
echo 'Bnevingut a la segona pàgina amb sessions.';
echo '<br>';



echo 'Usuari: ' . $_SESSION['user'];
echo '<br>';
echo 'Rol: ' . $_SESSION['role'];
echo '<br>';

?>