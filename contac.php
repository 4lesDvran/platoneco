<?php

include 'compuesto/conex.php';
/* Solicitar iniciar sesion como usuario para poder hacer compras, mensajes, lista de deseos */
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};
if(isset($_POST['send'])){
/* A traves de la BD verifica mensajes enviados para poder enviar un mensaje */
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);
   if($select_message->rowCount() > 0){
      $message[] = 'Ya envio una opinión o solicitud, paciencia para la respuesta';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);

      $message[] = 'Gracias por su opinión';

   }
}
?>

<!-- Contactarse, basicamente un formulario para enviar un mensaje al panel de admin -->
<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contactar un Admin</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/stilo.css">

</head>
<body>

<!-- Incluye encabezado para navegar por la pagina-->
<?php
    include 'compuesto/us_cerbero.php';
?>

<section class="contact">
<form action="" method="post">
   <h3>Envianos tu opinión</h3>
   <input type="text" name="name" placeholder="Tu nombre" required maxlength="20" class="box">
   <input type="email" name="email" placeholder="Tu correo electónico" required maxlength="50" class="box">
   <input type="number" name="number" min="0" max="9999999999" placeholder="Tu numero tel" required onkeypress="if(this.value.length == 10) return false;" class="box">
   <textarea name="msg" class="box" placeholder="Escriba su mensaje" cols="30" rows="10"></textarea>
   <input type="submit" value="Enviar" name="send" class="btn">
</form>

<!-- incluye pie de pagina y js script corresponidente--> 
<?php
    include 'compuesto/hobbit.php';
?>  
<script src="js/scrip.js"></script>
</body>
</html>