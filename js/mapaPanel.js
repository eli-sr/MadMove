const selectLinea = document.getElementById('selectLinea')
const selectParadas = document.getElementById('selectParadas')
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
