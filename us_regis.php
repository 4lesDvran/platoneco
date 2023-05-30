<?php
include 'compuesto/conex.php';
/* Solicitar iniciar sesion como usuario para poder hacer compras, mensajes, lista de deseos */
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};
/*Añadir info suministrada a la BD para crear un nuevo usuario */
if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email,]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);
/*Verificar que no tenga credenciales similares a otro usuario y que las contraseñas coincidad */
   if($select_user->rowCount() > 0){
      $message[] = 'El email es ocupado por otra cuenta';
   }else{
      if($pass != $cpass){
         $message[] = 'Las contraseñas no coincided';
   /*Concede usaurio si cumple con los requisitos */
      }else{
         $insert_user = $conn->prepare("INSERT INTO `users`(name, email, password) VALUES(?,?,?)");
         $insert_user->execute([$name, $email, $cpass]);
         $message[] = 'Exito en el registro, ya puedes iniciar sesión';
      }
   }
}
?>
<!-- Registrar usuario -->
<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Regístrate</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/stilo.css">

</head>
<body>

<!-- Incluye encabezado para navegar por la pagina-->
<?php
    include 'compuesto/us_cerbero.php';
?>
<!-- Estructura del formulario para registrar el usuario, todo es requerido para crear un usuario-->
<section class="form-container">

   <form action="" method="post">
      <h3>Regístrate Ahora</h3>
      <input type="text" name="name" required placeholder="Digite su nombre" maxlength="20"  class="box">
      <input type="email" name="email" required placeholder="Digite su email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="Digite su contraseña" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="Confirme su contraseña" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Registrar ahora" class="btn" name="submit">
   <!-- si ya tiene una cuenta lo invita a iniciar sesión -->
      <p>¿Ya tienes una cuenta?</p>
      <a href="us_log.php" class="option-btn">Inicie sesión</a>
   </form>
</section>

<!-- incluye pie de pagina y js script corresponidente--> 
<?php
    include 'compuesto/hobbit.php';
?>  
<script src="js/scrip.js"></script>
</body>
</html>