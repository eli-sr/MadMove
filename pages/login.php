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
  <!-- Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
  <!-- CSS -->
  <link rel="stylesheet" href="/css/styles.css">
  <link rel="stylesheet" href="/css/login.css">
  <title>Iniciar sesión</title>
</head>

<body>
  <div class="card">
    <h1>Iniciar sesión</h1>
    <form action="/pages/api/login.php" method="post">
      <input type="text" id="user" name="user" placeholder="Nombre de usuario" class="input">
      <input type="password" id="password" name="password" placeholder="Contraseña" class="input">
      <input type="submit" value="Continuar" class="boton boton-1" id="login">
    </form>
    <div class="line"></div>
    <input value="Crear cuenta" class="boton" id="signup">
    <?php if (isset($_GET['login_error'])) { ?>
      <p class="red-emphasis">Usuario o contraseña incorrectos</p>
    <?php } ?>
  </div>
</body>

</html>