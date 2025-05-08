<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $game = new GameController();
  if (isset($_POST["create"])) {
    $game->create();
  }
  if (isset($_POST["reade"])) {
    $game->reade();
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

    // Create connection
    $this->conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($this->conn->connect_error) {
      die("Connection failed: " . $this->conn->connect_error);
    }
  }

  /*private $staticUser = [
        'username' => 'user',
        'password' => '1234'
    ];
 
     if ($username == $this->staticUser['username'] && $passwd == $this->staticUser['password']) {
            $_SESSION['user'] = $username;
            $_SESSION['logged'] = "Inicio de sesión exitoso!";
            echo $_SESSION['logged'];
            echo $_SESSION['user'];
        } else {
            $_SESSION['error'] = "Credenciales inválidas";
            echo $_SESSION['error'];
        }
    */

    public function create()
    {
    }

    public function reade()
    {
    }

    public function update()
    {
    }

    public function delete()
    {
    }
}