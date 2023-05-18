<?php
include "../../util/executeQuery.php";

session_start();
if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['user'])) {
  $user = $_SESSION['user'];
}
if ($user != 'admin') {
  header("Location: /pages/mapa.php");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Admin</title>
  <!-- CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
  <!-- JS -->
  <script src="/js/api.js"></script>
</head>

<body>
  <!-- <button onclick="cargarLineas()">Cargar datos LINEAS</button>
  <button onclick="limpiarLineas()">Limpiar datos LINEAS</button>
  <button onclick="cargarParadas()">Cargar datos PARADAS</button>
  <button onclick="limpiarParadas()">Limpiar datos PARADAS</button>
  <div id="server-response"></div> -->

  <aside>
    <ul>
      <li>
        <button>Usuarios</button>
      </li>
      <li>
        <button>Database</button>
      </li>
    </ul>
  </aside>

  <main>
    <p class="red-emphasis"></p>
    <table>
      <thead>
        <tr>
          <th>Username</th>
          <th>Password</th>
          <th>Name</th>
          <th>Surname</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $query = "SELECT * FROM USUARIOS";
        $resultado = executeQuery($query);
        while ($fila = mysqli_fetch_assoc($resultado)) {
          $username = $fila['USER'];
          $password = $fila['PASSWORD'];
          $name = $fila['NAME'];
          $surname = $fila['SURNAME'];
          echo '<tr>';
          echo '<td>' . $username . '</td>';
          echo '<td>' . $password . '</td>';
          echo '<td>' . $name . '</td>';
          echo '<td>' . $surname . '</td>';
          echo '<td><button onclick=\'editUser("' . $username . '")\'>Editar</button></td>';
          if ($fila['USER'] != 'admin')
            echo '<td><button onclick=\'deleteUser("' . $username . '")\'>Eliminar</button></td>';
          echo '</tr>';
        }
        ?>
      </tbody>
    </table>
  </main>

  <!-- Body Scripts -->
  <script src="/js/admin.js"></script>
</body>

</html>