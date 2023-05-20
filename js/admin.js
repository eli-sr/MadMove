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
  console.log('bendita data', data)
  const response = document.getElementById('server-response')
  const xhr = new XMLHttpRequest()
  xhr.open('POST', apiLink)
  xhr.setRequestHeader('Content-Type', 'application/json')
  xhr.onload = () => {
    if (xhr.status === 200) {
      response.innerHTML = xhr.response
    }
  }
  xhr.send(JSON.stringify(data))
}

function clearData (tabla) {
  const response = document.getElementById('server-response')
  const xhr = new XMLHttpRequest()
  xhr.open('DELETE', '/pages/api/deleteData.php')
  xhr.onload = () => {
    if (xhr.status === 200) {
      response.innerHTML = xhr.response
    }
  }
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

function deleteUser (username) {
  console.log(username, 'cheee')
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
  // console.log(idDOM)
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
