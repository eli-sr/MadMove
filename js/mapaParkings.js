// VARS
const reserva = {}

function setParking (parking, grupo) {
  const nombre = parking.name
  const coordenadas = parking.geometry.coordinates
  const marcador = L.marker(coordenadas.reverse()).addTo(grupo)
  marcador.on('click', () => showInfoParking(parking))
  marcador.bindPopup(nombre)
}

async function setParkings () {
  const link = 'https://openapi.emtmadrid.es/v4/citymad/places/parkings/availability/'
  const parkings = await getData(link)
  parkings.forEach((parking) => {
    setParking(parking, grupoMC)
  })
  grupoMC.addTo(grupo)
}

function downloadReserva () {
  const modal = document.querySelector('.modal')
  modal.style.display = 'none'
}

async function makeReserva (e) {
  e.preventDefault()
  const reservar = document.getElementById('reservar')
  const resOk = document.getElementById('res-ok')
  // Get data
  const formData = new FormData(e.target)
  reserva.fecha = formData.get('fecha')
  reserva.hora = formData.get('hora')
  // Upload to DB
  const link = '/pages/api/postReserva.php'
  const result = await getData(link, 'POST', reserva)

  // Change menu
  reservar.style.display = 'none'
  resOk.style.display = 'flex'
}

function showReservar (id) {
  const modal = document.querySelector('.modal')
  const reservar = document.getElementById('reservar')
  modal.style.display = 'flex'
  reservar.style.display = 'flex'
  reserva.id = id
}

async function showInfoParking (parking) {
  showDetalles()
  // HTML Constants
  const nombre = document.getElementById('nombre')
  const infoHTML = document.getElementById('info')
  const detalles = document.getElementById('detalles')
  const reservaButton = document.getElementById('botonReservar')
  // Resetting info
  infoHTML.style.display = 'none'
  reservaButton.style.display = 'none'
  detalles.innerText = ''
  // Showing info
  nombre.innerText = parking.name
  detalles.innerHTML = `
    ${parking.address} (Esto es la direccion)<br>
    Aparcamientos libres:
    ${parking.freeParking ?? '--'}/${parking.parkingSpaces}<br>
  `
  if (parking.freeParking) {
    reservaButton.style.display = 'flex'
    reservaButton.onclick = showReservar(parking.id)
  }
  infoHTML.style.display = 'flex'
}
