<?php
include '../compuesto/conex.php';
session_start();
/* Redireccion a logear como admin si no tiene credenciales */
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
    header('location:ad_log.php');
 }

 /*Actualizar producto a la BD */
 if(isset($_POST['update_payment'])){
  $order_id = $_POST['order_id'];
  $payment_status = $_POST['payment_status'];
  $payment_status = filter_var($payment_status, FILTER_SANITIZE_STRING);
  $update_payment = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
  $update_payment->execute([$payment_status, $order_id]);
  $message[] = 'Estado de pago actualizado';
}

if(isset($_GET['delete'])){
  $delete_id = $_GET['delete'];
  $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
  $delete_order->execute([$delete_id]);
  header('location:orden.php');
}

?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content= "IE=edge">
    <meta name ="viewport" content = "width=device-width, initial-scale=1.0">
    <title>Ordenes Solicitadas</title>
    <link rel= "stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel= "stylesheet" href="../css/ad_stilo.css">
  </head>
  <body>

<?php include '../compuesto/ad_cerbero.php'; 
  ?>    
<!-- libertad y Ordenes pedidas por parte de los usuarios para visualizacion de un administrador-->

<section class="orders">
<h1 class="heading">Pendientes</h1>
<div class="box-container">
<!-- Recibir pendientes para despliege desde la BD -->
   <?php
      $select_orders = $conn->prepare("SELECT * FROM `orders`");
      $select_orders->execute();
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
  <!-- Esctructura de los parametros del pedido pendiente valga la redundancia -->
   <div class="box">
      <p> Fecha : <span><?= $fetch_orders['placed_on']; ?></span> </p>
      <p> Nombre : <span><?= $fetch_orders['name']; ?></span> </p>
      <p> Número : <span><?= $fetch_orders['number']; ?></span> </p>
      <p> Dirección : <span><?= $fetch_orders['address']; ?></span> </p>
      <p> Productos totales : <span><?= $fetch_orders['total_products']; ?></span> </p>
      <p> Precio total : <span>$<?= $fetch_orders['total_price']; ?>/-</span> </p>
      <p> Método de pago : <span><?= $fetch_orders['method']; ?></span> </p>
      <form action="" method="post">
         <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
         <select name="payment_status" class="select">
            <option selected disabled><?= $fetch_orders['payment_status']; ?></option>
            <option value="pending">Pendiente</option>
            <option value="completed">Completado</option>
         </select>
        <div class="flex-btn">
         <input type="submit" value="Actualizar" class="option-btn" name="update_payment">
         <a href="orden.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('¿Cancelar pedido?');">Cancelar</a>
        </div>
      </form>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">Ninguna orden pendiente aun</p>';
      }
   ?>

</div>

</section>

</section>

<!-- incluye js script corresponidente --> 
<script src="../js/ad_scrip.js"></script>
</body>
</html>

