// Funciones para el botón de Login y register. Estos al llamarlos mostrarán la ventana flotante de cada una.
function mostrarLogin() {
  document.getElementById("loginwindow").style.display = "flex";
  document.getElementById("principal").classList.add("blur-effect");
}

function cerrarLogin() {
  document.getElementById("loginwindow").style.display = "none";
  document.getElementById("principal").classList.remove("blur-effect");
}


function mostrarRegister() {
  document.getElementById("loginwindow").style.display = "flex";
  document.getElementById("principal").classList.add("blur-effect");
}

function cerrarLogin() {
  document.getElementById("loginwindow").style.display = "none";
  document.getElementById("principal").classList.remove("blur-effect");
}