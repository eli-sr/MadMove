// CONSTANTS
const nombre = document.getElementById('nombre')
const infoHTML = document.getElementById('info')
const detalles = document.getElementById('detalles')

async function getArrives(id) {
  const link = `https://openapi.emtmadrid.es/v2/transport/busemtmad/stops/${id}/arrives/`
  const body = { Text_EstimationsRequired_YN: 'Y' }
  const data = await getData(link, 'POST', body)
  const arrives = data[0].Arrive
  return arrives
}

async function getInfo(id) {
  const link = `https://openapi.emtmadrid.es/v1/transport/busemtmad/stops/${id}/detail/`
  const data = await getData(link)
  if (data[0].stops === undefined) return null
  return data[0].stops[0]
}

function getEA(estimateArrive) {
  let string
  if (estimateArrive === 999999) string = ' indefinido'
  else if (estimateArrive >= 60) string = Math.floor(estimateArrive / 60) + ' min'
  else string = estimateArrive + ' seg'
  return string
}

function getDB(DistanceBus) {
  let string
  if (DistanceBus >= 1000) string = Math.floor(DistanceBus / 1000) + ' km'
  else string = DistanceBus + ' m'
  return string
}

function resetInfo(){
  infoHTML.style.display = 'none'
  detalles.innerText = ''
}

async function showInfoParada(parada) {
  // Resetting info
  resetInfo()
  // Getting ID
  let id = parada.stop
  if (id === undefined) id = parada.id
  if (id === undefined) id = parada.stopId
  // Getting info
  const info = await getInfo(id)
  const arrives = await getArrives(id)
  // NO info
  if (!info) {
    nombre.innerText = parada.name
    const div = document.createElement('div')
    div.innerHTML = `No hay datos disponibles <br><br>`
    detalles.append(div)
    infoHTML.style.display = 'flex'
    return
  }
  // YES info
  // Setting info lines
  info.dataLine.forEach((linea) => {
    arrives.forEach((arrive) => {
      if (linea.estimateArrive === undefined) linea.estimateArrive = []
      if (linea.DistanceBus === undefined) linea.DistanceBus = []
      if (arrive.line === linea.label) {
        linea.destination = arrive.destination
        linea.estimateArrive.push(getEA(arrive.estimateArrive))
        linea.DistanceBus.push(getDB(arrive.DistanceBus))
      }
    })
  })
  // Showing info
  nombre.innerText = info.name
  detalles.innerHTML = `Dirección: ${info.postalAddress} <br>`
  info.dataLine.forEach((linea) => {
    const div = document.createElement('div')
    div.innerHTML = `
      Linea ${linea.label} <br>
      Origen: ${linea.headerA}<br>
      Destino: ${linea.headerB}<br>
      Destino2: ${linea.destination}<br>
      Tiempo de espera: ${linea.minFreq} min - ${linea.maxFreq} min<br>
      Horario: ${linea.startTime} - ${linea.stopTime}<br>
      Llegada en: ${linea.estimateArrive} <br>
      Distancia del bus: ${linea.DistanceBus} <br><br>
    `
    detalles.append(div)
  })
  infoHTML.style.display = 'flex'
}