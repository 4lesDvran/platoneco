<?php
include 'conex.php';
/*Cerrar sesión como usuario */
session_start();
session_unset();
session_destroy();

header('location:../home.php');

?>