<?php
include '../compuesto/conex.php';
session_start();
/* Redireccion a logear como admin si no tiene credenciales */
    $admin_id = $_SESSION['admin_id'];
    if(!isset($admin_id)){
        header('location:ad_log.php');
     }
/*Confirmar con la BD el cambio de credenciales del administrador */
if(isset($_POST['submit'])){

  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_STRING);

  $update_profile_name = $conn->prepare("UPDATE `admins` SET name = ? WHERE id = ?");
  $update_profile_name->execute([$name, $admin_id]);

  $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
  $prev_pass = $_POST['prev_pass'];
  $old_pass = sha1($_POST['old_pass']);
  $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
  $new_pass = sha1($_POST['new_pass']);
  $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
  $confirm_pass = sha1($_POST['confirm_pass']);
  $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);
/*Verificar que sepa su contraseña y que introduzca una nueva contraseña, No dejar que ponga una contraseña vacia  */
  if($old_pass == $empty_pass){
     $message[] = 'Introduzca su antigua contraseña';
  }else
  if($old_pass != $prev_pass){
     $message[] = 'Introduzca su antigua contraseña';
  }else
  if($new_pass != $confirm_pass){
     $message[] = 'Las contraseñas no coincided';
  }else{
     if($new_pass != $empty_pass){
        $update_admin_pass = $conn->prepare("UPDATE `admins` SET password = ? WHERE id = ?");
        $update_admin_pass->execute([$confirm_pass, $admin_id]);
        $message[] = 'Exito al actualizar su contraseña';
     }else{
        $message[] = 'Por favor introdiuzca una contraseña nueva';
     }
  }
}
?>
<!-- Actualizar credenciales del administrador -->
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content= "IE=edge">
    <meta name ="viewport" content = "width=device-width, initial-scale=1.0">
    <title>Actualizar Perfil</title>
    <link rel= "stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel= "stylesheet" href="../css/ad_stilo.css">
  </head>
  <body>
  <?php
    include '../compuesto/ad_cerbero.php' ?>

<!-- Estructura actualizar credenciales de dministrador desde Panel de Admin, el nombre se escribe automaticamente-->
<section class="form-container">

   <form action="" method="post">
      <h3>update profile</h3>
      <input type="hidden" name="prev_pass" value="<?= $fetch_profile['password']; ?>">
      <input type="text" name="name" value="<?= $fetch_profile['name']; ?>" required placeholder="Digite su nombre" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="old_pass" placeholder="Digite su contraseña vieja" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" placeholder="Digite su nueva contraseña" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="confirm_pass" placeholder="Confirme su nueva contraseña" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Actualizar" class="btn" name="submit">
   </form>

</section>

<!-- incluye js script corresponidente --> 
<script src="../js/ad_scrip.js"></script>
</body>
</html>

