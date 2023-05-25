<?php
session_start();
if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['user'])) {
  header("Location: /pages/mapa.php");
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
  <div class="logo">
    <img src="../img/logo.svg" alt="logo">
  </div>
  <div class="title block">
    <h1>Iniciar sesión</h1>
    <p>para disfrutar las funcionalidades de MadMove</p>
  </div>
  <div class="card">
    <form action="/pages/api/login.php" method="post" class="login">
      <label for="user">Nombre de usuario</label>
      <input type="text" id="user" name="user" placeholder="jacobmiller96" class="input" autofocus>
      <label for="password">Contraseña</label>
      <input type="password" id="password" name="password" placeholder="********" class="input">
      <input type="submit" value="Continuar" class="boton boton-1" id="login">
    </form>
    <div class="line"></div>
    <a href="/pages/signup.php" class="boton" id="signup">Crear cuenta</a>
    <div class="block-h">
      <a href="/pages/mapa.php" class="link">Volver al mapa</a>
    </div>
    <?php if (isset($_GET['login_error'])) { ?>
      <p class="red-emphasis">Usuario o contraseña incorrectos</p>
    <?php } ?>
  </div>
</body>

</html>