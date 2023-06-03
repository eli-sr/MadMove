<?php
// Verificar si se recibió una solicitud DELETE
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
  // Fetch data
  $tabla = file_get_contents('php://input');
  // Establecer conexion
  // params: host,user,pass,dbname
  $conn = mysqli_connect($_SERVER['DB_HOST'], $_SERVER['DB_USER'], $_SERVER['DB_PASSWORD'], $_SERVER['DB_NAME']);
  if (!$conn) {
    http_response_code(500);
    die('Error de conexión: ' . mysqli_connect_error());
  }
  // Eliminar data
  $query = "DELETE FROM " . $tabla . ";";
  // Catch errores
  try {
    mysqli_query($conn, $query);
    echo "[+] Datos eliminados correctamente <br>";
  } catch (mysqli_sql_exception $e) {
    echo "[-] Ha ocurrido un error: " . $e->getMessage() . "<br>";
  }
  // Cerrar la conexión a la base de datos
  mysqli_close($conn);
} else {
  http_response_code(405);
  echo "Only DELETE requests";
}
?>