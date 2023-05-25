async function getData (link, method = 'GET') {
  try {
    const response = await fetch(link, {
      method,
      headers: {
        accessToken
      }
    })
    const data = await response.json()
    return data
  } catch (error) {
    console.error(error)
  }
}

function insertData (data, apiLink) {
  const response = document.getElementById('server-response')
  const xhr = new XMLHttpRequest()
  xhr.open('POST', apiLink)
  xhr.setRequestHeader('Content-Type', 'application/json')
  xhr.onload = () => {
    if (xhr.status === 200) {
      const json = JSON.parse(xhr.response)
      response.innerHTML = `<p class="green-emphasis">${json.ok} filas reinsertadas</p>`
    }
  }
  xhr.send(JSON.stringify(data))
}

function clearData (tabla) {
  const response = document.getElementById('server-response')
  const xhr = new XMLHttpRequest()
  xhr.open('DELETE', '/pages/api/deleteData.php')
  xhr.send(tabla)
}

async function cargarParadas () {
  const link = 'https://openapi.emtmadrid.es/v1/transport/busemtmad/stops/list/'
  const apiLink = '/pages/api/insertParadas.php'
  const data = await getData(link, 'POST')
  insertData(data, apiLink)
}

async function cargarLineas () {
  const link = 'https://openapi.emtmadrid.es/v2/transport/busemtmad/lines/info/'
  const apiLink = '/pages/api/insertLineas.php'
  const data = await getData(link)
  insertData(data, apiLink)
}

function limpiarParadas () {
  clearData('PARADAS')
}

function limpiarLineas () {
  clearData('LINEAS')
}

function resetParadas () {
  limpiarParadas()
  cargarParadas()
}

function resetLineas () {
  limpiarLineas()
  cargarLineas()
}

// EDIT USERS

function deleteUser (username) {
  if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
    // Realizar una solicitud AJAX para eliminar el usuario
    const xhr = new XMLHttpRequest()
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          location.reload()
        }
        if (xhr.status === 500) {
          const errorHTML = document.querySelector('.red-emphasis')
          errorHTML.textContent = 'Ha ocurrido un error inseperado'
        }
      }
    }
    xhr.open('DELETE', '/pages/api/deleteUser.php?user=' + username, true)
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
    xhr.send()
  }
}

function closeEdit () {
  const modal = document.querySelector('.modal')
  const card = document.querySelector('.modal-card')
  modal.style.display = 'none'
  card.style.display = 'none'
}

function editUser (id, username, name, surname, password) {
  const modal = document.querySelector('.modal')
  const card = document.querySelector('.modal-card')
  const nameDOM = document.querySelector("input[name='name']")
  const surnameDOM = document.querySelector("input[name='surname']")
  const userDOM = document.querySelector("input[name='user']")
  const passDOM = document.querySelector("input[name='password']")
  const passConDOM = document.querySelector("input[name='password-confirmation']")
  const idDOM = document.querySelector("input[name='id']")
  //
  modal.style.display = 'flex'
  card.style.display = 'flex'
  userDOM.value = username
  nameDOM.value = name
  surnameDOM.value = surname
  passDOM.value = password
  passConDOM.value = password
  idDOM.value = id

  if (username === 'admin') {
    userDOM.readOnly = true
    userDOM.style.opacity = 0.5
  } else {
    userDOM.readOnly = false
    userDOM.style.opacity = 1
  }
}

// CHARTS

window.addEventListener('load', async () => {
  await generateChart()
})

async function generateChart () {
  const response = await fetch('/pages/api/getReservas.php', {
    method: 'GET'
  })

  const result = await response.json()

  const labels = result.map((parking) => {
    return parking.parkingId
  })
  const data = result.map((parking) => {
    return parking.num
  })

  // Crea el gráfico
  const ctx = document.getElementById('myChart').getContext('2d')
  const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels,
      datasets: [
        {
          label: 'Reservas',
          data,
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1
        }
      ]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  })
}

async function downloadCSV (filename, url) {
  const data = await fetch(url, { method: 'GET' })
  const json = await data.json()
  const csv = json2csv(json)
  const link = document.createElement('a')
  link.style.display = 'none'
  link.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv)
  link.download = filename
  document.body.appendChild(link)
  link.click()
  document.body.removeChild(link)
}

async function downloadUsuariosCSV () {
  const filename = 'usuarios.csv'
  const link = '/pages/api/getUsers.php'
  downloadCSV(filename, link)
}

async function downloadReservasCSV () {
  const filename = 'reservas.csv'
  const link = '/pages/api/getAllReservas.php'
  downloadCSV(filename, link)
}

async function downloadParadasCSV () {
  const filename = 'paradas.csv'
  const link = '/pages/api/getParadas.php'
  downloadCSV(filename, link)
}

async function downloadLineasCSV () {
  const filename = 'lineas.csv'
  const link = '/pages/api/getLineas.php'
  downloadCSV(filename, link)
}

function json2csv (data) {
  const lines = []
  const header = Object.keys(data[0])
  lines.push(header)
  data.forEach((reserva) => {
    const line = Object.values(reserva)
    lines.push(line)
  })
  const csv = lines.map((line) => line.join(',')).join('\n')
  return csv
}
