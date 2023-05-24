// GLOBAL CONST
const reserva = {}
const modal = document.querySelector('.modal')
const reservar = document.getElementById('reservar')
const resOk = document.getElementById('res-ok')
const resNok = document.getElementById('res-nok')

function setParking (parking, grupo) {
  const nombre = parking.name
  const coordenadas = parking.geometry.coordinates
  const marcador = L.marker(coordenadas.reverse()).addTo(grupo)
  marcador.on('click', () => showInfoParking(parking))
  marcador.bindPopup(nombre)
}

async function setParkings () {
  const link = 'https://openapi.emtmadrid.es/v4/citymad/places/parkings/availability/'
  setLoading(true)
  const parkings = await getData(link)
  setLoading(false)
  parkings.forEach((parking) => {
    setParking(parking, grupoMC)
  })
  grupoMC.addTo(grupo)
}

function downloadReserva () {
  hideAllReservar()
  if (Object.entries(reserva).length === 0) return
  // Generar pdf
  GeneratePDF(reserva)
}

function cancelarReserva (e) {
  e.preventDefault()
  const result = confirm('Desea cancelar todas sus reservas?')
  if (!result) return
  fetch('/pages/api/deleteReserva.php', {
    method: 'POST'
  })
}

async function getUser () {
  const data = await fetch('/pages/api/getUser.php', {
    method: 'GET'
  })
  try {
    return await data.json()
  } catch {
    return null
  }
}

async function makeReserva (e) {
  e.preventDefault()
  // Get data
  const formData = new FormData(e.target)
  reserva.fecha = formData.get('fecha')
  reserva.hora = formData.get('hora')
  // Get user
  const user = await getUser()
  if (user) {
    reserva.user = user
  }
  // Upload to DB
  const link = '/pages/api/postReserva.php'
  const response = await fetch(link, {
    method: 'POST',
    body: JSON.stringify(reserva)
  })
  const result = await response.json()
  reservar.style.display = 'none'
  if (!result.ok) {
    resNok.style.display = 'flex'
  } else {
    resOk.style.display = 'flex'
  }
}

function showReservar (parking) {
  modal.style.display = 'flex'
  reservar.style.display = 'flex'
  reserva.parkingId = parking.id
  reserva.direccion = parking.address
  reserva.nombre = parking.name
  reserva.espacioLibre = parking.freeParking
  reserva.espacioTotal = parking.parkingSpaces
}

function hideAllReservar () {
  modal.style.display = 'none'
  reservar.style.display = 'none'
  resOk.style.display = 'none'
  resNok.style.display = 'none'
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
    reservaButton.onclick = () => showReservar(parking)
  }
  infoHTML.style.display = 'flex'
}
