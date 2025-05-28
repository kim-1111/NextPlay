<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NextPlay - Home</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../CSS/principal.css">
  <link rel="stylesheet" href="../CSS/management.css">
  <link rel="stylesheet" href="../Layout/layout.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../Layout/include.js"></script>
  <script src="../Layout/auth.js"></script>
  <link rel="stylesheet" href="../CSS/about.css">
</head>

<body>

  <div id="navbar"></div>
  <div id="loginwindow"></div>
  <div id="registerwindow"></div>

  <?php
  if (isset($_GET['message']) && !empty($_GET['message'])) {
    $mensaje = htmlspecialchars($_GET['message']);
    echo '
    <center>
        <div class="message-box" id="messageBox">
            ' . $mensaje . '
        </div>
    </center>
    ';
  }
  ?>

  <?php

  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }


  $game = $_SESSION['game'] ?? [
    'name' => '',
    'desarollador' => '',
    'editor' => '',
    'fecha_lanzamiento' => '',
    'descripcion' => '',
    'link' => ''
  ];
  unset($_SESSION['game']);
  ?>


  <div class="container">
    <div class="form-container">
      <h2>Game Manager</h2>
      <form action="../php/gameController.php" method="post">
        <div class="form-group">
          <label for="name">Name (use to search and delete):</label>
          <input type="text" id="name" name="name" required value="<?= htmlspecialchars($game['name']) ?>">
        </div>
        <div class="form-group">
          <label for="developer">Developer:</label>
          <input type="text" id="developer" name="developer" value="<?= htmlspecialchars($game['desarollador']) ?>">
        </div>
        <div class="form-group">
          <label for="publisher">Publisher:</label>
          <input type="text" id="publisher" name="publisher" value="<?= htmlspecialchars($game['editor']) ?>">
        </div>
        <div class="form-group">
          <label for="description">Description:</label>
          <textarea id="description" name="description" class="form-control" rows="5" maxlength="200"><?= htmlspecialchars($game['descripcion']) ?></textarea>
        </div>
        <div class="form-group">
          <label for="link">Link:</label>
          <input type="text" id="link" name="link" value="<?= htmlspecialchars($game['link']) ?>">
        </div>
        <div class="form-group">
          <label for="releasedate">Release Date:</label>
          <input type="date" id="releasedate" name="releasedate"
            value="<?= htmlspecialchars($game['fecha_lanzamiento']) ?>">
        </div>
        <button type="submit" name="create">Create!</button>
        <button type="submit" name="search">Search!</button>
        <button type="submit" name="update">Update!</button>
        <button type="submit" name="delete">Delete!</button>
      </form>

      <?php
      require_once '../php/gameController.php';

      $controller = new GameController();
      $conn = $controller->getConnection();

      try {
        $stmt = $conn->query("SELECT nombre, desarollador, editor, fecha_lanzamiento FROM juegos");
        $juegos = $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
        die("Error al consultar juegos: " . $e->getMessage());
      }
      ?>

      <div class="listgames">
        <table>
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Desarrollador</th>
              <th>Editor</th>
              <th>Fecha de Lanzamiento</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($juegos && count($juegos) > 0) {
              foreach ($juegos as $juego) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($juego['nombre']) . "</td>";
                echo "<td>" . htmlspecialchars($juego['desarollador']) . "</td>";
                echo "<td>" . htmlspecialchars($juego['editor']) . "</td>";
                echo "<td>" . htmlspecialchars($juego['fecha_lanzamiento']) . "</td>";
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='4'>No hay juegos registrados.</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>



    </div>
  </div>

  <div id="footer"></div>

</body>

</html>