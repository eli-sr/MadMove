const panelLinea = document.getElementById('panelLinea')
const panelParadas = document.getElementById('panelParadas')
const panelComoLlegar = document.getElementById('panelComoLlegar')
const biciLegend = document.getElementsByClassName('bici-legend')[0]

function showLineas() {
  panelLinea.style.display = 'flex'
  panelParadas.style.display = 'none'
  panelComoLlegar.style.display = 'none'
  biciLegend.style.display = 'none'
  clearGrupo()
}

function showParadas() {
  panelLinea.style.display = 'none'
  panelParadas.style.display = 'flex'
  panelComoLlegar.style.display = 'none'
  biciLegend.style.display = 'none'
  clearGrupo()
}

function showBicis() {
  panelLinea.style.display = 'none'
  panelParadas.style.display = 'none'
  panelComoLlegar.style.display = 'none'
  biciLegend.style.display = 'flex'
  clearGrupo()
  setEstaciones()
}

function showComoLlegar() {
  panelLinea.style.display = 'none'
  panelParadas.style.display = 'none'
  panelComoLlegar.style.display = 'flex'
  biciLegend.style.display = 'none'
  clearGrupo()
  comoLlegar = true
}
