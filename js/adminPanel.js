const panelUsuarios = document.getElementById('panelUsuarios')
const panelReservas = document.getElementById('panelReservas')

function showUsuarios () {
  panelReservas.style.display = 'none'
  panelUsuarios.style.display = 'flex'
}

function showReservas () {
  panelUsuarios.style.display = 'none'
  panelReservas.style.display = 'flex'
}
