<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {

  $game = new GameController();

  if (isset($_POST["create"])) {
    $game->create();
  }

  if (isset($_POST["search"])) {
    $game->read();
  }

  if (isset($_POST["update"])) {
    $game->update();
  }

  if (isset($_POST["delete"])) {
    $game->delete();
  }

}


class GameController
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

  public function getConnection()
  {
    return $this->conn;
  }


  public function create()
  {

    if (
      !isset($_POST['name']) ||
      !isset($_POST['developer']) ||
      !isset($_POST['publisher']) ||
      !isset($_POST['releasedate'])
    ) {
      header("Location: ../HTML/gamemanager.php?message=Faltan%20campos%20por%20llenar");
      exit();
    }



    $name = $_POST['name'];
    $developer = $_POST['developer'];
    $publisher = $_POST['publisher'];
    $releasedate = $_POST['releasedate'];

    try {
      $stmt = $this->conn->prepare("INSERT INTO juegos (nombre, desarollador, editor, fecha_lanzamiento) VALUES (:name, :developer, :publisher, :releasedate)");
      $stmt->execute([
        'name' => $name,
        'developer' => $developer,
        'publisher' => $publisher,
        'releasedate' => $releasedate
      ]);
      header("Location: ../HTML/gamemanager.php?message=Juego%20Creado!");
      exit();
    } catch (PDOException $e) {
      header("Location: ../HTML/gamemanager.php?message=Error%20al%20crear%20el%20juego");
      exit();
    }


  }

  public function update()
  {

    if (
      !isset($_POST['name']) ||
      !isset($_POST['developer']) ||
      !isset($_POST['publisher']) ||
      !isset($_POST['releasedate'])
    ) {
      header("Location: ../HTML/gamemanager.php?message=Faltan%20campos%20por%20llenar");
      exit();
    }

    // Recoger datos del formulario
    $name = $_POST['name'];
    $developer = $_POST['developer'];
    $publisher = $_POST['publisher'];
    $releaseDate = $_POST['releasedate'];

    try {
      // Actualizar el juego
      $stmt = $this->conn->prepare("
            UPDATE juegos 
            SET desarollador = :developer, editor = :publisher, fecha_lanzamiento = :releaseDate 
            WHERE nombre = :name
        ");
      $stmt->execute([
        'developer' => $developer,
        'publisher' => $publisher,
        'releaseDate' => $releaseDate,
        'name' => $name
      ]);

      if ($stmt->rowCount() > 0) {
        header("Location: ../HTML/gamemanager.php?message=Juego%20actualizado%20correctamente");
        exit();
      } else {
        header("Location: ../HTML/gamemanager.php?message=No%20se%20encontr%C3%B3%20el%20juego%20para%20actualizar");
        exit();
      }

    } catch (PDOException $e) {
      header("Location: ../HTML/gamemanager.php?message=Error%20al%20actualizar%20el%20juego");
      exit();
    }

  }

  public function delete()
  {



    if (!isset($_POST['name'])) {
      header("Location: ../HTML/gamemanager.php?message=Falta%20el%20nombre%20del%20juego");
      exit();
    }


    $name = $_POST['name'];

    try {
      $stmt = $this->conn->prepare("DELETE FROM juegos WHERE nombre = :name");
      $stmt->execute(['name' => $name]);

      if ($stmt->rowCount() > 0) {
        header("Location: ../HTML/gamemanager.php?message=Se%20elimin%C3%B3%20correctamente");
        exit();
      } else {
        header("Location: ../HTML/gamemanager.php?message=Juego%20no%20encontrado%20o%20no%20eliminado");
        exit();
      }

    } catch (PDOException $e) {
      header("Location: ../HTML/gamemanager.php?message=Error%20al%20eliminar%20el%20juego");
      exit();
    }


  }

  public function read()
  {


    if (!isset($_POST['name'])) {
      header("Location: ../HTML/gamemanager.php?message=Falta%20el%20nombre%20del%20juego");
      exit();
    }


    $name = $_POST['name'];

    try {
      $stmt = $this->conn->prepare("SELECT nombre, desarollador, editor, fecha_lanzamiento FROM juegos WHERE nombre = :name");
      $stmt->execute(['name' => $name]);
      $game = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($game) {
        $_SESSION['game'] = [
          "name" => $game['nombre'],
          "desarollador" => $game['desarollador'],
          "editor" => $game['editor'],
          'fecha_lanzamiento' => $game['fecha_lanzamiento']
        ];
        header("Location: ../HTML/gamemanager.php");
        exit();
      } else {

        header("Location: ../HTML/gamemanager.php?message=Juego%20no%20encontrado");
        exit();
      }
    } catch (PDOException $e) {
      header("Location: ../HTML/gamemanager.php?message=Error%20al%20buscar%20el%20juego");
    }


  }


}