<?php
/*Mensaje PHP de error*/
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

<header class="header">
    <section class = "flex">
        <a href = "../admin/dashboard.php" class = "logo">Panel<span>Administador</span></a>
    <!--Navegacion del panel -->
    <nav class="navbar">
         <a href="../admin/dashboard.php">Inicio</a>
         <a href="../admin/produc.php">Productos</a>
         <a href="../admin/orden.php">Pedidos</a>
         <a href="../admin/ad_cuentas">Administradores</a>
         <a href="../admin/us_cuentas.php">Usuarios</a>
         <a href="../admin/mensaje.php">Mensajes</a>
      </nav>
    <!-- iconos de navegacion-->
      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>
    <!-- Corresponder el administrador con su perfil -->
      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
        <p><?= $fetch_profile['name']; ?></p>
        <!-- Opciones respecto al perfil -->
        <a href="../admin/ax_perfil.php" class="btn">Actualizar perfil</a>
         <div class="flex-btn">
            <a href="../admin/regis.php" class="option-btn">Resgistrar</a>
            <a href="../admin/ad_log.php" class="option-btn">Iniciar sesión</a>
         </div>
         <a href="../compuesto/ad_sal.php" class="delete-btn" onclick="return confirm('¿Salir del sitio?');">Salir</a> 
      </div>
      </div>
   </section>
</header>