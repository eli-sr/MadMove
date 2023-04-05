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
  <a href="check/">Consultar datos</a>
  <br>
  <?php
  if (isset($user)) {
    echo "Bienvenido " . $user . "!";
  } else {
    echo "<a href='login.php'>Login</a>";
  }
  ?>
</body>

</html>