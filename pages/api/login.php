<?php
// Verificar si se recibió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch data
    $user = $_POST["user"];
    $password = $_POST["password"];
    // Establecer conexion
    // params: host,user,pass,dbname
    $conn = mysqli_connect('localhost', 'root', 'root', 'eli');
    if (!$conn) {
        http_response_code(500);
        die('Error de conexión: ' . mysqli_connect_error());
    }
    // Obtener data 
    $stmt = $conn->prepare("SELECT * FROM USUARIOS WHERE USER = ? AND PASSWORD = ?");
    $stmt->bind_param("ss", $user, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
    // Comprobar data
    if ($result->num_rows == 1) {
        session_start();
        $_SESSION["user"] = $user;
        header("Location: /index.php");
        exit();
    } else {
        header("Location: /login.php?login_error=1");
        exit();
    }
} else {
    http_response_code(405);
    echo "Only POST requests";
}
?>