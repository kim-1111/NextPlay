/*  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="include.js"></script>
    <link rel="stylesheet" href="layout.css"> */




$(document).ready(function(){
  $("#navbar").load("navbar.html", function(response, status, xhr) {
      if (status == "error") {
          console.error("Error al cargar:", xhr.status, xhr.statusText);
      } else {
          console.log("layout.html cargado correctamente.");
      }
  });
});




$(document).ready(function(){
  $("#footer").load("footer.html", function(response, status, xhr) {
      if (status == "error") {
          console.error("Error al cargar:", xhr.status, xhr.statusText);
      } else {
          console.log("layout.html cargado correctamente.");
      }
  });
});