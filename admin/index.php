<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <!-- Head Scripts -->
    <script>
    //   window.onload = async function() {
        const link = "https://openapi.emtmadrid.es/v1/mobilitylabs/user/login/"
        let accessToken
        // const test = await fetch(link, {
        fetch(link, {
            method: "GET",
            headers: {
                "X-ClientId": "1c01cca7-d37e-482f-8d97-8839b5d8a1ad",
                "passKey": "5B44D90F759F420484431EB3427A7289F2643DB45F71294B75277E403819687A23A81A42ADAEFEC798D6189632772E91A674079D53401900FFD0A16D64617519"
            }
        })
        .then(response => response.json())
        .then(json => {
            const data = json.data[0]
            accessToken = data.accessToken
        })
        // console.log("asunc",test.json())
    //   }
    </script>
</head>
<body>
    <button id="load-data">Cargar datos</button>
    <button>Limpiar datos</button>
    
    <!-- Body Scripts -->
    <script>
        const cargarDatosBtn = document.querySelector("#load-data");
        cargarDatosBtn.addEventListener("click", async () => {
            try {
                const link = "https://openapi.emtmadrid.es/v2/transport/busemtmad/lines/info/"
                const response = await fetch(link, {
                    method: "GET",
                    headers: {
                        "accessToken": accessToken
                    }
                }); 
                const data = await response.json();
                console.log("datos",data)
                sendToServer(data);
                } catch (error) {
                console.error(error);
            }
        });

        function sendToServer(data) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "/api/insertData.php"); 
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.send(JSON.stringify(data));
        }
    </script>
</body>
</html>