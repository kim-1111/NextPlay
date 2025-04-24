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

</head>

<body>
  <?php session_start();?>
  <!-- Encabezado con barra de navegación -->
  <header>
    <div id="navbar"></div>
  </header>
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


echo "<script>console.log('Avatar src: " . $avatarSrc . "');</script>";
?>

<img src="<?= $avatarSrc ?>" class="avatar img-circle img-thumbnail" alt="avatar">
          <h6>Upload a different photo...</h6>
          <form action="/dam1/NextPlay/php/uploadpicture.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="profile_image" class="text-center center-block file-upload">
            <button type="submit" name="submit">Upload Image</button>
          </form>
        </div>
        <hr><br>
        <div class="panel panel-default profile-panel">
          <div class="panel-heading">Sitio Web <i class="fa fa-link fa-1x"></i></div>
          <div class="panel-body"><a href="https://github.com/kim-1111/NextPlay">github.com/kim-1111/NextPlay</a></div>
        </div>
        <ul class="list-group">
          <li class="list-group-item text-muted">Actividad <i class="fa fa-dashboard fa-1x"></i></li>
          <li class="list-group-item text-right"><span class="pull-left"><strong>Eventos interesados:</strong></span> 0
          </li>
          <li class="list-group-item text-right"><span class="pull-left"><strong>Likes</strong></span> 13</li>
          <li class="list-group-item text-right"><span class="pull-left"><strong>Posts</strong></span> 37</li>
          <li class="list-group-item text-right"><span class="pull-left"><strong>Followers</strong></span> 78
          </li>
        </ul>
      </div>
      <div class="col-sm-8 profile-content">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#home">Perfil</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="home">
            <hr>
            <form class="form profile-form" action="../php/controller.php" method="POST" id="registrationForm">
              <div class="form-group">
                <div class="col-xs-12">
                  <label for="nombre">
                    <h4>Nombre</h4>
                  </label>
                  <input type="text" class="form-control" name="nombre" id="nombre" placeholder="<?php echo $_SESSION['user']['nombre']; ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-12">
                  <label for="teléfono">
                    <h4>Teléfono</h4>
                  </label>
                  <input type="text" class="form-control" name="teléfono" id="teléfono" placeholder="teléfono">
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-12">
                  <label for="email">
                    <h4>Email</h4>
                  </label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="<?php echo $_SESSION['user']['email']; ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-12">
                  <label for="password">
                    <h4>Contraseña</h4>
                  </label>
                  <input type="password" class="form-control" name="password" id="password" placeholder="<?php echo $_SESSION['user']['contrasena']; ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-12">
                  <label for="password2">
                    <h4>Verifica la contraseña</h4>
                  </label>
                  <input type="password" class="form-control" name="password2" id="password2" placeholder="password2">
                </div>
              </div>
              <div class="form-group profile-buttons">
                <div class="col-xs-12">
                  <br>
                  <button class="save" type="submit">Guardar</button>
                  <button class="reset" type="reset">Limpiar</button>
                  <button name="logout" type="submit" >Logout</button>
                  </form>
                </div>
              </div>

            </form>
            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Pie de página -->
  <div id="footer"></div>

</body>

</html>