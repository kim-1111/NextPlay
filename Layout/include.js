/*

Script que permite insertar codigos HTML solo poniendo un div. 
Para usarlo habrás de poner las siguientes lineas en el header de cada HTML para poder incluir el layout.

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="include.js"></script>
    <link rel="stylesheet" href="layout.css">
    
Cuando se haya importado, lo unico que faltará será crear un div con una id específica.#footer

<div id="navbar"></div> Para insertar el navbar.
<div id="footer"></div> Para insertar el footer.    
<div id="login"></div> Para insertar la ventana flotante del login.    
<div id="register"></div> Para insertar la ventana flotante del register. 

Este script detectará automáticamente divs con estas ids específicas e insertará codigo HTML dentro de ellas.


*/





/*INCLUDE NAVBAR*/

$(document).ready(function () {
  $("#navbar").load("/dam1/NextPlay/Layout/navbar.php", function (response, status, xhr) {
    if (status == "error") {
      console.error("Error al cargar navbar:", xhr.status, xhr.statusText);
    } else {
      console.log("layout.html cargado correctamente.");
    }
  });
});


/*INCLUDE FOOTER*/

$(document).ready(function () {
  $("#footer").load("/dam1/NextPlay/Layout/footer.html", function (response, status, xhr) {
    if (status == "error") {
      console.error("Error al cargar footer:", xhr.status, xhr.statusText);
    } else {
      console.log("layout.html cargado correctamente.");
    }
  });
});


/*INCLUDE LOGIN WINDOW*/

$(document).ready(function () {
  $("#loginwindow").load("/dam1/NextPlay/HTML/registerloginwindows/login.html", function (response, status, xhr) {
    if (status == "error") {
      console.error("Error al cargar login:", xhr.status, xhr.statusText);
    } else {
      console.log("layout.html cargado correctamente.");
    }
  });
});

/*INCLUDE REGISTER WINDOW*/

$(document).ready(function () {
  $("#registerwindow").load("/dam1/NextPlay/HTML/registerloginwindows/register.html", function (response, status, xhr) {
    if (status == "error") {
      console.error("Error al cargar register:", xhr.status, xhr.statusText);
    } else {
      console.log("layout.html cargado correctamente.");
    }
  });
});
