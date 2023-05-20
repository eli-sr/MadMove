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

    // Establecer conexion
    // params: host,user,pass,dbname
    $conn = mysqli_connect('localhost', 'root', 'root', 'eli');
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
    $query = "SELECT id FROM RESERVAS WHERE userId='" . $userId . "' AND done=0";
    $resultado = mysqli_query($conn, $query);
    $fila = mysqli_fetch_assoc($resultado);
    if ($fila == null) { // No hay reservas
        exit(0);
    } 
    // Eliminar data 
    print_r($fila);
    $id = $fila["id"];
    $stmt = $conn->prepare("UPDATE RESERVAS SET done=1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);

} else {
    http_response_code(405);
    echo "Only POST requests";
}
?>