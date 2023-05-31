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

<!-- Acerca de nosotros -->
<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Nosotros</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/stilo.css">

</head>
<body>

<!-- Incluye encabezado para navegar por la pagina-->
<?php
    include 'compuesto/us_cerbero.php';
?>

<section class="about">

<div class="row">
   <div class="image">
      <img src="img/nostra.jpg" alt="">
   </div>

   <div class="content">
      <h3>¿Quíenes somos?</h3>
      <p>PlatOn, somos una empresa dedicada al el medio ambiente, comprometidos con nuestros clientes al ofrecer productos biodegradables para que saborees tus deliciosas comidas más ecológicamente </p>
      <a href="contac.php" class="btn">Conecta con nosotros</a>
   </div>
</div>
</section>

<!-- incluye pie de pagina y js script corresponidente--> 
<?php
    include 'compuesto/hobbit.php';
?>  
<script src="js/scrip.js"></script>
</body>
</html>
