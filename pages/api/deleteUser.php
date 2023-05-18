<?php
// Verificar si se recibió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    // Verificar que es el admin
    session_start();
    if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        if ($user != 'admin') {
            http_response_code(403);
            echo "Only admin requests";
            exit(-1);
        }
    }
    // Fetch data
    $username = $_GET["user"];

    // Revisar que no es admin
    if ($username == "admin")
        exit(-1);

    // Establecer conexion
    // params: host,user,pass,dbname
    $conn = mysqli_connect('localhost', 'root', 'root', 'eli');
    if (!$conn) {
        http_response_code(500);
        die('Error de conexión: ' . mysqli_connect_error());
    }
    // Eliminar usuario
    $query = "DELETE FROM USUARIOS WHERE USER = ?";
    $stmt = $conn->prepare($query);
    // $username = "carambola";
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt;
    print_r($result);

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);

    // Comprobar error
    if ($result->affected_rows == 0) {
        http_response_code(500);
        exit();
    } else {
        exit();
    }
} else {
    http_response_code(405);
    echo "Only DELETE requests";
}
?>