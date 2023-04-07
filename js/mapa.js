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

function clearLinea() {
  grupo.clearLayers()
  lineaDraw.geometry.coordinates = []
}

function setLineaDraw(parada) {
  const coordenadasL = parada.geometry.coordinates
  lineaDraw.geometry.coordinates.push(coordenadasL.reverse())
}

function setParada(parada) {
  const nombre = parada.name
  const coordenadasP = parada.geometry.coordinates
  var marcador = L.marker(coordenadasP.reverse()).addTo(grupo)
  marcador.bindPopup(nombre)
}

function setParadaLinea(parada) {
  setParada(parada)
  setLineaDraw(parada)
}

async function setLinea(value) {
  clearLinea()
  grupo = L.layerGroup().addTo(map)
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
  paradasArray.forEach((parada) => setParadaLinea(parada))
  L.geoJSON(lineaDraw, { color: 'green' }).addTo(grupo)
}

async function setAllParadas() {
  console.log('Mostrar cargando')
  const link = '/pages/api/getParadas.php'
  const response = await fetch(link, {
    method: 'GET',
    headers: {
      accessToken: accessToken
    }
  })
  const paradas = await response.json()
  console.log('Mostrar listo!')
  paradas.forEach((parada) => {
    setParada(parada)
  })
}

async function getParadas(place, n, range) {
  if (place.length === 0) return false
  let number = n.length === 0 ? '1' : n
  const link = `https://openapi.emtmadrid.es/v1/transport/busemtmad/stops/arroundstreet/${place}/${number}/${range}/`
  const response = await fetch(link, {
    method: 'GET',
    headers: {
      accessToken: accessToken
    }
  })
  const data = await response.json()
  return data.data
}

function updateRange(event) {
  const perValue = document.getElementById('per-value')
  perValue.innerHTML = event.target.value
}

async function searchParadas(event) {
  event.preventDefault()
  clearLinea()
  const form = event.target
  const place = form.querySelector('input[name="place"]').value
  const number = form.querySelector('input[name="number"]').value
  const range = form.querySelector('input[name="per"]').value
  const paradas = await getParadas(place, number, range)
  if (paradas) {
    paradas.forEach((parada) => {
      parada.name = parada.stopName
      delete parada.stopName
      setParada(parada)
    })
  }
}

function setZonas(zonas) {
  zonas.forEach((zona) => {
    if (zona.canPark) L.geoJSON(zona.geometry, { color: 'green' }).addTo(grupo)
    else L.geoJSON(zona.geometry, { color: 'red' }).addTo(grupo)
  })
}

// var grupoMC

function setEstacion(estacion) {
  const marcador = L.marker(estacion.geometry.coordinates.reverse())
  grupoMC.addLayer(marcador)
}

async function setEstaciones() {
  const linkZonas = 'https://openapi.emtmadrid.es/v1/transport/bicimadgo/zones/'
  const linkEst = 'https://openapi.emtmadrid.es/v1/transport/bicimad/stations/'
  const zonas = await getData(linkZonas)
  setZonas(zonas)
  const estaciones = await getData(linkEst)
  console.log(estaciones)
  // grupoMC = new L.MarkerClusterGroup({
  //   spiderfyOnMaxZoom: false,
  //   showCoverageOnHover: false
  // })
  estaciones.forEach((estacion) => {
    setEstacion(estacion)
  })
  grupoMC.addTo(grupo)
}
