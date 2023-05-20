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
  <!-- Icons -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />
  <!-- CSS -->
  <link rel="stylesheet" href="/css/styles.css">
  <link rel="stylesheet" href="/css/admin.css">
  <link rel="stylesheet" href="/css/login.css">
  <!-- JS -->
  <script src="/js/api.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
          <th>ID</th>
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
          $id = $fila['ID'];
          $username = $fila['USER'];
          $password = $fila['PASSWORD'];
          $name = $fila['NAME'];
          $surname = $fila['SURNAME'];
          echo '<tr>';
          echo '<td>' . $id . '</td>';
          echo '<td>' . $username . '</td>';
          echo '<td>' . $password . '</td>';
          echo '<td>' . $name . '</td>';
          echo '<td>' . $surname . '</td>';
          echo '<td><button onclick=\'editUser("' . $id . '","' . $username . '","' . $name . '","' . $surname . '","' . $password . '")\'>';
          echo 'Editar</button></td>';
          if ($fila['USER'] != 'admin')
            echo '<td><button onclick=\'deleteUser("' . $username . '")\'>Eliminar</button></td>';
          echo '</tr>';
        }
        ?>
      </tbody>
    </table>
    <canvas id="myChart"></canvas>

    <div class="modal">
      <div class="modal-card">
        <button onclick="closeEdit()" class="close-button">
          <span class="material-symbols-rounded">close</span>
        </button>
        <form action="/pages/api/updateUser.php" method="post" class="signup">
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
            <input type="text" id="password" name="password" placeholder="********" class="input" required>
          </div>
          <div class="item">
            <label for="password-confirmation">Confirma tu contraseña</label>
            <input type="text" id="password-confirmation" name="password-confirmation" placeholder="********"
              class="input" required>
          </div>
          <input type="submit" value="Aceptar" class="boton boton-1 item" id="login">
          <input type="text" name="id" value="" style="display:none" />
        </form>

      </div>
    </div>
  </main>

  <!-- Body Scripts -->
  <script src="/js/admin.js"></script>
</body>

</html>