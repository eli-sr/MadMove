<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // vars
  $inserted_ok = 0;
  $inserted_nok = 0;
  // Fetch data
  $data_json = file_get_contents('php://input');
  $data_json = json_decode($data_json);
  $allLines = $data_json->data;

  $conn = mysqli_connect($_SERVER['DB_HOST'], $_SERVER['DB_USER'], $_SERVER['DB_PASSWORD'], $_SERVER['DB_NAME']);
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