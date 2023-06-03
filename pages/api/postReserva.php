<?php
// Verificar si se recibió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get username
    session_start();
    if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
    } else {
        exit(-1);
    }
    // Fetch data
    $entityBody = file_get_contents('php://input');
    $data = json_decode($entityBody);

    $parkingId = $data->parkingId;
    $fecha = $data->fecha;
    $hora = $data->hora;

    // Establecer conexion
    // params: host,user,pass,dbname
    $conn = mysqli_connect($_SERVER['DB_HOST'], $_SERVER['DB_USER'], $_SERVER['DB_PASSWORD'], $_SERVER['DB_NAME']);
    if (!$conn) {
        http_response_code(500);
        die('Error de conexión: ' . mysqli_connect_error());
    }

    // Get userId
    $query = "SELECT ID FROM USUARIOS WHERE USER='" . $user . "'";
    $resultado = mysqli_query($conn, $query);
    $fila = mysqli_fetch_assoc($resultado);
    $userId = $fila["ID"];

    // Comprobar reserva pendiente
    $query = "SELECT done FROM RESERVAS WHERE userId='" . $userId . "' AND done = 0";
    $resultado = mysqli_query($conn, $query);
    $fila = mysqli_fetch_assoc($resultado);
    if ($fila == null) {
        echo '{"ok":true}';
    } else {
        $done = $fila["done"];
        if (!$done) {
            echo '{"ok":false,"msg":"Ya hay activa una reserva pendiente"}';
            exit(-1);
        }
    }

    // Insertar data 
    $stmt = $conn->prepare("INSERT INTO RESERVAS(parkingId,date,time,userId,done)VALUES (?,?,?,?,0)");
    $stmt->bind_param("issi", $parkingId, $fecha, $hora, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);

} else {
    http_response_code(405);
    echo "Only POST requests";
}
?>