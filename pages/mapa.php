<?php
session_start();
if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['user'])) {
  $user = $_SESSION['user'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
    integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
    integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
  <!-- Marker Cluster -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
  <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
  <!-- jsPDF -->
  <script src="https://unpkg.com/jspdf-invoice-template@1.4.0/dist/index.js"></script>
  <!-- Icons -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />
  <!-- Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
  <!-- CSS -->
  <link rel="stylesheet" href="/css/styles.css">
  <link rel="stylesheet" href="/css/mapa.css">
  <!-- JS -->
  <script src="/js/api.js"></script>
</head>

<body>
  <header>
    <?php if (isset($user)) { ?>
      <button onclick="openUserMenu()" class="boton boton-1">
        <?php echo $user ?>
      </button>
    <?php } else { ?>
      <a href="/pages/login.php" class="boton boton-1">Iniciar sesión</a>
    <?php } ?>
  </header>
  <?php if (isset($user)) { ?>
    <ul id="user-menu">
      <?php if ($user == "admin") { ?>
        <li>
          <a href="/pages/admin/">Panel admin</a>
        </li>
      <?php } ?>
      <li>
        <a href="#">Ajustes</a>
      </li>
      <li>
        <button onclick="logOut()">Cerrar sesión</button>
      </li>
    </ul>
  <?php } ?>
  <aside class="aside-1">
    <ul>
      <li>
        <button class="aside-button" onclick="showLineas()">
          <span class="material-symbols-rounded">timeline</span>
          <p>Lineas</p>
        </button>
      </li>
      <li>
        <button class="aside-button" onclick="showParadas()">
          <span class="material-symbols-rounded">directions_bus</span>
          <p>Paradas</p>
        </button>
      </li>
      <?php if (isset($user)) { ?>
        <li>
          <button class="aside-button" onclick="showBicis()">
            <span class="material-symbols-rounded">pedal_bike</span>
            <p>Bicicletas</p>
          </button>
        </li>
        <li>
          <button class="aside-button" onclick="showParkings()">
            <span class="material-symbols-rounded">local_parking</span>
            <p>Parkings</p>
          </button>
        </li>
        <li>
          <button class="aside-button" onclick="showComoLlegar()">
            <span class="material-symbols-rounded">route</span>
            <p>Cómo llegar</p>
          </button>
        </li>
      <?php } else { ?>
        <li>
          <a href="/pages/login.php" class="aside-button disable">
            <span class="material-symbols-rounded">pedal_bike</span>
            <p>Bicicletas</p>
          </a>
        </li>
        <li>
          <a href="/pages/login.php" class="aside-button disable">
            <span class="material-symbols-rounded">local_parking</span>
            <p>Parkings</p>
          </a>
        </li>
        <li>
          <a href="/pages/login.php" class="aside-button disable">
            <span class="material-symbols-rounded">route</span>
            <p>Cómo llegar</p>
          </a>
        </li>
      <?php } ?>
    </ul>
  </aside>
  <aside class="aside-2">
    <div id="panelLinea" class="panel">
      <button onclick="closeMenu()" class="close-button">
        <span class="material-symbols-rounded">close</span>
      </button>
      <h1>Líneas</h1>
      <p>Horarios y recorridos de las líneas de autobuses</p>
      <div class="block">

        <h2>Buscar línea</h2>
        <select id="selectLinea" class="input" onchange="setLinea(this.value)">
          <option value="">Selecciona una linea</option>
          <?php
          include_once "../util/executeQuery.php";
          $query = "SELECT * FROM LINEAS";
          $resultado = executeQuery($query);
          while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<option value='" . $fila['line'] . "'>" . $fila['label'] . ": " . $fila['nameA'] . " - " . $fila['nameB'] . "</option>";
          }
          ?>
        </select>
      </div>
      <div class="block">
        <h2>Sentido</h2>
        <div class="block-h">
          <button class="boton boton-1" onclick="setLinea(null,1)">A -> B</button>
          <button class="boton boton-1" onclick="setLinea(null,2)">B -> A</button>
        </div>
      </div>
    </div>
    <div id="panelParadas" class="panel">
      <button onclick="closeMenu()" class="close-button">
        <span class="material-symbols-rounded">close</span>
      </button>
      <h1>Paradas</h1>
      <p>Horarios y líneas de las paradas de autobús</p>
      <div class="block">
        <button class="boton boton-1" onclick="setAllParadas()">Mostrar todas las paradas</button>
      </div>
      <div class="block">
        <h2>Paradas cercanas</h2>
        <button class="boton boton-1" onclick="setParadaCursor()">Mostrar paradas a un punto</button>
        <p>o</p>
        <form id="searchParadas" onsubmit="searchParadas(event)" class="block">
          <input type="text" name="place" class="input" placeholder="Buscar paradas cercanas a zona o calle">
          <input type="number" name="number" class="input" placeholder="Nº calle (opcional)">
          <div class="block">
            <h2>Perímetro</h2>
            <!-- <label for="per">Perímetro:</label> -->
            <div class="block-h">
              <input id="per" type="range" name="per" min="100" max="1000" value="500" step="50"
                onchange="updateRange(event)">
              <span>
                <span id="per-value">500</span>m
              </span>
            </div>
            <button type="submit" class="boton">Buscar</button>
          </div>
        </form>
        <br>
      </div>
    </div>
    <div id="panelBicicleta" class="panel">
      <button onclick="closeMenu()" class="close-button">
        <span class="material-symbols-rounded">close</span>
      </button>
      <h1>Bicicletas</h1>
      <p>Detalles de las estaciones y las bicicletas disponibles</p>
      <div class="block">
        <h2>Leyenda</h2>
        <p class="green-emphasis">Zona ciclable</p>
        <p class="red-emphasis">Zona no ciclable</p>
      </div>
    </div>
    <div id="panelParkings" class="panel">
      <button onclick="closeMenu()" class="close-button">
        <span class="material-symbols-rounded">close</span>
      </button>
      <h1>Parkings</h1>
      <p>Encuentra aparcamiento cerca de ti</p>
      <form onsubmit="cancelarReserva(event)">
        <button class="boton boton-1" type="submit">Cancelar reservas activas</button>
      </form>
    </div>
    <div id="panelComoLlegar" class="panel">
      <button onclick="closeMenu()" class="close-button">
        <span class="material-symbols-rounded">close</span>
      </button>
      <h1>Cómo llegar</h1>
      <p>Seleccione dos puntos en el mapa para conocer el trayecto a seguir</p>
      <div class="block">
        <h2>Leyenda</h2>
        <p class="green-emphasis">Bus</p>
        <p class="red-emphasis">A pie</p>
      </div>
    </div>
    <div id="info">
      <div class="line"></div>
      <div class="info">
        <h2 id='nombre'></h2>
        <div id="detalles"></div>
        <button id="botonReservar" class="boton boton-1">Reservar parking</button>
      </div>
    </div>
  </aside>
  <div id="map"></div>
  <div class="modal">
    <div id="reservar" class="modal-card">
      <button onclick="hideAllReservar()" class="close-button">
        <span class="material-symbols-rounded">close</span>
      </button>
      <form onsubmit="makeReserva(event)">
        <h1>Reservar parking</h1>
        <p>Parking: Nombre del parking</p>
        <p>Dirección: Dirección del parking</p>
        <p>Estado: Disponible</p>
        <p>La reserva estará disponible durante media hora, si el usuario no accede al estacionamiento, la reserva se
          cancelará.</p>
        <p>Día:</p>
        <input type="date" name="fecha" required />
        <p>Hora:</p>
        <input type="time" name="hora" required />
        <button class="boton boton-1">Reservar</button>
      </form>
    </div>
    <div id="res-ok" class="modal-card">
      <button onclick="hideAllReservar()" class="close-button">
        <span class="material-symbols-rounded">close</span>
      </button>
      <h1>Reserva completada</h1>
      <p>La reserva se ha realizado con éxito</p>
      <button class="boton boton-1" onclick="downloadReserva()">Descargar resguardo</button>
    </div>
    <div id="res-nok" class="modal-card">
      <button onclick="hideAllReservar()" class="close-button">
        <span class="material-symbols-rounded">close</span>
      </button>
      <h1>Reserva fallida</h1>
      <p>Ya existe una reserva activa pendiente</p>
    </div>
  </div>
  <!-- JS -->
  <script src="/js/user.js"></script>
  <script src="/js/pdf.js"></script>
  <script src="/js/mapa.js"></script>
  <script src="/js/mapaPanel.js"></script>
  <script src="/js/mapaLineas.js"></script>
  <script src="/js/mapaParadas.js"></script>
  <script src="/js/mapaInfo.js"></script>
  <script src="/js/mapaBicis.js"></script>
  <script src="/js/mapaCL.js"></script>
  <script src="/js/mapaParkings.js"></script>
</body>

</html>