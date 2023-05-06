function setParking (parking, grupo) {
  const nombre = parking.name
  const coordenadas = parking.geometry.coordinates
  console.log(coordenadas)
  const marcador = L.marker(coordenadas.reverse()).addTo(grupo)
  marcador.on('click', () => showInfoParking(parking))
  marcador.bindPopup(nombre)
}

async function setParkings () {
  console.log('parkingsss')
  const link = 'https://openapi.emtmadrid.es/v4/citymad/places/parkings/availability/'
  const parkings = await getData(link)
  console.log(parkings)
  parkings.forEach((parking) => {
    setParking(parking, grupoMC)
  })
  grupoMC.addTo(grupo)
}

async function showInfoParking (parking) {
  showDetalles()
  // HTML Constants
  const nombre = document.getElementById('nombre')
  const infoHTML = document.getElementById('info')
  const detalles = document.getElementById('detalles')
  // Resetting info
  infoHTML.style.display = 'none'
  detalles.innerText = ''
  // Showing info
  nombre.innerText = parking.name
  detalles.innerHTML = `
    ${parking.address} (Esto es la direccion)<br>
    Aparcamientos libres:
    ${parking.freeParking ?? '--'}/${parking.parkingSpaces}<br>
  `
  infoHTML.style.display = 'flex'
}
