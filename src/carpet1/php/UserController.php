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
}

class UserController
{

  public function login()
  {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $this -> conn -> prepare("ff");
    $stmt -> bind_param( "ss", $username, $password);
    $_SESSION["logged"] = true;
    $_SESSION["user"] = $username;

  }

  public function logout()
  {

  }

  public function register()
  {

  }
}
?>