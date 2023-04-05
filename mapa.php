<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
</head>

<body>
    <select onchange="setLinea(this.value)">
        <option value="">Selecciona una linea</option>
        <?php
        include_once "util/executeQuery.php";
        $query = "SELECT * FROM LINEAS";
        $resultado = executeQuery($query);
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<option value='" . $fila['line'] . "'>" . $fila['label'] . ": " . $fila['nameA'] . " - " . $fila['nameB'] . "</option>";
        }
        ?>
    </select>
    <div id="map" style="width: 100%; height: 500px;"></div>
    <script src="js/api.js"></script>
    <script src="mapa.js"></script>
</body>

</html>