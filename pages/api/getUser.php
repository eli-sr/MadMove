<?php
include_once "../../util/executeQuery.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header('Content-Type: application/json');
    // Get username
    session_start();
    if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
    } else {
        exit(-1);
    }
    // Establecer conexion
    // params: host,user,pass,dbname
    $conn = mysqli_connect('localhost', 'root', 'root', 'eli');
    if (!$conn) {
        http_response_code(500);
        die('Error de conexión: ' . mysqli_connect_error());
    }
    // Select data
    $query = "SELECT * FROM USUARIOS WHERE USER='" . $user . "'";
    $resultado = executeQuery($query);
    $fila = mysqli_fetch_assoc($resultado);
    echo '{"id":' . $fila['ID'] .
        ',"user":"' . $fila['USER'] .
        '","name":"' . $fila['NAME'] .
        '","surname":"' . $fila['SURNAME'] .
        '"}';
    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
} else {
    http_response_code(405);
    echo "Only GET requests";
}
?>