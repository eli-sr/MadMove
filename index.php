<?php
session_start();
if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['user'])) {
  $user = $_SESSION['user'];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <title>Home</title>
</head>

<body>
  <h1>Links</h1>
  <a href="pages/check/">Consultar datos</a><br>
  <a href="pages/mapa.php">Mapa</a><br>
  <?php
  if (isset($user)) {
    echo "Bienvenido " . $user . "!<br>";
    if ($user == "admin")
      echo "<a href='pages/admin/'>Panel admin</a><br>";
  } else {
    echo "<a href='pages/login.php'>Login</a>";
  }
  ?>
</body>

</html>