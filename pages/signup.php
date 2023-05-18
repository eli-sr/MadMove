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
    <svg id="logo-14" width="73" height="49" viewBox="0 0 73 49" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path
        d="M46.8676 24C46.8676 36.4264 36.794 46.5 24.3676 46.5C11.9413 46.5 1.86765 36.4264 1.86765 24C1.86765 11.5736 11.9413 1.5 24.3676 1.5C36.794 1.5 46.8676 11.5736 46.8676 24Z"
        class="ccustom" fill="#68DBFF"></path>
      <path
        d="M71.1324 24C71.1324 36.4264 61.1574 46.5 48.8529 46.5C36.5484 46.5 26.5735 36.4264 26.5735 24C26.5735 11.5736 36.5484 1.5 48.8529 1.5C61.1574 1.5 71.1324 11.5736 71.1324 24Z"
        class="ccompli1" fill="#FF7917"></path>
    </svg>
  </div>
  <h1>Crear cuenta</h1>
  <div class="card">
    <form action="/pages/api/signup.php" method="post" class="signup">
      <div class="item">
        <label for="name">Nombre</label>
        <input type="text" id="name" name="name" placeholder="Jacob" class="input" required>
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