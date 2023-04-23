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
  <!-- Icons -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />
  <!-- Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
  <!-- CSS -->
  <link rel="stylesheet" href="/css/styles.css">
  <link rel="stylesheet" href="/css/mapa.css">
</head>

<body>
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
      <li>
        <button class="aside-button" onclick="showBicis()">
          <span class="material-symbols-rounded">pedal_bike</span>
          <p>Bicicletas</p>
        </button>
      </li>
      <li>
        <button class="aside-button" onclick="showComoLlegar()">
          <span class="material-symbols-rounded">route</span>
          <p>Cómo llegar</p>
        </button>
      </li>
    </ul>
  </aside>
  <aside class="aside-2">
    <div id="panelLinea" class="panel">
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
      <h1>Bicicletas</h1>
      <p>Detalles de las estaciones y las bicicletas disponibles</p>
      <div class="block">
        <h2>Leyenda</h2>
        <p class="green-emphasis">Zona ciclable</p>
        <p class="red-emphasis">Zona no ciclable</p>
      </div>
    </div>
    <div id="panelComoLlegar" class="panel">
      <h1>Cómo llegar</h1>
      <p>Detalles del trayecto a seguir</p>
      <div class="block">
        <h2>Leyenda</h2>
        <p class="green-emphasis">Bus</p>
        <p class="red-emphasis">A pie</p>
      </div>
    </div>
    <div id="info">
      <h2 id='nombre'></h2>
      <div id="detalles"></div>
    </div>
  </aside>
  <div id="map"></div>
  <script src="/js/api.js"></script>
  <script src="/js/mapa.js"></script>
  <script src="/js/mapaLineas.js"></script>
  <script src="/js/mapaParadas.js"></script>
  <script src="/js/mapaInfo.js"></script>
  <script src="/js/mapaBicis.js"></script>
  <script src="/js/mapaCL.js"></script>
  <script src="/js/mapaPanel.js"></script>
</body>

</html>