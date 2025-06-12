<!DOCTYPE html>
<html lang="en">
<?php   
require_once __DIR__ . '/../php/User.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  } ?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="../Layout/layout.css">
  <link rel="stylesheet" href="../CSS/auth.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../Layout/include.js"></script>
</head>

<body>

  <nav id="navbar"></nav>

  <center>
    <main>
      <section class="register-container">
        <h2 class="title">Login</h2>
        <form action="../php/UserController.php" method="post">
          <label>
            <div class="input-container">
              <img src="../imagenes/user-icon.png" alt="User Icon">
            </div>
            <input type="text" required placeholder="Enter username" name="username">
          </label>

          <?php
          if (!empty($_SESSION['error'])) {
            echo htmlspecialchars($_SESSION['error']);
            unset($_SESSION['error']);
          }
          ?>

          <label>
            <div class="input-container">
              <img src="../imagenes/password-icon.png" alt="Password Icon">
            </div>
            <input type="password" required placeholder="Enter your password" name="password">
          </label>

          <div class="box1">
            <div class="rememberpassword">

              <label for="remember">
                <input type="checkbox" id="remember"> Remember me
              </label>
            </div>
            <div class="forgotpassword">
              <a href="" class="wowow">Forgot password?</a>
            </div>
          </div>


          <button class="register-btn" type="submit" name="login">Login</button>
        </form>
        <div class="authswitch">
          <p><a href="register.php">Don't have an account? Register!</a></p>
        </div>
      </section>
    </main>
  </center>

  <footer>
    <div id="footer"></div>
  </footer>
</body>

</html>