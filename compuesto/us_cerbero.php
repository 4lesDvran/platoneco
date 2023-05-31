<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>
<!-- Encabezado de navegacion para toda la tienda -->
<header class="header">
   <section class="flex">

      <a href="home.php" class="logo">Plat<span>ON.</span></a>
<!-- Acceso al inicio, acerca de, pedidos, tienda contactenos -->
      <nav class="navbar">
         <a href="shop.php">Tienda</a>
         <a href="pedid.php">Pedidos</a>
         <a href="nos.php">Nosotros</a>
         <a href="contac.php">Contáctenos</a>
      </nav>
<!-- Uso de íconos para las herramientas de navegación y conteo de deseos y carro desde DB -->
<div class="icons">
         <?php
            $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $count_wishlist_items->execute([$user_id]);
            $total_wishlist_counts = $count_wishlist_items->rowCount();

            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_counts = $count_cart_items->rowCount();
         ?>
    <!-- Se incluyen los iconos de deseo y carrito al usuario y panel de resumen -->
      <div id="menu-btn" class="fas fa-bars"></div>
         <a href="buscar.php"><i class="fas fa-search"></i></a>
         <a href="deseo.php"><i class="fas fa-heart"></i><span>(<?= $total_wishlist_counts; ?>)</span></a>
         <a href="carro.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_counts; ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

<!-- Menu desplegable del usuario para acceder a sus credenciales referenciando a la DB-->
      <div class="profile">
         <?php           
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <!-- nombre de ussuario solo¡icitado desde la BD -->
         <p><?= $fetch_profile["name"]; ?></p>
         <a href="ax_user.php" class="btn">Actualizar perfil</a>
         <div class="flex-btn">
            <a href="us_log.php" class="option-btn">Iniciar sesión</a>
            <a href="us_regis.php" class="option-btn">Registrar</a>
         </div>
         <a href="compuesto/us_sal.php" class="delete-btn" onclick="return confirm('¿Cerrar sesión?');">Salir</a> 
         <?php
            }else{
         ?>
         <p>Inicia sesión o regístrate para realizar compras</p>
         <div class="flex-btn">
            <a href="us_log.php" class="option-btn">Iniciar sesión</a>
            <a href="us_regis.php" class="option-btn">Registrar usuario</a>
         </div>
         <?php
            }
         ?>       
      </div>
   </section>
</header>