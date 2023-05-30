<?php
include '../compuesto/conex.php';
session_start();
/* Redireccion a logear como admin si no tiene credenciales */
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
    header('location:ad_log.php');
 }

 /*Envias solicitud de eliminar tus amigos mas leganos de la DB, los usuarios*/

 if(isset($_GET['delete'])){
  $delete_id = $_GET['delete'];
  $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
  $delete_user->execute([$delete_id]);
  $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
  $delete_orders->execute([$delete_id]);
  $delete_messages = $conn->prepare("DELETE FROM `messages` WHERE user_id = ?");
  $delete_messages->execute([$delete_id]);
  $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
  $delete_cart->execute([$delete_id]);
  $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
  $delete_wishlist->execute([$delete_id]);
  header('location:us_cuentas.php');
}
?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content= "IE=edge">
    <meta name ="viewport" content = "width=device-width, initial-scale=1.0">
    <title>Gallinas poniendo huevos de oro</title>
    <link rel= "stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel= "stylesheet" href="../css/ad_stilo.css">
  </head>
  <body>

<?php include '../compuesto/ad_cerbero.php'; 
  ?>    
<!-- Estructura de la pagina donde puedes espiar usuarios como PATRIOT-->
<section class="accounts">

   <h1 class="heading">Cuentas de usuarios</h1>

   <div class="box-container">
<!-- Solicita los usuarios registrados a la DB -->
   <?php
      $select_accounts = $conn->prepare("SELECT * FROM `users`");
      $select_accounts->execute();
      if($select_accounts->rowCount() > 0){
         while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
   ?>
<!-- Cuadro de cada usuario, eliminar un usuario conlleva eliminar sus actividades -->
   <div class="box">
      <p> id : <span><?= $fetch_accounts['id']; ?></span> </p>
      <p> Nombre : <span><?= $fetch_accounts['name']; ?></span> </p>
      <p> email : <span><?= $fetch_accounts['email']; ?></span> </p>
      <a href="us_cuentas.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('¿Eliminar usuario y toda su información relacionada?')" class="delete-btn">Eliminar</a>
   </div>
<!-- Por lo menos no tenemos que vender data a otras empresas  -->
   <?php
         }
      }else{
         echo '<p class="empty">Estamos en banca rota</p>';
      }
   ?>

   </div>

</section>

<!-- incluye js script corresponidente --> 
<script src="../js/ad_scrip.js"></script>
</body>
</html>