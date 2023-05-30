<?php
include 'compuesto/conex.php';
/* Solicitar iniciar sesion como usuario para poder hacer compras, mensajes, lista de deseos */
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};
?>

<!-- Pedidos -->
<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Pedidos</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/stilo.css">

</head>
<body>

<!-- Incluye encabezado para navegar por la pagina-->
<?php
    include 'compuesto/us_cerbero.php';
?>

<section class="orders">

   <h1 class="heading">Tus pedidos</h1>

   <div class="box-container">
<!-- despliega los pedidos desde la Db al usuario correspondiente -->
   <?php
      if($user_id == ''){
         echo '<p class="empty">Inicia sesón para ver tus pedidos</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
<!-- Estructura de los pedidos reailzados por el usuario, su estado lo gestiona un admin -->
   <div class="box">
      <p>Fecha : <span><?= $fetch_orders['placed_on']; ?></span></p>
      <p>Nombre : <span><?= $fetch_orders['name']; ?></span></p>
      <p>email : <span><?= $fetch_orders['email']; ?></span></p>
      <p>Número : <span><?= $fetch_orders['number']; ?></span></p>
      <p>Dirección : <span><?= $fetch_orders['address']; ?></span></p>
      <p>Método de pago : <span><?= $fetch_orders['method']; ?></span></p>
      <p>Pedido : <span><?= $fetch_orders['total_products']; ?></span></p>
      <p>Precio total : <span>$<?= $fetch_orders['total_price']; ?>/-</span></p>
      <p> Estado : <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
   </div>
   <?php
      }
/* Si no se ha realizado ni un solo pedido */
      }else{
         echo '<p class="empty">No has hecho ningun pedido</p>';
      }
      }
   ?>
   </div>
</section>

<!-- incluye pie de pagina y js script corresponidente--> 
<?php
    include 'compuesto/hobbit.php';
?>  
<script src="js/scrip.js"></script>
</body>
</html>