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
let linea = L.layerGroup().addTo(map)

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  maxZoom: 19
}).addTo(map)

// FUNCTIONS
window.onload = async function () {
  accessToken = await getAccessToken()
}

function clearLinea() {
  linea.clearLayers()
  lineaDraw.geometry.coordinates = []
}

function setLineaDraw(parada) {
  const coordenadasL = parada.geometry.coordinates
  lineaDraw.geometry.coordinates.push(coordenadasL.reverse())
}

function setParada(parada) {
  const nombre = parada.name
  const coordenadasP = parada.geometry.coordinates
  var marcador = L.marker(coordenadasP.reverse()).addTo(linea)
  marcador.bindPopup(nombre)
}

function setParadaLinea(parada) {
  setParada(parada)
  setLineaDraw(parada)
}

async function setLinea(value) {
  clearLinea()
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
  paradasArray.forEach((parada) => setParadaLinea(parada))
  L.geoJSON(lineaDraw, { color: 'green' }).addTo(linea)
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
