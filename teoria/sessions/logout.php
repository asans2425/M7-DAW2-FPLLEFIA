<?php
session_start();
//destruyo toda la sesión
session_destroy();
header('Location: index.php');