<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar sesión</title>
</head>

<body>
  <h1>Iniciar sesión</h1>
  <form id="login-form" onsubmit="sendToServer(event)">
    <!-- <form action="/api/login.php" method="post"> -->
    <label for="user">Usuario:</label>
    <input type="text" id="user" name="user"><br>
    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password"><br>
    <input type="submit" value="Continuar">
  </form>

  <div id="server-response"></div>

  <!-- Body Scripts -->
  <script>
    function sendToServer(e) {
      e.preventDefault();
      const response = document.getElementById("server-response")
      const form = new FormData(document.getElementById("login-form"));
      const data = [...form.entries()].reduce((obj, [key, value]) => {
        obj[key] = value;
        return obj;
      }, {})
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "/api/login.php");
      xhr.setRequestHeader("Content-Type", "application/json");
      xhr.onload = () => {
        if (xhr.status === 200) {
          const response = JSON.parse(xhr.response)
          if (response.message === "ok") {
            console.log("tuqui =)")
            document.cookie = "user_session=" + response.sessionId + "; expires=" + new Date(Date.now() + 1800000).toUTCString() + "; path=/";
          }
          else {
            console.log("nonina")
          }
        }
      };
      xhr.send(JSON.stringify(data));
    }
  </script>
</body>

</html>