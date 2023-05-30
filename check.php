<?php
include 'compuesto/conex.php';
/* Solicitar iniciar sesion como usuario para poder hacer compras, mensajes, lista de deseos */
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:us_log.php');
};
if(isset($_POST['order'])){
/* Verifica con la BD los pedidos para que los admins lso gestionen*/
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = 'flat no. '. $_POST['flat'] .', '. $_POST['street'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' - '. $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);
/*Confirma el pedido o  detcta que el carro está vacío */
   if($check_cart->rowCount() > 0){
      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'Exito al realizar el pedido';
   }else{
      $message[] = 'Tu carro está vacío';
   }
}
?>

<!-- Caja para comprar o checkout -->
<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Caja de compras</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/stilo.css">

</head>
<body>

<!-- Incluye encabezado para navegar por la pagina-->
<?php
    include 'compuesto/us_cerbero.php';
?>

<!-- Despliega lso pedidos que el usuario quiere hacer -->
<section class="checkout-orders">
   <form action="" method="POST">
   <h3>Pedido</h3>

      <div class="display-orders">
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
         <p> <?= $fetch_cart['name']; ?> <span>(<?= '$'.$fetch_cart['price'].'/- x '. $fetch_cart['quantity']; ?>)</span> </p>
      <?php
            }
         }else{
            echo '<p class="empty">No tienes nada en el carro</p>';
         }
      ?>
         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
         <div class="grand-total">Total : <span>$<?= $grand_total; ?>/-</span></div>
      </div>

      <h3>Digite la información para el envío</h3>
<!-- Formulario del pedido para un envio imaginario por input boxes-->
      <div class="flex">
         <div class="inputBox">
            <span>Tu nombre :</span>
            <input type="text" name="name" placeholder="" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <span>Tu número :</span>
            <input type="number" name="number" placeholder="" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
         </div>
         <div class="inputBox">
            <span>Tu email :</span>
            <input type="email" name="email" placeholder="" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Método de pago :</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">Efectivo al llegar</option>
               <option value="credit card">Tarjeta Credito</option>
               <option value="paytm">A la mano</option>
               <option value="paypal">paypal</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Barrio :</span>
            <input type="text" name="flat" placeholder="" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Dirección :</span>
            <input type="text" name="street" placeholder="" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Ciudad :</span>
            <input type="text" name="city" placeholder="" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Departamento o Estado :</span>
            <input type="text" name="state" placeholder="" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Pais :</span>
            <input type="text" name="country" placeholder="" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Código postal :</span>
            <input type="number" min="0" name="pin_code" placeholder=" " min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
         </div>
      </div>
      <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="Hacer pedido">
   </form>
</section>

<!-- incluye pie de pagina y js script corresponidente--> 
<?php
    include 'compuesto/hobbit.php';
?>  
<script src="js/scrip.js"></script>
</body>
</html>