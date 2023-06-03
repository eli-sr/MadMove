<?php
include_once "../../util/executeQuery.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header('Content-Type: application/json');
    // Establecer conexion
    // params: host,user,pass,dbname
    $conn = mysqli_connect($_SERVER['DB_HOST'], $_SERVER['DB_USER'], $_SERVER['DB_PASSWORD'], $_SERVER['DB_NAME']);
    if (!$conn) {
        http_response_code(500);
        die('Error de conexión: ' . mysqli_connect_error());
    }
    // 
    echo "[";
    // Select data
    $query = "SELECT * FROM PARADAS";
    $resultado = executeQuery($query);
    while ($fila = mysqli_fetch_assoc($resultado)) {
        // $fila = json_encode($fila);
        // echo $fila . "<br>";
        echo '{"id":' . $fila['id'] .
            ',"name":"' . $fila['name'] .
            '","lineas":' . $fila['lineas'] .
            ',"geometry":' . $fila['geometry'] .
            '},';
    }
    echo "{}]";
    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
} else {
    http_response_code(405);
    echo "Only GET requests";
}
?>