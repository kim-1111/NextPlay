<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NextPlay</title>

  <!-- Ícono de la página -->
  <link rel="icon" href="../imagenes/logo.png">

  <!-- Fuentes personalizadas -->
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Press+Start+2P&display=swap"
    rel="stylesheet">

  <!-- LAYOUT -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../Layout/include.js"></script>
  <link rel="stylesheet" href="../Layout/layout.css">
  <link rel="stylesheet" href="../CSS/perfil.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <?php session_start(); ?>
  <!-- Encabezado con barra de navegación -->
  <header>
    <div id="navbar"></div>
  </header>

  <main>
    <div class="container">
      <div class="row">
        <div class="col-sm-4 profile-sidebar">
          <div class="text-center">
            <?php
            $username = $_SESSION['user']['nombre'];
            $imagePath = "../users/profileimg/" . $username . ".jpg";
            if (file_exists($imagePath)) {
              $avatarSrc = $imagePath;
            } else {
              $avatarSrc = "http://ssl.gstatic.com/accounts/ui/avatar_2x.png";
            }
            ?>
            <div class="text-center mt-4">
              <!-- Imagen de perfil -->
              <img src="<?= $avatarSrc ?>" id="profile-image" class="rounded-circle img-thumbnail" alt="avatar"
                width="150" height="150" style="cursor: pointer;">

              <h6 class="mt-3">Click to change the photo...</h6>

              <!-- Formulario de carga de imagen -->
              <form id="upload-form" enctype="multipart/form-data">
                <div class="mb-3">
                  <!-- Input de archivo oculto -->
                  <input type="file" id="file-upload" name="profile_image" class="d-none"
                    onchange="previewAndSubmit(event)">
                </div>
              </form>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
            <script>
              const profileImage = document.getElementById('profile-image');
              const fileInput = document.getElementById('file-upload');
              const uploadForm = document.getElementById('upload-form');

              // Hacer clic en la imagen para activar el selector de archivos
              profileImage.addEventListener('click', () => {
                fileInput.click(); // Activar el selector de archivos
              });

              // Previsualizar la imagen seleccionada antes de cargarla
              function previewAndSubmit(event) {
                const file = event.target.files[0];
                if (file) {
                  const reader = new FileReader();
                  reader.onload = function(e) {
                    profileImage.src = e.target.result; // Actualizar la imagen de perfil
                  };
                  reader.readAsDataURL(file);

                  // Crear un objeto FormData para enviar el archivo
                  const formData = new FormData();
                  formData.append("profile_image", file);

                  // Enviar la imagen mediante AJAX
                  $.ajax({
                    url: '/dam1/NextPlay/php/uploadpicture.php', // Ruta a tu script PHP
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                      const data = JSON.parse(response);
                      if (data.status === "success") {
                        // Mostrar mensaje de éxito (puedes manejarlo según tu preferencia)
                        alert(data.message);
                      } else {
                        // Mostrar mensaje de error
                        alert(data.message);
                      }
                    },
                    error: function() {
                      alert("Error en la subida de la imagen.");
                    }
                  });
                }
              }
            </script>


          </div>
          <hr><br>
          <ul class="list-group">
            <li class="list-group-item text-muted">Activity<i class="fa fa-dashboard fa-1x"></i></li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Interested events:</strong></span> 0
          </ul>
        </div>
        <div class="col-sm-8 profile-content">
          <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Profile</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="home">
              <hr>
              <form class="form profile-form" action="../php/controller.php" method="POST" id="registrationForm">
                <div class="form-group">
                  <div class="col-xs-12">
                    <label for="nombre">
                      <h4>Name</h4>
                    </label>
                    <input type="text" class="form-control" name="nombre" id="nombre"
                      placeholder="<?php echo $_SESSION['user']['nombre']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-xs-12">
                    <label for="teléfono">
                      <h4>Phone</h4>
                    </label>
                    <input type="text" class="form-control" name="teléfono" id="teléfono" placeholder="teléfono">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-xs-12">
                    <label for="email">
                      <h4>Email</h4>
                    </label>
                    <input type="email" class="form-control" name="email" id="email"
                      placeholder="<?php echo $_SESSION['user']['email']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-xs-12">
                    <label for="password">
                      <h4>Password</h4>
                    </label>
                    <input type="password" class="form-control" name="password" id="password"
                      placeholder="<?php echo $_SESSION['user']['contrasena']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-xs-12">
                    <label for="password2">
                      <h4>Check the password</h4>
                    </label>
                    <input type="password" class="form-control" name="password2" id="password2" placeholder="password2">
                  </div>
                </div>
                <div class="form-group profile-buttons">
                  <div class="col-xs-12">
                    <br>
                    <button class="save" type="submit">Save</button>
                    <button class="reset" type="reset">Limpiar</button>
                    <button name="logout" type="submit">Logout</button>
              </form>
            </div>
          </div>

          </form>
          <hr>
        </div>
      </div>
    </div>
    
  </main>
  <!-- Pie de página -->
  <div id="footer"></div>

</body>

</html>