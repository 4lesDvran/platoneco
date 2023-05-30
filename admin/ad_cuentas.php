<?php
include '../compuesto/conex.php';
session_start();
/* Redireccion a logear como admin si no tiene credenciales */
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
    header('location:ad_log.php');
 }

 /*Envias solicitud de eliminar admin de la BD */

 if(isset($_GET['delete'])){
  $delete_id = $_GET['delete'];
  $delete_admins = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
  $delete_admins->execute([$delete_id]);
  header('location:ad_cuentas.php');
}
?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content= "IE=edge">
    <meta name ="viewport" content = "width=device-width, initial-scale=1.0">
    <title>Tus Colegas</title>
    <link rel= "stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel= "stylesheet" href="../css/ad_stilo.css">
  </head>
  <body>

<?php include '../compuesto/ad_cerbero.php'; 
  ?>    
<!-- Estructura de la pagina donde puedes ver amigos mas cercanos, los admins-->
<section class="accounts">

   <h1 class="heading">Tus Colegas</h1>

   <div class="box-container">

   <div class="box">
      <p>Registrar un Admin</p>
      <a href="regis.php" class="option-btn">Registrar</a>
   </div>
<!-- LLama los admins registrados en la BD -->
   <?php
      $select_accounts = $conn->prepare("SELECT * FROM `admins`");
      $select_accounts->execute();
      if($select_accounts->rowCount() > 0){
         while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
   ?>
<!-- Sólo permite cambiar las credenciales del usuario con el que entraste -->
   <div class="box">
      <p> id : <span><?= $fetch_accounts['id']; ?></span> </p>
      <p> Nombre : <span><?= $fetch_accounts['name']; ?></span> </p>
      <div class="flex-btn">
         <a href="ad_cuentas.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('¿Purgar este Admin?')" class="delete-btn">Purgar</a>
         <?php
            if($fetch_accounts['id'] == $admin_id){
               echo '<a href="ax_perfil.php" class="option-btn">Actualizar</a>';
            }
         ?>
      </div>
   </div>
<!-- Esto no deberia pasar nunca, sin gallina no hay huevos -->
   <?php
         }
      }else{
         echo '<p class="empty">No hay ninguna cuenta, IMPOSIBLE</p>';
      }
   ?>
   </div>
</section>

<!-- incluye js script corresponidente --> 
<script src="../js/ad_scrip.js"></script>
</body>
</html>