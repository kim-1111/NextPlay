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

  public function login(){
    
  }

  public function logout(){
    
  }

  public function register(){
    
  }
}
?>