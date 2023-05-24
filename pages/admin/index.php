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
  <title>Administración - MadMove</title>
  <!-- Icons -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />
  <!-- Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
  <!-- CSS -->
  <link rel="stylesheet" href="/css/styles.css">
  <link rel="stylesheet" href="/css/admin.css">
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
        <div class="logo">
          <img src="../../img/logo.svg" alt="logo">
          <p>Administración</p>
        </div>
      </li>
      <li>
        <button class="aside-button" onclick="showUsuarios()">
          <span class="material-symbols-rounded">group</span>
          <p>Usuarios</p>
        </button>
      </li>
      <li>
        <button class="aside-button" onclick="showReservas()">
          <span class="material-symbols-rounded">menu_book</span>
          <p>Reservas</p>
        </button>
      </li>
      <li>
        <button class="aside-button" onclick="">
          <span class="material-symbols-rounded">database</span>
          <p>Base de datos</p>
        </button>
      </li>
    </ul>
  </aside>

  <main>
    <section id="panelUsuarios" class="panel">
      <h1>Administración de usuario</h1>
      <p>Edita los usuarios existentes o elimínalos si es necesario.</p>
      <div class="table-sur">
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
      </div>
    </section>
    <section id="panelReservas" class="panel">
      <h1>Reservas</h1>
      <h3>Número de reservas en tiempo real</h3>
      <p>Observa el número de reservas activas para cada parking</p>
      <canvas id="myChart"></canvas>
      <h3>Exportar datos</h3>
      <p>Exporta todos los datos sobre las reservas, incluyendo fecha, hora, usuario, parking y si está pendiente de
        resolver la reserva.</p>
      <button class="boton boton-1" onclick="downloadReservasCSV()">Descargar CSV</button>
    </section>

    <div class="modal">
      <div class="modal-card">
        <button onclick="closeEdit()" class="close-button">
          <span class="material-symbols-rounded">close</span>
        </button>
        <form action="/pages/api/updateUser.php" method="post" class="edit-user">
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
  <script src="/js/adminPanel.js"></script>
</body>

</html>