<?php
include '../compuesto/conex.php';
/* Inicio de session buscando desde los arreglos de la BD */
session_start();

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_admin = $conn -> prepare("SELECT * FROM `admins` WHERE name = ? AND password = ?");
   $select_admin->execute([$name, $pass]);
   $row = $select_admin->fetch(PDO::FETCH_ASSOC);

   if($select_admin->rowCount() > 0){
      $_SESSION['admin_id'] = $row['id'];
      header('location:dashboard.php');
   }else{
      $message[] = 'Contraseña incorrecta';
   }
}
?>

<!doctype html>
<!-- Pagina de acceso al admin, usa font-asewome y css personalizada para administrador-->
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content= "IE=edge">
    <meta name ="viewport" content = "width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link rel= "stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel= "stylesheet" href="../css/ad_stilo.css">
  </head>
  <body>

<?php
/*Mensaje de PHP de error*/
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
  
<!-- formulario de acceso al admin-->
<section class="form-container">

   <form action="" method="post">
      <h2>Iniciar sesión</h2>
      <input type="text" name="name" required placeholder="Introduzca su nombre" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="Introduzca su contraseña" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Acceder" class="btn" name="submit">
   </form>

</section>
</body>
</html>