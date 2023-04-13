// INIT MAP
map.on('click', showParadasCursor)

// FUNCTIONS
async function setAllParadas() {
  clearGrupo()
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
    try {
      setParada(parada, grupoMC)
    } catch (error) {}
  })
  grupoMC.addTo(grupo)
}

async function getParadasPlace(place, n, range) {
  if (place.length === 0) return false
  let number = n.length === 0 ? '1' : n
  const link = `https://openapi.emtmadrid.es/v1/transport/busemtmad/stops/arroundstreet/${place}/${number}/${range}/`
  const data = await getData(link)
  return data
}

function updateRange(event) {
  const perValue = document.getElementById('per-value')
  perValue.innerHTML = event.target.value
}

async function searchParadas(event) {
  event.preventDefault()
  clearGrupo()
  const form = event.target
  const place = form.querySelector('input[name="place"]').value
  const number = form.querySelector('input[name="number"]').value
  const range = form.querySelector('input[name="per"]').value
  const paradas = await getParadasPlace(place, number, range)
  if (paradas) {
    paradas.forEach((parada) => {
      parada.name = parada.stopName
      delete parada.stopName
      setParada(parada, grupoMC)
    })
  }
  grupoMC.addTo(grupo)
}

async function getParadasCursor(latlng, range) {
  const { lat, lng } = latlng
  const link = `https://openapi.emtmadrid.es/v2/transport/busemtmad/stops/arroundxy/${lng}/${lat}/${range}/`
  const data = await getData(link)
  return data
}

function setParadaCursor() {
  clearGrupo()
  paradaCursor = true
}

async function showParadasCursor(event) {
  if (!paradaCursor) return
  paradaCursor = false
  const range = document.getElementById('per').value
  addMarkMap(event)
  const paradas = await getParadasCursor(event.latlng, range)
  if (paradas) {
    paradas.forEach((parada) => {
      parada.name = parada.stopName
      delete parada.stopName
      setParada(parada, grupoMC)
    })
  }
  grupoMC.addTo(grupo)
}
