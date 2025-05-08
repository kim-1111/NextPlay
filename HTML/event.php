<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NextPlay</title>

  <!-- Ícono de la página -->
  <link rel="icon" href="../imagenes/logo.png" />

  <!-- Archivos CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />

  <!-- Fuentes personalizadas -->
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Press+Start+2P&display=swap"
    rel="stylesheet" />

  <!-- LAYOUT -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../Layout/include.js"></script>
  <script src="../Layout/auth.js"></script>
  <link rel="stylesheet" href="../Layout/layout.css">
  <link rel="stylesheet" href="../CSS/style.css" />
  <link rel="stylesheet" href="../CSS/event.css" />

  <link rel="stylesheet" href="../CSS/auth.css">
</head>

<body>
  <!-- Overlay y ventana de login -->
  <div id="overlay"></div>
  <div id="loginwindow"></div>
  <div id="registerwindow"></div>

  <div class="principal" id="principal">
    <!-- Cabecera con navbar -->
    <header>
      <div id="navbar"></div>
    </header>
    
    <main>
      <div class="event-container">
        <h1 class="event-title">Tech Conference 2025</h1>
        <div class="event-details">
          <p><strong>Date:</strong> June 15, 2025</p>
          <p><strong>Time:</strong> 10:00 AM – 4:00 PM</p>
          <p><strong>Location:</strong> Central Auditorium, Mexico City</p>
        </div>
        <div class="event-description">
          <p>
            Join us for a day filled with innovation, inspiring talks, and networking
            opportunities with leaders from the tech industry.
          </p>
        </div>
        <?php if (isset($_SESSION['user']['nombre'])): ?>
          <a><button class="signOn-button">Sign On!</button></a>
        <?php else: ?>
          <a onclick="mostrarLogin()"><button class="signOn-button">Sign On!</button></a>
        <?php endif; ?>
      </div>
    </main>

    <!-- Pie de página -->
    <footer>
      <div id="footer"></div>
    </footer>
  </div>

</body>