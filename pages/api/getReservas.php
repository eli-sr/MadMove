<?php
include_once "../../util/executeQuery.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header('Content-Type: application/json');
    // Get username
    // session_start();
    // if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['user'])) {
    //     $user = $_SESSION['user'];
    // } else {
    //     exit(-1);
    // }
    // Establecer conexion
    // params: host,user,pass,dbname
    $conn = mysqli_connect('localhost', 'root', 'root', 'eli');
    if (!$conn) {
        http_response_code(500);
        die('Error de conexión: ' . mysqli_connect_error());
    }

    // Select data
    echo "[";
    $query = "SELECT parkingId, COUNT(id) num
              FROM RESERVAS
              GROUP BY parkingId";
    $resultado = executeQuery($query);
    // while
    $totalFilas = mysqli_num_rows($resultado);
    $contador = 0;
    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo '{"parkingId":' . $fila['parkingId'] .
            ',"num":' . $fila['num'] .
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