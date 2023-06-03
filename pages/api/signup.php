<?php
// Verificar si se recibió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch data
    $user = $_POST["user"];
    $password = $_POST["password"];
    $password_confirmation = $_POST["password-confirmation"];
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    
    // Comprobar contraseña
    if($password != $password_confirmation){
        header("Location: /pages/signup.php?password_error=1");
        exit();
    };

    // Establecer conexion
    // params: host,user,pass,dbname
    $conn = mysqli_connect($_SERVER['DB_HOST'], $_SERVER['DB_USER'], $_SERVER['DB_PASSWORD'], $_SERVER['DB_NAME']);
    if (!$conn) {
        http_response_code(500);
        die('Error de conexión: ' . mysqli_connect_error());
    }
    // Comprobar si el usuario ya existe
    $stmt = $conn->prepare("SELECT * FROM USUARIOS WHERE USER = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // El usuario ya existe en la base de datos.
        header("Location: /pages/signup.php?user_error=1");
        exit();
    } 

    // Insertar data 
    $stmt = $conn->prepare("INSERT INTO USUARIOS (USER,PASSWORD,NAME,SURNAME) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $user, $password, $name, $surname);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);

    // Iniciar sesión automáticamente 
    session_start();
    $_SESSION["user"] = $user;
    header("Location: /pages/mapa.php");
    exit();

} else {
    http_response_code(405);
    echo "Only POST requests";
}
?>