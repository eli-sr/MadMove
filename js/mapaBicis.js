function setZonas (zonas) {
  zonas.forEach((zona) => {
    if (zona.canPark) L.geoJSON(zona.geometry, { color: 'green' }).addTo(grupo)
    else L.geoJSON(zona.geometry, { color: 'red' }).addTo(grupo)
  })
}

async function setEstaciones () {
  const linkZonas = 'https://openapi.emtmadrid.es/v1/transport/bicimadgo/zones/'
  const linkEst = 'https://openapi.emtmadrid.es/v1/transport/bicimad/stations/'
  const zonas = await getData(linkZonas)
  setZonas(zonas)
  const estaciones = await getData(linkEst)
  estaciones.forEach((estacion) => {
    setEstacion(estacion, grupoMC)
  })
  grupoMC.addTo(grupo)
}

async function showInfoEstacion (estacion) {
  showDetalles()
  // HTML Constants
  const nombre = document.getElementById('nombre')
  const infoHTML = document.getElementById('info')
  const detalles = document.getElementById('detalles')
  // Resetting info
  infoHTML.style.display = 'none'
  detalles.innerText = ''
  // Showing info
  nombre.innerText = estacion.name
  detalles.innerHTML = `
    Estación ${estacion.activate ? 'activa' : 'inactiva'} <br>
    Dirección: ${estacion.address}<br>
    Bicicletas estacionadas: ${estacion.dock_bikes}<br>
    Estaciones libres: ${estacion.free_bases}<br>
    Estaciones reservadas: ${estacion.reservations_count}<br>
    Ocupación COLORINESSS Y LOGOS: ${estacion.light}<br>
  `
  infoHTML.style.display = 'flex'
}
