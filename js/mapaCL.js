// INIT MAP
map.on('click', setMarks)

// GLOBAL VARS
let parada1 = null
let parada2 = null 

// FUNCTIONS
async function getTrip(parada1, parada2) {
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

function showInfoTrip(trip) {
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
    ${Math.round(trip.duration)} min (${trip.distance.toFixed(2)} km)<br>
    Salida: ${trip.departureTime}<br>
    Llegada: ${trip.arrivalTime}<br>
  `
  infoHTML.style.display = 'flex'
}

function setLineTrip(sections) {
  sections.forEach((section) => {
    let geojsonFeature = {
      type: 'Feature',
      geometry: section.itinerary,
      properties: {}
    }
    let color = section.type === 'Walk' ? 'orange' : 'green'
    // Add lines
    L.geoJSON(geojsonFeature, { color }).addTo(grupo)
    // Add steps
    L.geoJSON(section.route, {
      onEachFeature: function (feature, layer) {
        layer.bindPopup(feature.properties.description)
      }
    }).addTo(grupo)
  })
}

async function setMarks(event) {
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
    console.log('Mostar cargando!')
    const trip = await getTrip(parada1, parada2)
    console.log(trip)
    console.log('Mostar ok!')
    showInfoTrip(trip)
    // Add lines & stops
    setLineTrip(trip.sections)
    // Reset
    comoLlegar = false
    parada1 = null
    parada2 = null
  }
}
