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
      <select id="selectLinea" onchange="setLinea(this.value)">
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
      <button onclick="setLinea(null,1)">A -> B</button>
      <button onclick="setLinea(null,2)">B -> A</button>
    </div>
    <div id="panelParadas" class="panel">
      <form id="searchParadas" onsubmit="searchParadas(event)">
        <input type="text" name="place" placeholder="Buscar paradas cercanas a zona o calle">
        <input type="number" name="number" placeholder="Nº calle (opcional)">
        <label for="per">Perímetro:</label>
        <input id="per" type="range" name="per" min="100" max="1000" value="500" step="50"
          onchange="updateRange(event)">
        <p id="per-value">500</p>
        <button type="submit">Buscar</button>
      </form>
      <br>
      <button onclick="setAllParadas()">Mostrar todas las paradas</button>
      <button onclick="setParadaCursor()">Mostrar paradas a un punto</button>
    </div>
    <div id="panelComoLlegar" class="panel">
      <input type="text" name="place" placeholder="Elige un punto de partida en el mapa">
    </div>
    <div id="info">
      <h2 id='nombre'></h2>
      <div id="detalles"></div>
    </div>
  </aside>
  <div id="map" style="width: 100%; height: 100vh;"></div>
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