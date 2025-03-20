<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $user = new UserController();
  if (isset($_POST["login"])) {
    $user ->login();
  }
  if (isset($_POST["logout"])) {
    $user ->logout();
  }
  if (isset($_POST["register"])) {
    $user ->register();
  }
}

class UserController{

    private $staticUser = [
        'username' => 'user',
        'password' => '1234'
      ];

  public function login(){

    $username = $_POST['username'];
    $passwd = $_POST['password'];

    if ($username == $this->staticUser['username'] && $passwd == $this->staticUser['password']) {
      $_SESSION['user'] = $username;
      $_SESSION['success'] = "Inicio de sesión exitoso!";
      echo $_SESSION['success'];
      echo $_SESSION['user'];

    } else {
      $_SESSION['error'] = "Credenciales inválidas";
      echo $_SESSION['error'];
    }


    
  }

  public function logout(){
    
  }

  public function register(){
    
  }
}
?>