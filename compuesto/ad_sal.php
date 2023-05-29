<?php
include 'conex.php';
/*Cerrar sesión como administrador */
session_start();
session_unset();
session_destroy();

header('location:../admin/ad_log.php');
?>