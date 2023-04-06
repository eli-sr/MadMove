<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $data_json = file_get_contents('php://input');
  $data_json = json_decode($data_json);
  $allLines = $data_json->data;

  $conn = mysqli_connect('localhost', 'root', 'root', 'eli');
  if (!$conn) {
    http_response_code(500);
    die('Error de conexión: ' . mysqli_connect_error());
  }
  // Insertar data
  for ($i = 0; $i < count($allLines); $i++) {
    $lineData = $allLines[$i];
    $geometry = json_encode($lineData->geometry);
    $name = $lineData->name;
    $id = $lineData->node;
    $lines = json_encode($lineData->lines);
    $query = "INSERT INTO PARADAS(id,name,geometry,lineas)
      VALUES($id,'$name','$geometry','$lines')";
    // Catch errores
    try {
      mysqli_query($conn, $query);
      echo "[+] Datos insertados correctamente <br>";
    } catch (mysqli_sql_exception $e) {
      echo "[-] Ha ocurrido un error: " . $e->getMessage() . "<br>";
    }
  }
  // Close connection
  mysqli_close($conn);
} else {
  http_response_code(405);
  echo "Only POST requests";
}
?>