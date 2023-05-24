const panelLinea = document.getElementById('panelLinea')
const panelParadas = document.getElementById('panelParadas')
const panelComoLlegar = document.getElementById('panelComoLlegar')
const panelBicicleta = document.getElementById('panelBicicleta')
const panelParkings = document.getElementById('panelParkings')
const panelBienvenida = document.getElementById('panelBienvenida')
const aside2 = document.getElementsByClassName('aside-2')[0]

let menuOpen = false

function openMenu () {
  menuOpen = true
  aside2.style.animation = 'openMenu 500ms'
  aside2.style.left = '0'
}

function closeMenu () {
  menuOpen = false
  aside2.style.animation = 'closeMenu 500ms'
  setTimeout(() => (aside2.style.left = '-300px'), 500)
}

function showPanel (panelShow, panelsHide) {
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

function showLineas () {
  if (!menuOpen) openMenu()
  showPanel(panelLinea, [panelParadas, panelComoLlegar, panelBicicleta, panelParkings, panelBienvenida])
  hideDetalles()
  clearGrupo()
}

function showParadas () {
  if (!menuOpen) openMenu()
  showPanel(panelParadas, [panelLinea, panelComoLlegar, panelBicicleta, panelParkings, panelBienvenida])
  hideDetalles()
  clearGrupo()
}

function showBicis () {
  if (!menuOpen) openMenu()
  showPanel(panelBicicleta, [panelLinea, panelParadas, panelComoLlegar, panelParkings, panelBienvenida])
  hideDetalles()
  clearGrupo()
  setEstaciones()
}

function showComoLlegar () {
  if (!menuOpen) openMenu()
  showPanel(panelComoLlegar, [panelLinea, panelParadas, panelBicicleta, panelParkings, panelBienvenida])
  hideDetalles()
  clearGrupo()
  comoLlegar = true
}

function showParkings () {
  if (!menuOpen) openMenu()
  showPanel(panelParkings, [panelComoLlegar, panelLinea, panelParadas, panelBicicleta, panelBienvenida])
  hideDetalles()
  hideAllReservar()
  hideReservarButton()
  clearGrupo()
  setParkings()
}

function showBienvenida () {
  if (!menuOpen) openMenu()
  showPanel(panelBienvenida, [panelComoLlegar, panelLinea, panelParadas, panelBicicleta, panelParkings])
  hideDetalles()
  clearGrupo()
}

window.addEventListener('load', function () {
  showBienvenida()
})

function showDetalles () {
  // Panel shadow
  panelLinea.classList.add('no-shadow')
  panelParadas.classList.add('no-shadow')
  panelBicicleta.classList.add('no-shadow')
  panelComoLlegar.classList.add('no-shadow')
  panelParkings.classList.add('no-shadow')
  // Background
  aside2.classList.add('show')
}

function hideDetalles () {
  resetInfo()
  // Panel shadow
  panelLinea.classList.remove('no-shadow')
  panelParadas.classList.remove('no-shadow')
  panelBicicleta.classList.remove('no-shadow')
  panelComoLlegar.classList.remove('no-shadow')
  panelParkings.classList.remove('no-shadow')
  // Background
  aside2.classList.remove('show')
}
