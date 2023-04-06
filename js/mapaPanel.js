const selectLinea = document.getElementById('selectLinea')
const selectParadas = document.getElementById('selectParadas')

function showLineas() {
  selectLinea.style.display = 'flex'
  selectParadas.style.display = 'none'
  clearLinea()
}

function showParadas() {
  selectLinea.style.display = 'none'
  selectParadas.style.display = 'flex'
  clearLinea()
}

function showBicis() {
  selectLinea.style.display = 'none'
}
