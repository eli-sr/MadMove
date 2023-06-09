// GLOBAL VARS
const lineaDraw = {
  type: 'Feature',
  geometry: {
    type: 'LineString',
    coordinates: []
  }
}
let paradaCursor = false
let comoLlegar = false

// INIT MAP
const map = L.map('map').setView([40.416, -3.7], 13)
const grupo = L.featureGroup().addTo(map)
const grupoMC = new L.MarkerClusterGroup({
  spiderfyOnMaxZoom: false,
  showCoverageOnHover: false,
  disableClusteringAtZoom: 17
})

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  maxZoom: 19
}).addTo(map)
map.zoomControl.remove()
L.control.zoom({ position: 'bottomright' }).addTo(map)

// FUNCTIONS
function clearGrupo () {
  grupo.clearLayers()
  grupoMC.clearLayers()
  lineaDraw.geometry.coordinates = []
  paradaCursor = false
  comoLlegar = false
}

function setParada (parada, grupo) {
  const nombre = parada.name
  const coordenadas = parada.geometry.coordinates
  const icon = L.icon({
    iconUrl: '/img/bus.png',
    iconSize: [25, 25]
  })
  const marcador = L.marker(coordenadas.reverse(), { icon }).addTo(grupo)
  marcador.on('click', () => showInfoParada(parada))
  marcador.bindPopup(nombre)
}

function setEstacion (estacion, grupo) {
  const nombre = estacion.name
  const coordenadas = estacion.geometry.coordinates
  const icon = L.icon({
    iconUrl: '/img/bike.png',
    iconSize: [30, 38]
  })
  const marcador = L.marker(coordenadas.reverse(), { icon }).addTo(grupo)
  marcador.on('click', () => showInfoEstacion(estacion))
  marcador.bindPopup(nombre)
}

function addMarkMap (event) {
  L.marker(event.latlng).addTo(grupo)
}

function setLoading (loading) {
  const loadingHTML = document.querySelector('.loading')
  if (loading) {
    loadingHTML.style.display = 'flex'
  } else {
    loadingHTML.style.display = 'none'
  }
}

function setLoadingInfo (loading) {
  const loadingHTML = document.querySelector('.loading-info')
  if (loading) {
    loadingHTML.style.display = 'flex'
  } else {
    loadingHTML.style.display = 'none'
  }
}
