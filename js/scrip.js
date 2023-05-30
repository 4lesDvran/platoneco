//Desplegar paneles de admin-cerbero cuando se hace click en el icono
let profile = document.querySelector('.header .flex .profile');
document.querySelector('#user-btn').onclick = () => {
    profile.classList.toggle('active');
    navbar.classList.remove('active');
}

let navbar = document.querySelector('.header .flex .navbar');
document.querySelector('#menu-btn').onclick = () => {
    navbar.classList.toggle('active');
    profile.classList.remove('active');
}

//Impedir que se sobrepongan los menus desplegables
window.onscroll = () => {
    profile.classList.remove('active');
    navbar.classList.remove('active');
}
//Selector de diferentes imagenes en un mismo plano, por click cambia de imagen
let mainImage = document.querySelector('.quick-view .box .row .image-container .main-image img');
let subImages = document.querySelectorAll('.quick-view .box .row .image-container .sub-image img');

subImages.forEach(images =>{
   images.onclick = () =>{
      src = images.getAttribute('src');
      mainImage.src = src;
   }
});