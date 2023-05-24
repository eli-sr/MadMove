function setLineaDraw (parada) {
  const coordenadasL = parada.geometry.coordinates
  lineaDraw.geometry.coordinates.push(coordenadasL.reverse())
}

function setParadaLinea (parada) {
  setParada(parada, grupo)
  setLineaDraw(parada)
}

async function setLinea (value, dir = 1) {
  clearGrupo()
  let id = value
  if (!id) id = document.getElementById('selectLinea').value
  const link = `https://openapi.emtmadrid.es/v2/transport/busemtmad/lines/${id}/stops/${dir}/`
  setLoading(true)
  const data = await getData(link)
  setLoading(false)
  const paradas = data[0].stops
  paradas.forEach((parada) => setParadaLinea(parada))
  L.geoJSON(lineaDraw, { color: 'green' }).addTo(grupo)
  grupo.addTo(map)

  map.fitBounds(grupo.getBounds())
}
