<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $user = new UserController();
  if (isset($_POST["login"])) {
    $user->login();
  }
  if (isset($_POST["logout"])) {
    $user->logout();
  }
  if (isset($_POST["register"])) {
    $user->register();
  }
  if (isset($_POST["update"])) {
    $user->update();
  }
  if (isset($_POST["update_password"])) {
    $user->updatePassword();
  }
  if (isset($_POST["delete"])) {
    $user->delete();
  }
}

class UserController
{
  private $conn;
  function __construct()
  {
    $servername = "nextplay-nextplay.l.aivencloud.com:11948";
    $username = "avnadmin";
    $password = "";
    $dbname = "nextplay";

    try {
      $this->conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die("Connection failed: " . $e->getMessage());
    }
  }

  public function login()
  {
    $username = $_POST['username'];
    $passwd = $_POST['password'];

    // Login for usuarios
    try {
      $stmt = $this->conn->prepare("SELECT nombre, correo, contrasena, estadisticas, img FROM usuarios WHERE nombre = :username AND contrasena = :password");
      $stmt->execute(['username' => $username, 'password' => $passwd]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user) {
        $_SESSION['logged'] = true;
        $_SESSION['user'] = [
          "nombre" => $user['nombre'],
          "email" => $user['correo'],
          "contrasena" => $user['contrasena'],
          'estadisticas' => $user['estadisticas'],
          "img" => $user['img']
        ];
        header("Location: ../HTML/profile.php");
        exit();
      }
    } catch (PDOException $e) {
      $_SESSION['logged'] = false;
    }

    // Login for promotores
    try {
      $stmt = $this->conn->prepare("SELECT nombre, contrasena FROM promotores WHERE nombre = :username AND contrasena = :password");
      $stmt->execute(['username' => $username, 'password' => $passwd]);
      $promotor = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($promotor) {
        $_SESSION['logged'] = true;
        $_SESSION['user'] = $username;
        header("Location: ../HTML/profile.php");
        exit();
      }
    } catch (PDOException $e) {
      $_SESSION['logged'] = false;
    }

    // If login fails
    if ($_SESSION['logged'] == false) {
      header("Location: ../HTML/err.html");
      exit();
    }
  }

  public function logout()
  {
    if (isset($_POST["logout"])) {
      session_unset();
      session_destroy();
      header("Location: ../HTML/logout.html");
      exit();
    }
  }

  public function register()
  {
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];

    if ($password !== $repeat_password) {
      $_SESSION['error'] = "Las contraseñas no coinciden";
      header("Location: ../HTML/register.html");
      exit();
    }

    $rol = $_POST['rol'];
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);

    if ($rol === "usuario") {
      $tabla = "usuarios";
    } elseif ($rol === "promotor") {
      $tabla = "promotores";
    } else {
      $_SESSION['error'] = "Tipo de usuario no especificado";
      header("Location: ../HTML/register.html");
      exit();
    }

    try {
      $stmt = $this->conn->prepare("INSERT INTO $tabla (nombre, correo, contrasena) VALUES (:username, :email, :password)");
      $stmt->execute([
        'username' => $username,
        'email' => $email,
        'password' => $password
      ]);
      header("Location: ../HTML/profile.html");
      exit();
    } catch (PDOException $e) {
      $_SESSION['error'] = "Error en el registro: " . $e->getMessage();
      header("Location: ../HTML/register.html");
      exit();
    }
  }

  public function update()
  {
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
      header("Location: ../HTML/login.html");
      exit();
    }

    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $current_user = $_SESSION['user']['nombre'];

    try {
      $stmt = $this->conn->prepare("UPDATE usuarios SET nombre = :username, correo = :email WHERE nombre = :current_user");
      $stmt->execute([
        'username' => $username,
        'email' => $email,
        'current_user' => $current_user
      ]);
      $_SESSION['user']['nombre'] = $username;
      $_SESSION['user']['email'] = $email;
      header("Location: ../HTML/profile.php");
      exit();
    } catch (PDOException $e) {
      $_SESSION['error'] = "Error al actualizar: " . $e->getMessage();
      header("Location: ../HTML/profile.php");
      exit();
    }
  }

  public function updatePassword()
  {
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
      header("Location: ../HTML/login.html");
      exit();
    }

    $new_password = $_POST['new_password'];
    $repeat_password = $_POST['repeat_new_password'];
    $current_user = $_SESSION['user']['nombre'];

    if ($new_password !== $repeat_password) {
      $_SESSION['error'] = "Las contraseñas no coinciden";
      header("Location: ../HTML/profile.php");
      exit();
    }

    try {
      $stmt = $this->conn->prepare("UPDATE usuarios SET contrasena = :new_password WHERE nombre = :current_user");
      $stmt->execute([
        'new_password' => $new_password,
        'current_user' => $current_user
      ]);
      $_SESSION['user']['contrasena'] = $new_password;
      header("Location: ../HTML/profile.php");
      exit();
    } catch (PDOException $e) {
      $_SESSION['error'] = "Error al actualizar contraseña: " . $e->getMessage();
      header("Location: ../HTML/proflie.php");
      exit();
    }
  }

  public function delete()
  {
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
      header("Location: ../HTML/login.html");
      exit();
    }

    $current_user = $_SESSION['user']['nombre'];

    try {
      $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE nombre = :current_user");
      $stmt->execute(['current_user' => $current_user]);
      session_unset();
      session_destroy();
      header("Location: ../HTML/logout.html");
      exit();
    } catch (PDOException $e) {
      $_SESSION['error'] = "Error al eliminar cuenta: " . $e->getMessage();
      header("Location: ../HTML/profile.php");
      exit();
    }
  }


  public function returntotalevents()
  {
    $userId = $_SESSION['user']['id_usuario'];


    try {
      $stmt = $this->conn->prepare("
      SELECT COUNT(*) AS total 
      FROM participa 
      WHERE usuarios_id_usuario = :userId
    ");
      $stmt->execute(['userId' => $userId]);

      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result ? (int) $result['total'] : 0;

    } catch (PDOException $e) {
      return 0; // En caso de error, devuelve 0
    }
  }

  public function getUserInterestedGamesCount()
  {
    $userId = $_SESSION['user']['id_usuario'];

    try {
      $stmt = $this->conn->prepare("
      SELECT COUNT(DISTINCT e.juegos_id_juego) AS total_juegos
      FROM participa p
      JOIN eventos e ON p.eventos_id_participa = e.id_evento
      WHERE p.usuarios_id_usuario = :userId
    ");
      $stmt->execute(['userId' => $userId]);

      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result ? (int) $result['total_juegos'] : 0;

    } catch (PDOException $e) {
      return 0; // En caso de error, devuelve 0
    }
  }


  public function getUserUpcomingEvents()
  {
    $userId = $_SESSION['user']['id_usuario'];

    try {
      $stmt = $this->conn->prepare("
      SELECT e.nombre, e.fecha, e.id_evento
      FROM participa p
      JOIN eventos e ON p.eventos_id_participa = e.id_evento
      WHERE p.usuarios_id_usuario = :userId
      ORDER BY e.fecha ASC, e.hora ASC
    ");
      $stmt->execute(['userId' => $userId]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
      return [];
    }
  }


  public function getUserInterestedGames()
  {

    $userId = $_SESSION['user']['id_usuario'];

    try {
      $stmt = $this->conn->prepare("
      SELECT DISTINCT j.nombre
      FROM participa p
      INNER JOIN eventos e ON p.eventos_id_participa = e.id_evento
      INNER JOIN juegos j ON e.juegos_id_juego = j.id_juego
      WHERE p.usuarios_id_usuario = :userId
    ");

      $stmt->execute(['userId' => $userId]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      return [];
    }
  }

  public function getPromotorEvents()
  {
    $userId = $_SESSION['user']['id_usuario'];

    try {
      $stmt = $this->conn->prepare("
      SELECT 
        e.nombre, 
        e.fecha, 
        e.id_evento,
        (SELECT COUNT(*) 
         FROM eventos 
         WHERE promotores_id_promotor = :userId) AS total_eventos
      FROM eventos e
      WHERE e.promotores_id_promotor = :userId
      ORDER BY e.fecha ASC, e.hora ASC
    ");
      $stmt->execute(['userId' => $userId]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
      return [];
    }
  }


}