const selectLinea = document.getElementById('panelLinea')
const selectParadas = document.getElementById('panelParadas')
const biciLegend = document.getElementsByClassName('bici-legend')[0]

function showLineas() {
  selectLinea.style.display = 'flex'
  selectParadas.style.display = 'none'
  biciLegend.style.display = 'none'
  clearGrupo()
}

function showParadas() {
  selectLinea.style.display = 'none'
  selectParadas.style.display = 'flex'
  biciLegend.style.display = 'none'
  clearGrupo()
}

function showBicis() {
  selectLinea.style.display = 'none'
  selectParadas.style.display = 'none'
  biciLegend.style.display = 'flex'
  clearGrupo()
  setEstaciones()
}
