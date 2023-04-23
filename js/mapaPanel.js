const panelLinea = document.getElementById('panelLinea')
const panelParadas = document.getElementById('panelParadas')
const panelComoLlegar = document.getElementById('panelComoLlegar')
const panelBicicleta = document.getElementById('panelBicicleta')
const aside2 = document.getElementsByClassName('aside-2')[0]

let menuOpen = false

function openMenu() {
  menuOpen = true
  aside2.style.animation = 'openMenu 500ms'
  aside2.style.left = '0'
}

function closeMenu() {
  menuOpen = false
  aside2.style.animation = 'closeMenu 500ms forwards'
  aside2.style.left = '-300px'
}

function showLineas() {
  if (!menuOpen) openMenu()
  panelLinea.style.display = 'flex'
  panelParadas.style.display = 'none'
  panelComoLlegar.style.display = 'none'
  panelBicicleta.style.display = 'none'
  clearGrupo()
  resetInfo()
}

function showParadas() {
  if (!menuOpen) openMenu()
  panelLinea.style.display = 'none'
  panelParadas.style.display = 'flex'
  panelComoLlegar.style.display = 'none'
  panelBicicleta.style.display = 'none'
  clearGrupo()
  resetInfo()
}

function showBicis() {
  if (!menuOpen) openMenu()
  panelLinea.style.display = 'none'
  panelParadas.style.display = 'none'
  panelComoLlegar.style.display = 'none'
  panelBicicleta.style.display = 'flex'
  clearGrupo()
  setEstaciones()
  resetInfo()
}

function showComoLlegar() {
  if (!menuOpen) openMenu()
  panelLinea.style.display = 'none'
  panelParadas.style.display = 'none'
  panelComoLlegar.style.display = 'flex'
  panelBicicleta.style.display = 'none'
  clearGrupo()
  resetInfo()
  comoLlegar = true
}
