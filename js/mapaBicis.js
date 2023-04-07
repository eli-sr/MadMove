function setZonas(zonas) {
  zonas.forEach((zona) => {
    if (zona.canPark) L.geoJSON(zona.geometry, { color: 'green' }).addTo(grupo)
    else L.geoJSON(zona.geometry, { color: 'red' }).addTo(grupo)
  })
}

async function setEstaciones() {
  const linkZonas = 'https://openapi.emtmadrid.es/v1/transport/bicimadgo/zones/'
  const linkEst = 'https://openapi.emtmadrid.es/v1/transport/bicimad/stations/'
  const zonas = await getData(linkZonas)
  setZonas(zonas)
  const estaciones = await getData(linkEst)
  estaciones.forEach((estacion) => {
    setParada(estacion, grupoMC)
  })
  grupoMC.addTo(grupo)
}
