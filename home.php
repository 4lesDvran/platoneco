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

<!-- Pagina principal -->
<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Inicio - PlataON.</title>
   <!-- link de referenica para las slides -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/stilo.css">

</head>
<body>
<!-- Incluye encabezado para todo el sitio -->
<?php
    include 'compuesto/us_cerbero.php';
?>

<div class="home-bg">
<section class="home">
   <!-- Se utiliza el swiper como se refiere en el link para el funcionamiento de pasar imagenes -->
   <div class="swiper home-slider">
   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
         <div class="image">
            <img src="img/home1.jpg" alt="">
         </div>
         <div class="content">
            <span>Descuentos del 50%</span>
            <h3>Y 100% Natural</h3>
            <a href="shop.php" class="btn">Comprar ahora</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="img/home2.jpg" alt="">
         </div>
         <div class="content">
            <span>Sembrando un mejor futuro</span>
            <h3>¿Ya estas registrado?</h3>
            <a href="us_log.php" class="btn">Bienvenido</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="img/home3.jpg" alt="">
         </div>
         <div class="content">
            <span>Sé uno más!</span>
            <h3>Registrate para comprar</h3>
            <a href="us_regis.php" class="btn">Únete</a>
         </div>
      </div>

   </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

</div>

<!-- incluye pie de pagina y js script corresponidente--> 
<?php
    include 'compuesto/hobbit.php';
?>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="js/scrip.js"></script>
<!-- Código para el funcionamiento del el slide de las imágenes, que el cursos las arrastre -->
<script>
var swiper = new Swiper(".home-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
    },
});
 var swiper = new Swiper(".category-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
         slidesPerView: 2,
       },
      650: {
        slidesPerView: 3,
      },
      768: {
        slidesPerView: 4,
      },
      1024: {
        slidesPerView: 5,
      },
   },
});
var swiper = new Swiper(".products-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      550: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>