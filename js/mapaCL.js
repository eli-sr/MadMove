// INIT MAP
map.on('click', setMarks)

// GLOBAL VARS
let parada1 = null
let parada2 = null

// FUNCTIONS
async function getTrip (parada1, parada2) {
  const xFrom = parada1.lng
  const yFrom = parada1.lat
  const xTo = parada2.lng
  const yTo = parada2.lat
  const link = 'https://openapi.emtmadrid.es/v1/transport/busemtmad/travelplan/'
  const body = {
    routeType: 'P',
    itinerary: true,
    coordinateXFrom: xFrom,
    coordinateYFrom: yFrom,
    coordinateXTo: xTo,
    coordinateYTo: yTo,
    polygon: null,
    culture: 'es',
    allowBus: true,
    allowBike: false
  }
  const data = await getData(link, 'POST', body)
  return data
}

function getDuration (minutes) {
  return Math.round(minutes)
}

function getDistance (km) {
  return km.toFixed(2)
}

function showStep (step) {
  const stepData = step.properties
  const div = document.createElement('div')
  div.innerHTML = `${stepData.description}<br>`
  return div
}

function showSection (section) {
  console.log('sect', section)
  const div = document.createElement('div')
  switch (section.type) {
    case 'Walk':
      div.innerHTML = '<h3>A pie</h3>'
      break
    case 'Bus':
      div.innerHTML = '<h3>Bus</h3>'
      break
    default:
      break
  }
  div.innerHTML += `
      ${getDuration(section.duration)} min (${getDistance(section.distance)} km)<br>
    `
  // Showing every step info
  // Source
  if (section.type === 'Bus') {
    div.innerHTML += `
        <p>${section.source.properties.description}</p>
      `
  }
  // Steps
  section.route.features.forEach((step) => {
    div.append(showStep(step))
  })
  // Dest
  div.innerHTML += `
  <p>${section.destination.properties.description}</p>
  `
  return div
}

function showInfoTrip (trip) {
  // HTML Constants
  const nombre = document.getElementById('nombre')
  const infoHTML = document.getElementById('info')
  const detalles = document.getElementById('detalles')
  // Resetting info
  infoHTML.style.display = 'none'
  detalles.innerText = ''
  // Showing info
  nombre.innerText = 'Itinerario'
  detalles.innerHTML = `
    ${getDuration(trip.duration)} min (${getDistance(trip.distance)} km)<br>
    Salida: ${trip.departureTime}<br>
    Llegada: ${trip.arrivalTime}<br>
  `
  // Showing every section info
  trip.sections.forEach((section) => {
    detalles.append(showSection(section))
  })
  infoHTML.style.display = 'flex'
}

function setLineTrip (sections) {
  sections.forEach((section) => {
    const geojsonFeature = {
      type: 'Feature',
      geometry: section.itinerary,
      properties: {}
    }
    const color = section.type === 'Walk' ? 'orange' : '#485fc7'
    // Add lines
    L.geoJSON(geojsonFeature, { color }).addTo(grupo)
    // Add steps
    L.geoJSON(section.route, {
      onEachFeature: function (feature, layer) {
        layer.bindPopup(feature.properties.description)
      }
    }).addTo(grupo)

    map.fitBounds(grupo.getBounds())
  })
}

async function setMarks (event) {
  if (!comoLlegar) return
  if (!parada1) {
    addMarkMap(event)
    parada1 = event.latlng
  } else if (!parada2) {
    addMarkMap(event)
    parada2 = event.latlng
  }
  if (parada1 && parada2) {
    // Get trip
    showDetalles()
    setLoadingInfo(true)
    const trip = await getTrip(parada1, parada2)
    setLoadingInfo(false)
    showInfoTrip(trip)
    // Add lines & stops
    setLineTrip(trip.sections)
    // Reset
    comoLlegar = false
    parada1 = null
    parada2 = null
  }
}
