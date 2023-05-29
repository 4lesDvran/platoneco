<?php
include '../compuesto/conex.php';

session_start();
/* Redireccion a logear como admin si no tiene credenciales */
    $admin_id = $_SESSION['admin_id'];
    if(!isset($admin_id)){
        header('location:ad_log.php');
     }
/* Confirmar credenciales para nuevo administrador a la DB, con verificacion de contraseña cpass y usuario*/
if(isset($_POST['submit'])){

  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_STRING);
  $pass = sha1($_POST['pass']);
  $pass = filter_var($pass, FILTER_SANITIZE_STRING);
  $cpass = sha1($_POST['cpass']);
  $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

  $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ?");
  $select_admin->execute([$name]);

  if($select_admin->rowCount() > 0){
     $message[] = 'Usuario ya existe';
  }else{
     if($pass != $cpass){
        $message[] = 'Contraseñas no coincided';
     }else{
        $insert_admin = $conn->prepare("INSERT INTO `admins`(name, password) VALUES(?,?)");
        $insert_admin->execute([$name, $cpass]);
        $message[] = 'Nuevo administrador es bienvenido';
     }
  }

}
?>

<!doctype html>
<!-- Registrar mas administradores desde el Panel del administrador-->
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content= "IE=edge">
    <meta name ="viewport" content = "width=device-width, initial-scale=1.0">
    <title>Registrar Admin</title>
    <link rel= "stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel= "stylesheet" href="../css/ad_stilo.css">
  </head>
  <body>

<?php
    include '../compuesto/ad_cerbero.php' ?>
<section class = "form-container">     
<!-- Registro de un administrador -->
   <form action="" method="post">
      <h3>Registre admin</h3>
      <input type="text" name="name" required placeholder="Introduzca el nombre" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="Introduzca la contraseña" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="Confirme la contraseña" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Registrar" class="btn" name="submit">
   </form>

</section>

<!-- incluye js script corresponidente --> 
<script src="../js/ad_scrip.js"></script>
</body>
</html>

