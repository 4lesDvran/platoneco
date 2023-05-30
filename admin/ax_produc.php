<?php
include '../compuesto/conex.php';
session_start();
/* Redireccion a logear como admin si no tiene credenciales */
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
    header('location:ad_log.php');
 }

 /*Actualizar producto a la BD */
 if(isset($_POST['update'])){

  $pid = $_POST['pid'];
  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_STRING);
  $price = $_POST['price'];
  $price = filter_var($price, FILTER_SANITIZE_STRING);
  $details = $_POST['details'];
  $details = filter_var($details, FILTER_SANITIZE_STRING);

  $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, details = ? WHERE id = ?");
  $update_product->execute([$name, $price, $details, $pid]);

  $message[] = 'Exito al actualizar el producto';
/*Actualizar la primer imagen */
  $old_image_01 = $_POST['old_image_01'];
  $image_01 = $_FILES['image_01']['name'];
  $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
  $image_size_01 = $_FILES['image_01']['size'];
  $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
  $image_folder_01 = '../subir_img/'.$image_01;

  if(!empty($image_01)){
     if($image_size_01 > 2000000){
        $message[] = 'La imagen es demasiado grande';
     }else{
        $update_image_01 = $conn->prepare("UPDATE `products` SET image_01 = ? WHERE id = ?");
        $update_image_01->execute([$image_01, $pid]);
        move_uploaded_file($image_tmp_name_01, $image_folder_01);
        unlink('../subir_img/'.$old_image_01);
        $message[] = 'La primera imagen se actualizo con exito';
     }
  }
/*Actualizar la segunda imagen */
  $old_image_02 = $_POST['old_image_02'];
  $image_02 = $_FILES['image_02']['name'];
  $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
  $image_size_02 = $_FILES['image_02']['size'];
  $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
  $image_folder_02 = '../subir_img/'.$image_02;

  if(!empty($image_02)){
     if($image_size_02 > 2000000){
        $message[] = 'La imagen es demasiado grande';
     }else{
        $update_image_02 = $conn->prepare("UPDATE `products` SET image_02 = ? WHERE id = ?");
        $update_image_02->execute([$image_02, $pid]);
        move_uploaded_file($image_tmp_name_02, $image_folder_02);
        unlink('../subir_img/'.$old_image_02);
        $message[] = 'La segunda imagen se actualizo con exito';
     }
  }
/*Actualizar la tercera imagen */
  $old_image_03 = $_POST['old_image_03'];
  $image_03 = $_FILES['image_03']['name'];
  $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
  $image_size_03 = $_FILES['image_03']['size'];
  $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
  $image_folder_03 = '../subir_img/'.$image_03;

  if(!empty($image_03)){
     if($image_size_03 > 2000000){
        $message[] = 'La imagen es demasiado grande';
     }else{
        $update_image_03 = $conn->prepare("UPDATE `products` SET image_03 = ? WHERE id = ?");
        $update_image_03->execute([$image_03, $pid]);
        move_uploaded_file($image_tmp_name_03, $image_folder_03);
        unlink('../subir_img/'.$old_image_03);
        $message[] = 'La tercera imagen se actualizo con exito';
     }
  }

}

?>

<!doctype html>

<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content= "IE=edge">
    <meta name ="viewport" content = "width=device-width, initial-scale=1.0">
    <title>Actualizar Productos</title>
    <link rel= "stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel= "stylesheet" href="../css/ad_stilo.css">
  </head>
  <body>

<?php include '../compuesto/ad_cerbero.php'; 
  ?>
<!-- Esctrucutra de como actualizar los parametros de un producto-->
<section class="update-product">

   <h1 class="heading">Actualizar Producto</h1>
<!-- Encontrar producto en la BD -->
   <?php
      $update_id = $_GET['update'];
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_products->execute([$update_id]);
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
  
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="old_image_01" value="<?= $fetch_products['image_01']; ?>">
      <input type="hidden" name="old_image_02" value="<?= $fetch_products['image_02']; ?>">
      <input type="hidden" name="old_image_03" value="<?= $fetch_products['image_03']; ?>">
      <div class="image-container">
         <div class="main-image">
            <img src="../subir_img/<?= $fetch_products['image_01']; ?>" alt="">
         </div>
        <!-- Subir imagenes a la carpeta -->
         <div class="sub-image">
            <img src="../subir_img/<?= $fetch_products['image_01']; ?>" alt="">
            <img src="../subir_img/<?= $fetch_products['image_02']; ?>" alt="">
            <img src="../subir_img/<?= $fetch_products['image_03']; ?>" alt="">
         </div>
      </div>
    <!-- Actualizar cada parametro del producto -->
      <span>Actualizar nombre</span>
      <input type="text" name="name" required class="box" maxlength="100" placeholder="Cambie el nombre" value="<?= $fetch_products['name']; ?>">
      <span>Actualizar precio</span>
      <input type="number" name="price" required class="box" min="0" max="9999999999" placeholder="Cambie el precio del producto" onkeypress="if(this.value.length == 10) return false;" value="<?= $fetch_products['price']; ?>">
      <span>Actualizar detalles</span>
      <textarea name="details" class="box" required cols="30" rows="10"><?= $fetch_products['details']; ?></textarea>
      <span>Actualizar 1ra imagen</span>
      <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      <span>Actualizar 2da imagen</span>
      <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      <span>Actualizar 3ra imagen</span>
      <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      <div class="flex-btn">
         <input type="submit" name="update" class="btn" value="Hecho">
         <a href="produc.php" class="option-btn">Cancelar</a>
      </div>
   </form>
   
   <?php
         }
      }else{
         echo '<p class="empty">No se encontró el producto</p>';
      }
   ?>

</section>

<!-- incluye js script corresponidente --> 
<script src="../js/ad_scrip.js"></script>
</body>
</html>

