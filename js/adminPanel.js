const panelUsuarios = document.getElementById('panelUsuarios')
const panelReservas = document.getElementById('panelReservas')
const panelDB = document.getElementById('panelDB')

function showUsuarios () {
  panelReservas.style.display = 'none'
  panelDB.style.display = 'none'
  panelUsuarios.style.display = 'flex'
}

function showReservas () {
  panelUsuarios.style.display = 'none'
  panelDB.style.display = 'none'
  panelReservas.style.display = 'flex'
}

function showDB () {
  panelUsuarios.style.display = 'none'
  panelReservas.style.display = 'none'
  panelDB.style.display = 'flex'
}
