<?php
// Verificar si se recibió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // vars
  $inserted_ok = 0;
  $inserted_nok = 0;
  // Fetch data
  $data = json_decode(file_get_contents('php://input'), true);
  $allLines = $data["data"];

  // Establecer conexion
  // params: host,user,pass,dbname
  $conn = mysqli_connect('localhost', 'root', 'root', 'eli');
  if (!$conn) {
    http_response_code(500);
    die('Error de conexión: ' . mysqli_connect_error());
  }
  // Insertar data
  for ($i = 0; $i < count($allLines); $i++) {
    $lineData = $allLines[$i];
    $line = $lineData["line"];
    $label = $lineData["label"];
    $nameA = $lineData["nameA"];
    $nameB = $lineData["nameB"];
    $group = $lineData["group"];
    $query = "INSERT INTO LINEAS (line,label,nameA,nameB,`group`)
             VALUES('$line','$label','$nameA','$nameB','$group')";
    // Catch errores
    try {
      mysqli_query($conn, $query);
      // Datos insertados correctamente
      $inserted_ok += 1;
    } catch (mysqli_sql_exception $e) {
      // Ha ocurrido un error
      $inserted_nok += 1;
    }
  }
  // Return JSON
  echo '{"ok":' . $inserted_ok . ',"nok":' . $inserted_nok . '}';
  // Cerrar la conexión a la base de datos
  mysqli_close($conn);
} else {
  http_response_code(405);
  echo "Only POST requests";
}
?>