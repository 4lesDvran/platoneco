<?php
include '../compuesto/conex.php';
/* Redireccion a logear como admin si no tiene credenciales, todas la paginas del panel usan la misma estructura de redireccion, solicitud a la BD, uso de font asewome, llamado del encabezado y la estructura html */
session_start();
    $admin_id = $_SESSION['admin_id'];
    if(!isset($admin_id)){
        header('location:ad_log.php');
     }
?>

<!doctype html>
<!-- Panel del administrador, donde CRUD productos, mensajes, usuarios etc-->
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content= "IE=edge">
    <meta name ="viewport" content = "width=device-width, initial-scale=1.0">
    <title>Panel de administrador</title>
    <link rel= "stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel= "stylesheet" href="../css/ad_stilo.css">
  </head>
  <body>
<!-- Incluimos el encabezado que se va a usar en todas las areas de panel -->
<?php
    include '../compuesto/ad_cerbero.php'
?>
<!-- Organizamos las secciones del panel respecto a la bd -->
<section class = "dashboard">
<h1 class="heading">Panel Admin</h1>

<div class="box-container">

   <div class="box">
      <h3>Gestor del Sitio</h3>
      <p><?= $fetch_profile['name']; ?></p>
      <a href="ax_perfil.php" class="btn">Actualizar Perfil</a>
   </div>
<!-- Productos pendientes y su $$$ -->
   <div class="box">
      <?php
         $total_pendings = 0;
         $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
         $select_pendings->execute(['pending']);
         if($select_pendings->rowCount() > 0){
            while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
               $total_pendings += $fetch_pendings['total_price'];
            }
         }
      ?>
      <h3><span>$</span><?= $total_pendings; ?><span>/-</span></h3>
      <p>Pendiente total</p>
      <a href="orden.php" class="btn">Ver pedidos</a>
   </div>
<!-- Pedidos completados -->
   <div class="box">
      <?php
         $total_completes = 0;
         $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
         $select_completes->execute(['completed']);
         if($select_completes->rowCount() > 0){
            while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
               $total_completes += $fetch_completes['total_price'];
            }
         }
      ?>
      <h3><span>$</span><?= $total_completes; ?><span>/-</span></h3>
      <p>Pedidos completados</p>
      <a href="orden.php" class="btn">Ver pedidos</a>
   </div>
<!-- Ordenes mias -->
   <div class="box">
      <?php
         $select_orders = $conn->prepare("SELECT * FROM `orders`");
         $select_orders->execute();
         $number_of_orders = $select_orders->rowCount()
      ?>
      <h3><?= $number_of_orders; ?></h3>
      <p>Mis ordenes</p>
      <a href="orden.php" class="btn">Ver pedidos</a>
   </div>
<!-- Productos añadidos -->
   <div class="box">
      <?php
         $select_products = $conn->prepare("SELECT * FROM `products`");
         $select_products->execute();
         $number_of_products = $select_products->rowCount()
      ?>
      <h3><?= $number_of_products; ?></h3>
      <p>Productos añadidos</p>
      <a href="produc.php" class="btn">Ver productos</a>
   </div>
<!-- Usuarios registrados -->
   <div class="box">
      <?php
         $select_users = $conn->prepare("SELECT * FROM `users`");
         $select_users->execute();
         $number_of_users = $select_users->rowCount()
      ?>
      <h3><?= $number_of_users; ?></h3>
      <p>Usuarios</p>
      <a href="us_cuentas.php" class="btn">Ver usuarios</a>
   </div>
<!-- Administradores parceros -->
   <div class="box">
      <?php
         $select_admins = $conn->prepare("SELECT * FROM `admins`");
         $select_admins->execute();
         $number_of_admins = $select_admins->rowCount()
      ?>
      <h3><?= $number_of_admins; ?></h3>
      <p>Tus colegas</p>
      <a href="ad_cuentas.php" class="btn">Ver admins</a>
   </div>
<!-- PQRS -->
   <div class="box">
      <?php
         $select_messages = $conn->prepare("SELECT * FROM `messages`");
         $select_messages->execute();
         $number_of_messages = $select_messages->rowCount()
      ?>
      <h3><?= $number_of_messages; ?></h3>
      <p>Mensajes</p>
      <a href="mensaje.php" class="btn">PQRS</a>
   </div>

</div>

</section>

<!-- incluye js script corresponidente para menus despleglables--> 
<script src="../js/ad_scrip.js"></script>
</body>
</html>


