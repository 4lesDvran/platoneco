<?php
include '../compuesto/conex.php';
session_start();
/* Redireccion a logear como admin si no tiene credenciales */
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
    header('location:ad_log.php');
 }
/*Censurar mensajes a lo 1984, eliminarlos de la DB */
 if(isset($_GET['delete'])){
  $delete_id = $_GET['delete'];
  $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
  $delete_message->execute([$delete_id]);
  header('location:mensaje.php');
}
?>

<!doctype html>
<!-- Mensajes enviados por los usuarios para retroalimnentar el sitio-->
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content= "IE=edge">
    <meta name ="viewport" content = "width=device-width, initial-scale=1.0">
    <title>PQRS</title>
    <link rel= "stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel= "stylesheet" href="../css/ad_stilo.css">
  </head>
  <body>

<?php include '../compuesto/ad_cerbero.php'; 
  ?>  
<!-- Estructura de los PQRS hechos por los plebeyos -->
<section class="contacts">
<h1 class="heading">Mensajes</h1>
<div class="box-container">

   <?php
      $select_messages = $conn->prepare("SELECT * FROM `messages`");
      $select_messages->execute();
      if($select_messages->rowCount() > 0){
         while($fetch_message = $select_messages->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
   <p> id : <span><?= $fetch_message['user_id']; ?></span></p>
   <p> Nombre : <span><?= $fetch_message['name']; ?></span></p>
   <p> email : <span><?= $fetch_message['email']; ?></span></p>
   <p> Numero : <span><?= $fetch_message['number']; ?></span></p>
   <p> Mensaje : <span><?= $fetch_message['message']; ?></span></p>
   <a href="mensaje.php?delete=<?= $fetch_message['id']; ?>" onclick="return confirm('¿Eliminar mensaje?');" class="delete-btn">Eliminar</a>
   </div>
<!-- Shhhh estan callados los plebeyos -->
   <?php
         }
      }else{
         echo '<p class="empty">No hay mensajes</p>';
      }
   ?>

</div>
</section>

<!-- incluye js script corresponidente --> 
<script src="../js/ad_scrip.js"></script>
</body>
</html>

