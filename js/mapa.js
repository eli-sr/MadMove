// GLOBAL VARS
let accessToken
let lineaDraw = {
  type: 'Feature',
  geometry: {
    type: 'LineString',
    coordinates: []
  }
}

// INIT MAP
const map = L.map('map').setView([40.416, -3.7], 13)
let grupo = L.layerGroup().addTo(map)
let grupoMC = new L.MarkerClusterGroup({
  spiderfyOnMaxZoom: false,
  showCoverageOnHover: false
})

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  maxZoom: 19
}).addTo(map)

// FUNCTIONS
window.onload = async function () {
  accessToken = await getAccessToken()
}

function clearGrupo() {
  grupo.clearLayers()
  grupoMC.clearLayers()
  lineaDraw.geometry.coordinates = []
}

function setParada(parada, grupo) {
  const nombre = parada.name
  const coordenadasP = parada.geometry.coordinates
  var marcador = L.marker(coordenadasP.reverse()).addTo(grupo)
  marcador.bindPopup(nombre)
}