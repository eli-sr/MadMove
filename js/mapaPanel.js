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

function showPanel(panelShow, panelsHide) {
  panelsHide.forEach((panel) => {
    panel.style.opacity = 0
  })
  setTimeout(() => {
    panelShow.style.display = 'flex'
    panelsHide.forEach((panel) => {
      panel.style.display = 'none'
    })
  }, 200)
  setTimeout(() => {
    panelShow.style.opacity = 1
  }, 250)
}

function showLineas() {
  if (!menuOpen) openMenu()
  showPanel(panelLinea, [panelParadas, panelComoLlegar, panelBicicleta])
  clearGrupo()
  resetInfo()
}

function showParadas() {
  if (!menuOpen) openMenu()
  showPanel(panelParadas, [panelLinea, panelComoLlegar, panelBicicleta])
  clearGrupo()
  resetInfo()
}

function showBicis() {
  if (!menuOpen) openMenu()
  showPanel(panelBicicleta, [panelLinea, panelParadas, panelComoLlegar])
  clearGrupo()
  setEstaciones()
  resetInfo()
}

function showComoLlegar() {
  if (!menuOpen) openMenu()
  showPanel(panelComoLlegar, [panelLinea, panelParadas, panelBicicleta])
  clearGrupo()
  resetInfo()
  comoLlegar = true
}
