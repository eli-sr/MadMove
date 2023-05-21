<?php
include_once "../../util/executeQuery.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header('Content-Type: application/json');
    // Establecer conexion
    // params: host,user,pass,dbname
    $conn = mysqli_connect('localhost', 'root', 'root', 'eli');
    if (!$conn) {
        http_response_code(500);
        die('Error de conexión: ' . mysqli_connect_error());
    }

    // Select data
    echo "[";
    $query = "SELECT * FROM RESERVAS";
    $resultado = executeQuery($query);
    // while
    $totalFilas = mysqli_num_rows($resultado);
    $contador = 0;
    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo '{"id":' . $fila['id'] .
            ',"date":"' . $fila['date'] .
            '","time":"' . $fila['time'] .
            '","parkingId":' . $fila['parkingId'] .
            ',"userId":' . $fila['userId'] .
            ',"done":' . $fila['done'] .
            '}';
        $contador++;
        // Verificar si es la última fila
        if ($contador == $totalFilas) {
            echo "]";
        } else {
            echo ",";
        }
    }
    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
} else {
    http_response_code(405);
    echo "Only GET requests";
}
?>