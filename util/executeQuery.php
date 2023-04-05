<?php
function executeQuery($query)
{
    // Establecer conexión con la base de datos
    $conn = mysqli_connect('localhost', 'root', 'root', 'eli');

    // Comprobar conexión
    if (!$conn) {
        http_response_code(500);
        die('Error de conexión: ' . mysqli_connect_error());
    }
    // Ejecutar consulta
    $resultado = mysqli_query($conn, $query);

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);

    // Comprobar si hubo algún error en la consulta
    if (!$resultado) {
        echo "Error al ejecutar la consulta: " . mysqli_error($conn);
        return false;
    }

    // Devolver el resultado de la consulta
    return $resultado;
}
?>