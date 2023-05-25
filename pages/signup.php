<?php
session_start();
if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['user'])) {
  header("Location: /pages/mapa.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="es">

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
  <title>Crear cuenta</title>
</head>

<body>
  <div class="logo">
    <img src="../img/logo.svg" alt="logo">
  </div>
  <div class="title block">
    <h1>Crear cuenta</h1>
    <p>de manera gratuita para disfrutar de todo MadMove</p>
  </div>
  <div class="card">
    <form action="/pages/api/signup.php" method="post" class="signup">
      <div class="item">
        <label for="name">Nombre</label>
        <input type="text" id="name" name="name" placeholder="Jacob" class="input" required autofocus>
      </div>
      <div class="item">
        <label for="surname">Apellidos</label>
        <input type="text" id="surname" name="surname" placeholder="Miller" class="input">
      </div>
      <div class="item">
        <label for="user">Nombre de usuario</label>
        <input type="text" id="user" name="user" placeholder="jacobmiller96" class="input" required>
      </div class="item">
      <div class="item">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="********" class="input" required>
      </div>
      <div class="item">
        <label for="password-confirmation">Confirma tu contraseña</label>
        <input type="password" id="password-confirmation" name="password-confirmation" placeholder="********" class="input" required>
      </div>
      <input type="submit" value="Continuar" class="boton boton-1 item" id="login">
    </form>
    <?php if (isset($_GET['password_error'])) { ?>
      <p class="red-emphasis">Las contraseñas no coinciden</p>
    <?php } ?>
    <?php if (isset($_GET['user_error'])) { ?>
      <p class="red-emphasis">El nombre de usuario no está disponible</p>
    <?php } ?>
  </div>
</body>

</html>