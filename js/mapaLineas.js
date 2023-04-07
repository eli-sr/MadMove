function setLineaDraw(parada) {
  const coordenadasL = parada.geometry.coordinates
  lineaDraw.geometry.coordinates.push(coordenadasL.reverse())
}

function setParadaLinea(parada) {
  setParada(parada,grupo)
  setLineaDraw(parada)
}

async function setLinea(value) {
  clearGrupo()
  console.log('Mostrar cargando')
  const link = `https://openapi.emtmadrid.es/v2/transport/busemtmad/lines/${value}/stops/1/`
  const data = await getData(link)
  console.log(data)
  console.log('Mostrar listo!')
  const paradas = data[0].stops
  paradas.forEach((parada) => setParadaLinea(parada))
  L.geoJSON(lineaDraw, { color: 'green' }).addTo(grupo)
  grupo.addTo(map)
}