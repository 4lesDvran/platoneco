<?php 
// Aqui se establece las credenciales de acceso del administrador para la PDO 
$db_name = 'mysql:host=localhost;dbname=store_db';
$user_name = 'root';
$user_password = '';
$conn = new PDO($db_name, $user_name, $user_password);

?>
