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

    $id = $data->id;
    $fecha = $data->fecha;
    $hora = $data->hora;

    echo '{"ok":"ok"}';

    // Establecer conexion
    // params: host,user,pass,dbname
    $conn = mysqli_connect('localhost', 'root', 'root', 'eli');
    if (!$conn) {
        http_response_code(500);
        die('Error de conexión: ' . mysqli_connect_error());
    }

    // Get Id
    $query = "SELECT ID FROM USUARIOS WHERE USER='" . $user . "'";
    $resultado = mysqli_query($conn, $query);
    $fila = mysqli_fetch_assoc($resultado);
    $userId = $fila["ID"];

    // Insertar data 
    $stmt = $conn->prepare("INSERT INTO RESERVAS VALUES (?,?,?,?)");
    $stmt->bind_param("issi", $id, $fecha, $hora, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);

} else {
    http_response_code(405);
    echo "Only POST requests";
}
?>