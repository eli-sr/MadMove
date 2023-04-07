async function setAllParadas() {
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

async function getParadas(place, n, range) {
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
  const paradas = await getParadas(place, number, range)
  if (paradas) {
    paradas.forEach((parada) => {
      parada.name = parada.stopName
      delete parada.stopName
      setParada(parada, grupoMC)
    })
  }
  grupoMC.addTo(grupo)
}