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

    public function login()
    {

        $username = $_POST['username'];
        $passwd = $_POST['password'];

        $stmt = $this->conn->prepare(query: "SELECT nombre, contrasena FROM usuarios WHERE nombre = ? AND contrasena = ?");
        $stmt->bind_param("ss", $username, $passwd);
        $stmt->execute();
        if ($stmt->fetch()) {
            $_SESSION['logged'] = true;
            $_SESSION['user'] = $username;

            $this->conn->close();

            header(header: "Location: ../HTML/perfil.html");
            exit();
        } else {
            $_SESSION['logged'] = false;
        }
        $stmt->close();

        $stmtP = $this->conn->prepare(query: "SELECT nombre, contrasena FROM promotores WHERE nombre = ? AND contrasena = ?");
        $stmtP->bind_param("ss", $username, $passwd);
        $stmtP->execute();

        if ($stmtP->fetch()) {
            $_SESSION['logged'] = true;
            $_SESSION['user'] = $username;

            $this->conn->close();

            header(header: "Location: ../HTML/perfil.html");
            exit();
        } else {
            $_SESSION['logged'] = false;
        }
        $stmtP->close();

        if ($_SESSION['logged'] == false) {
            header("Location: ../HTML/err.html");
            exit();
        }
    }

    public function logout()
    {
        if (isset($_POST["logout"])) {
            session_start();
            session_unset();
            session_destroy();
            header("Location: ../HTML/login.html");
            exit();
        }
    }


    public function register()
    {
    // Retrieve form data from POST request
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];

    // Check if the two passwords match
    if ($password != $repeat_password) {
        $_SESSION['error'] = "Las contraseñas no coinciden";
        header("Location: ../HTML/register.html");
        exit();
    }
    }
}
