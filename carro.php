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
/*Editar el carro para eliminar o catualizarlo y refrescar la pagina con la accion */
if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
}
if(isset($_GET['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   header('location:carro.php');
}
if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'Cantidad actualizada';
}
?>

<!-- Carro -->
<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Carrito de compras</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/stilo.css">

</head>
<body>

<!-- Incluye encabezado para navegar por la pagina-->
<?php
    include 'compuesto/us_cerbero.php';
?>
<!-- Carro de compras, botones para eliminar y modificar las compras en curso -->
<section class="products shopping-cart">

<h3 class="heading">Tu Carrito</h3>

<div class="box-container">

<?php
   $grand_total = 0;
   $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $select_cart->execute([$user_id]);
   if($select_cart->rowCount() > 0){
      while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
?>
<!-- Establecer con la BD las modificaciones que se hacen al carro con la estructura de la página -->
<form action="" method="post" class="box">
   <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
   <a href="vista.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
   <img src="subir_img/<?= $fetch_cart['image']; ?>" alt="">
   <div class="name"><?= $fetch_cart['name']; ?></div>
   <div class="flex">
      <div class="price">$<?= $fetch_cart['price']; ?>/-</div>
      <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="<?= $fetch_cart['quantity']; ?>">
      <button type="submit" class="fas fa-edit" name="update_qty"></button>
   </div>
   <div class="sub-total"> Precio del ítem: <span>$<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span> </div>
   <input type="submit" value="Quitar item" onclick="return confirm('¿Quitar del carrito?');" class="delete-btn" name="delete">
</form>
<?php
/* Sumatoria de la compra */
$grand_total += $sub_total;
   }
/* Si el carro esta vacío */
}else{
   echo '<p class="empty">Tu carro está vacío';
}
?>
<!-- Los botones de eliminar y proceder no tienen función si no hay articulos -->
</div>
<div class="cart-total">
   <p>Total de compras : <span>$<?= $grand_total; ?>/-</span></p>
   <a href="shop.php" class="option-btn">Volver a la tienda</a>
   <a href="carro.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('¿Eliminar el carrito?');">Quitar todas las compras</a>
   <a href="check.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">Proceder con la compra</a>
</div>
</section>

<!-- incluye pie de pagina y js script corresponidente--> 
<?php
    include 'compuesto/hobbit.php';
?>  
<script src="js/scrip.js"></script>
</body>
</html>