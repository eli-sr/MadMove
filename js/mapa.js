// GLOBAL VARS
let accessToken
let lineaDraw = {
  type: 'Feature',
  geometry: {
    type: 'LineString',
    coordinates: []
  }
}
let paradaCursor = false

// INIT MAP
const map = L.map('map').setView([40.416, -3.7], 13)
let grupo = L.layerGroup().addTo(map)
let grupoMC = new L.MarkerClusterGroup({
  spiderfyOnMaxZoom: false,
  showCoverageOnHover: false,
  disableClusteringAtZoom: 15
})

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  maxZoom: 19
}).addTo(map)
addBiciLegend()

// FUNCTIONS
window.onload = async function () {
  accessToken = await getAccessToken()
}

function clearGrupo() {
  grupo.clearLayers()
  grupoMC.clearLayers()
  lineaDraw.geometry.coordinates = []
  paradaCursor = false
}

function setParada(parada, grupo) {
  const nombre = parada.name
  const coordenadas = parada.geometry.coordinates
  var marcador = L.marker(coordenadas.reverse()).addTo(grupo)
  marcador.on('click', () => showInfoParada(parada))
  marcador.bindPopup(nombre)
}

function setEstacion(estacion, grupo) {
  const nombre = estacion.name
  const coordenadas = estacion.geometry.coordinates
  var marcador = L.marker(coordenadas.reverse()).addTo(grupo)
  marcador.on('click', () => showInfoEstacion(estacion))
  marcador.bindPopup(nombre)
}

function addBiciLegend() {
  var legend = L.control({ position: 'bottomleft' })
  legend.onAdd = function (map) {
    var div = L.DomUtil.create('div', 'bici-legend')
    var redcir = '<svg width="20" height="20"><circle cx="10" cy="10" r="8" fill="red"/></svg>'
    var greencir = '<svg width="20" height="20"><circle cx="10" cy="10" r="8" fill="green"/></svg>'
    div.innerHTML = `
      <h4>Leyenda</h4>
      <ul>
        <li>${greencir} Zona de bicicletas permitidas</li>
        <li>${redcir} Zona de bicicletas prohibidas</li>
      </ul>
    `
    return div
  }
  legend.addTo(map)
}