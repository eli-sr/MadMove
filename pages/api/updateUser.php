<?php
// Verificar si se recibió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch data
    $id = $_POST["id"];
    $user = $_POST["user"];
    $password = $_POST["password"];
    $password_confirmation = $_POST["password-confirmation"];
    $name = $_POST["name"];
    $surname = $_POST["surname"];

    // Comprobar contraseña
    if ($password != $password_confirmation) {
        header("Location: /pages/admin.php?password_error=1");
        exit();
    }

    // Comprobar que no es admin
    if ($user == "admin") {
        header("Location: /pages/admin.php?user_error=1");
        exit();
    }

    // Establecer conexion
    // params: host,user,pass,dbname
    $conn = mysqli_connect($_SERVER['DB_HOST'], $_SERVER['DB_USER'], $_SERVER['DB_PASSWORD'], $_SERVER['DB_NAME']);
    if (!$conn) {
        http_response_code(500);
        die('Error de conexión: ' . mysqli_connect_error());
    }

    // Insertar data 
    $query = "UPDATE USUARIOS 
              SET USER=?,PASSWORD=?,NAME=?,SURNAME=? 
              WHERE ID=?;";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $user, $password, $name, $surname, $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);

    // Redirigir a la pagina
    header("Location: /pages/admin.php");

} else {
    http_response_code(405);
    echo "Only POST requests";
}
?>