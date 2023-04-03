<?php
// Verificar si se recibió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch data
    $data = json_decode(file_get_contents('php://input'), true);
    $user = $data["user"];
    $password = $data["password"];
    // Establecer conexion
    // params: host,user,pass,dbname
    $conn = mysqli_connect('localhost', 'root', 'root', 'eli');
    if (!$conn) {
        http_response_code(500);
        die('Error de conexión: ' . mysqli_connect_error());
    }
    // Comprobar data 
    $stmt = $conn->prepare("SELECT * FROM USUARIOS WHERE USER = ? AND PASSWORD = ?");
    $stmt->bind_param("ss", $user, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $response = array(
            'message' => 'ok',
            'sessionId' => 'abc123'
        );
    } else {
        $response = array(
            'message' => 'nok',
        );
    }
    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    http_response_code(405);
    echo "Only POST requests";
}
?>