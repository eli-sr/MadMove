<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus</title>
    <script>
      window.onload = function() {
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            // Procesar la respuesta de la API
            console.log(this.responseText);
          }
        };
        xhttp.open("GET", "https://openapi.emtmadrid.es/v2/transport/busemtmad/lines/info/", true);
        xhttp.setRequestHeader("accessToken", "94393cc2-ad19-11ed-a2e3-02dc46231d26");
        xhttp.send();
      };
    </script>
</head>
<body>
    <h1>Líneas</h1>
    
</body>
</html>