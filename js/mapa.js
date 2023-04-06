let accessToken
window.onload = async function () {
  accessToken = await getAccessToken()
}
const map = L.map('map').setView([40.416, -3.7], 13)
let linea
let lineaDraw = {
  type: 'Feature',
  geometry: {
    type: 'LineString',
    coordinates: []
  }
}

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  maxZoom: 19
}).addTo(map)

function clearLinea() {
  linea.clearLayers()
  lineaDraw.geometry.coordinates = []
}

function setParada(parada) {
  const nombre = parada.name
  const coordenadasP = parada.geometry.coordinates
  const coordenadasL = coordenadasP.slice()
  lineaDraw.geometry.coordinates.push(coordenadasL)
  var marcador = L.marker(coordenadasP.reverse()).addTo(linea)
  marcador.bindPopup(nombre)
}

async function setLinea(value) {
  typeof linea !== 'undefined' && clearLinea()
  linea = L.layerGroup().addTo(map)
  console.log('Mostrar cargando')
  const link = `https://openapi.emtmadrid.es/v2/transport/busemtmad/lines/${value}/stops/1/`
  const response = await fetch(link, {
    method: 'GET',
    headers: {
      accessToken: accessToken
    }
  })
  const data = (await response.json()).data[0]
  console.log('Mostrar listo!')
  const paradasArray = data.stops
  paradasArray.forEach((parada) => setParada(parada))
  L.geoJSON(lineaDraw, { color: 'green' }).addTo(linea)
}
