const selectLinea = document.getElementById('selectLinea')
const selectParadas = document.getElementById('selectParadas')

function showLineas() {
  selectLinea.style.display = 'flex'
  selectParadas.style.display = 'none'
  clearGrupo()
}

function showParadas() {
  selectLinea.style.display = 'none'
  selectParadas.style.display = 'flex'
  clearGrupo()
}

function showBicis() {
  selectLinea.style.display = 'none'
  selectParadas.style.display = 'none'
  clearGrupo()
  setEstaciones()
}
