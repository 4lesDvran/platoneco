<?php
include 'compuesto/conex.php';
/* Solicitar iniciar sesion como usuario para poder hacer compras, mensajes, lista de deseos */
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};
include 'compuesto/deseo_carro.php';
?>

<!-- Vista rapida -->
<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Vista rapida</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/stilo.css">

</head>
<body>

<!-- Incluye encabezado para navegar por la pagina-->
<?php
    include 'compuesto/us_cerbero.php';
?>

<section class="quick-view">
   <h1 class="heading">Vista rápida</h1>
   <?php
     $pid = $_GET['pid'];
     $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?"); 
     $select_products->execute([$pid]);
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <div class="row">
         <div class="image-container">
            <div class="main-image">
               <img src="subir_img/<?= $fetch_product['image_01']; ?>" alt="">
            </div>
            <div class="sub-image">
               <img src="subir_img/<?= $fetch_product['image_01']; ?>" alt="">
               <img src="subir_img/<?= $fetch_product['image_02']; ?>" alt="">
               <img src="subir_img/<?= $fetch_product['image_03']; ?>" alt="">
            </div>
         </div>
         <div class="content">
            <div class="name"><?= $fetch_product['name']; ?></div>
            <div class="flex">
               <div class="price"><span>$</span><?= $fetch_product['price']; ?><span>/-</span></div>
               <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
            </div>
            <div class="details"><?= $fetch_product['details']; ?></div>
            <div class="flex-btn">
               <input type="submit" value="Añadir al carro" class="btn" name="add_to_cart">
               <input class="option-btn" type="submit" name="add_to_wishlist" value="Añadir a lista de deseos">
            </div>
         </div>
      </div>
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">No se han añadido productos</p>';
   }
   ?>
</section>

<!-- incluye pie de pagina y js script corresponidente--> 
<?php
    include 'compuesto/hobbit.php';
?>  
<script src="js/scrip.js"></script>
</body>
</html>