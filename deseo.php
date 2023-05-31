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
/*Incluye la referencia para añadir o quitar articulos del deseos y carro */
include 'compuesto/deseo_carro.php';
/* Si el usuario lo solicita elimina articulo de la lista de deseaos */
if(isset($_POST['delete'])){
   $wishlist_id = $_POST['wishlist_id'];
   $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE id = ?");
   $delete_wishlist_item->execute([$wishlist_id]);
}

if(isset($_GET['delete_all'])){
   $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
   $delete_wishlist_item->execute([$user_id]);
   header('location:deseo.php');
}
?>

<!-- Lista de deseos -->
<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Articulos deseados</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/stilo.css">

</head>
<body>

<!-- Incluye encabezado para navegar por la pagina-->
<?php
    include 'compuesto/us_cerbero.php';
?>

<section class="products">
   <h3 class="heading">Tu Lista de Deseos</h3>
   <div class="box-container">
<!-- Precio total de los articulos sumando sus valores individuales-->
   <?php
      $grand_total = 0;
      $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
      $select_wishlist->execute([$user_id]);
      if($select_wishlist->rowCount() > 0){
         while($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)){
            $grand_total += $fetch_wishlist['price'];  
   ?>
<!-- Referencia lo la DB el arreglo de la lista de deseos para añadirlas o eliminarlos-->
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid']; ?>">
      <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_wishlist['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_wishlist['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_wishlist['image']; ?>">
   <!-- Esto referencia de manera local las imagenes y el metodo de vista rápida para todos los articulos, ademas del contador de cantidad de items -->
      <a href="vista.php?pid=<?= $fetch_wishlist['pid']; ?>" class="fas fa-eye"></a>
      <img src="subir_img/<?= $fetch_wishlist['image']; ?>" alt="">
      <div class="name"><?= $fetch_wishlist['name']; ?></div>
      <div class="flex">
         <div class="price">$<?= $fetch_wishlist['price']; ?>/-</div>
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <input type="submit" value="Añadir al Carro" class="btn" name="add_to_cart">
      <input type="submit" value="Quitar artículo" onclick="return confirm('¿Desea quitar este artículo?');" class="delete-btn" name="delete">
   </form>
<!-- Lista de deseos vacía --> 
   <?php
      }
   }else{
      echo '<p class="empty">No tienes artículos deseados</p>';
   }
   ?>
   </div>
<!-- Opciones de volver a la tienda os deshacer el carrito -->
   <div class="wishlist-total">
      <p>Total : <span>$<?= $grand_total; ?>/-</span></p>
      <a href="shop.php" class="option-btn">Continuar comprando</a>
      <a href="deseo.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('¿Desea quitar todos los artículo?');"> Quitar todos los artículos</a>
   </div>
</section>

<!-- incluye pie de pagina y js script corresponidente--> 
<?php
    include 'compuesto/hobbit.php';
?>  
<script src="js/scrip.js"></script>
</body>
</html>