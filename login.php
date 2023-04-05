<?php
session_start();
if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['user'])) {
  header("Location: /index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar sesión</title>
</head>

<body>
  <h1>Iniciar sesión</h1>
  <form action="/api/login.php" method="post">
    <label for="user">Usuario:</label>
    <input type="text" id="user" name="user"><br>
    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password"><br>
    <input type="submit" value="Continuar">
  </form>
  <?php if (isset($_GET['login_error'])) { ?>
    <p>
      <?php echo "Usuario o contraseña incorrectos."; ?>
    </p>
  <?php } ?>
</body>

</html>