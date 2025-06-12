<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once 'User.php';

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
    $servername = "localhost:3306";
    $username = "root";
    $password = "";
    $dbname = "nextplay";

    try {
      $this->conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      $_SESSION['error'] = "Error de conexión a la base de datos.";
      header("Location: ../HTML/error.php");
      exit();
    }
  }

  public function login()
  {
    require_once __DIR__ . '/User.php';
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    $username = $_POST['username'] ?? '';
    $passwd = $_POST['password'] ?? '';

    if (empty($username) || empty($passwd)) {
      $_SESSION['error'] = "Usuario o contraseña vacíos.";
      header("Location: ../HTML/login.php");
      exit();
    }

    try {
      $stmt = $this->conn->prepare("SELECT id_usuario, nombre, correo, contrasena, estadisticas, img FROM usuarios WHERE nombre = :username AND contrasena = :password");
      $stmt->execute(['username' => $username, 'password' => $passwd]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user) {
        $_SESSION['logged'] = true;
        $user['promotor'] = false;
        $_SESSION['user'] = new User($user);
        header("Location: ../HTML/profile.php");
        exit();
      }
    } catch (PDOException $e) {
      $_SESSION['error'] = "Error en la autenticación de usuario.";
      header("Location: ../HTML/login.php");
      exit();
    }

    try {
      $stmt = $this->conn->prepare("SELECT id_promotor, nombre, contrasena FROM promotores WHERE nombre = :username AND contrasena = :password");
      $stmt->execute(['username' => $username, 'password' => $passwd]);
      $promotor = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($promotor) {
        $_SESSION['logged'] = true;
        $promotor['promotor'] = true;
        $_SESSION['user'] = new User($promotor);
        header("Location: ../HTML/profilepromotor.php");
        exit();
      }
    } catch (PDOException $e) {
      $_SESSION['error'] = "Error en la autenticación del promotor.";
      header("Location: ../HTML/login.php");
      exit();
    }

    $_SESSION['logged'] = false;
    $_SESSION['error'] = "Nombre de usuario o contraseña incorrectos.";
    header("Location: ../HTML/login.php");
    exit();
  }

  public function logout()
  {
    session_unset();
    session_destroy();
    header("Location: ../HTML/logout.html");
    exit();
  }

  public function register()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    require_once __DIR__ . '/User.php';

    $password = $_POST['password'] ?? '';
    $repeat_password = $_POST['repeat_password'] ?? '';
    $rol = $_POST['rol'] ?? '';
    $username = trim(htmlspecialchars($_POST['username'] ?? ''));
    $email = trim(htmlspecialchars($_POST['email'] ?? ''));

    if (empty($rol) || empty($username) || empty($email) || empty($password) || empty($repeat_password)) {
      $_SESSION['error'] = "Todos los campos son obligatorios.";
      header("Location: ../HTML/register.php");
      exit();
    }

    if ($password !== $repeat_password) {
      $_SESSION['error'] = "Las contraseñas no coinciden.";
      header("Location: ../HTML/register.php");
      exit();
    }

    $tabla = $rol === "usuario" ? "usuarios" : ($rol === "promotor" ? "promotores" : null);

    if (!$tabla) {
      $_SESSION['error'] = "Rol de usuario inválido.";
      header("Location: ../HTML/register.php");
      exit();
    }

    try {
      $stmt = $this->conn->prepare("SELECT nombre FROM $tabla WHERE nombre = :username");
      $stmt->execute(['username' => $username]);

      if ($stmt->fetch()) {
        $_SESSION['error'] = "El nombre de usuario ya existe.";
        header("Location: ../HTML/register.php");
        exit();
      }

      $stmt = $this->conn->prepare("INSERT INTO $tabla (nombre, correo, contrasena) VALUES (:username, :email, :password)");
      $stmt->execute([
        'username' => $username,
        'email' => $email,
        'password' => $password
      ]);

      $id = $this->conn->lastInsertId();

      $_SESSION['logged'] = true;

      $userData = [
        $rol === "usuario" ? 'id_usuario' : 'id_promotor' => $id,
        'nombre' => $username,
        'correo' => $email,
        'contrasena' => $password,
        'estadisticas' => '',
        'img' => '',
        'promotor' => $rol === "promotor"
      ];

      $_SESSION['user'] = new User($userData);

      $redirect = $rol === "promotor" ? "profilepromotor.php" : "profile.php";
      header("Location: ../HTML/" . $redirect);
      exit();

    } catch (PDOException $e) {
      $_SESSION['error'] = "Error en el registro: " . $e->getMessage();
      header("Location: ../HTML/register.php");
      exit();
    }
  }

  public function update()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true || !isset($_SESSION['user'])) {
      $_SESSION['error'] = "Debe iniciar sesión para actualizar sus datos.";
      header("Location: ../HTML/login.php");
      exit();
    }

    require_once __DIR__ . '/User.php';

    $username = trim(htmlspecialchars($_POST['username'] ?? ''));
    $email = trim(htmlspecialchars($_POST['email'] ?? ''));

    if (empty($username) || empty($email)) {
      $_SESSION['error'] = "Nombre y correo no pueden estar vacíos.";
      header("Location: ../HTML/profile.php");
      exit();
    }

    $user = $_SESSION['user'];
    $currentName = $user->getNombre();

    try {
      $stmt = $this->conn->prepare("UPDATE usuarios SET nombre = :username, correo = :email WHERE nombre = :currentName");
      $stmt->execute([
        'username' => $username,
        'email' => $email,
        'currentName' => $currentName
      ]);

      $user->setNombre($username);
      $user->setCorreo($email);

      $_SESSION['user'] = $user;

      header("Location: ../HTML/profile.php");
      exit();
    } catch (PDOException $e) {
      $_SESSION['error'] = "Error al actualizar los datos: " . $e->getMessage();
      header("Location: ../HTML/profile.php");
      exit();
    }
  }

  public function updatePassword()
  {
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
      $_SESSION['error'] = "Debe iniciar sesión para cambiar la contraseña.";
      header("Location: ../HTML/login.php");
      exit();
    }

    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $repeat_password = $_POST['repeat_new_password'] ?? '';
    $current_user = $_SESSION['user']['nombre'];

    try {
      $stmt = $this->conn->prepare("SELECT contrasena FROM usuarios WHERE nombre = :current_user");
      $stmt->execute(['current_user' => $current_user]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$user || $user['contrasena'] !== $current_password) {
        $_SESSION['error'] = "La contraseña actual es incorrecta.";
        header("Location: ../HTML/profile.php");
        exit();
      }

      if ($new_password !== $repeat_password) {
        $_SESSION['error'] = "Las nuevas contraseñas no coinciden.";
        header("Location: ../HTML/profile.php");
        exit();
      }

      $stmt = $this->conn->prepare("UPDATE usuarios SET contrasena = :new_password WHERE nombre = :current_user");
      $stmt->execute(['new_password' => $new_password, 'current_user' => $current_user]);
      $_SESSION['user']['contrasena'] = $new_password;
      header("Location: ../HTML/profile.php");
      exit();
    } catch (PDOException $e) {
      $_SESSION['error'] = "Error al actualizar la contraseña: " . $e->getMessage();
      header("Location: ../HTML/profile.php");
      exit();
    }
  }

  public function delete()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    require_once __DIR__ . '/User.php';

    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true || !isset($_SESSION['user'])) {
      $_SESSION['error'] = "Debe iniciar sesión para eliminar su cuenta.";
      header("Location: ../HTML/login.php");
      exit();
    }

    if (!($_SESSION['user'] instanceof User)) {
      $_SESSION['error'] = "Error interno: el objeto de usuario no es válido.";
      header("Location: ../HTML/login.php");
      exit();
    }

    $username = $_SESSION['user']->getNombre();
    $isPromotor = $_SESSION['user']->getPromotor();
    $tabla = $isPromotor ? 'promotores' : 'usuarios';

    try {
      $stmt = $this->conn->prepare("DELETE FROM $tabla WHERE nombre = :username");
      $stmt->execute(['username' => $username]);

      unset($_SESSION['user']);
      unset($_SESSION['logged']);
      session_destroy();

      header("Location: ../HTML/logout.html");
      exit();
    } catch (PDOException $e) {
      $_SESSION['error'] = "Error al eliminar la cuenta: " . $e->getMessage();
      header("Location: ../HTML/profile.php");
      exit();
    }
  }



  public function returntotalevents()
  {
    $userId = $_SESSION['user']->getId_usuario();


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
    $userId = $_SESSION['user']->getId_usuario();

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
    $userId = $_SESSION['user']->getId_usuario();

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

    $userId = $_SESSION['user']->getId_usuario();

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
    $userId = $_SESSION['user']->getId_usuario();

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
