// GLOBAL VARS
let accessToken

// INIT DOC
window.onload = async function () {
  while (!accessToken) {
    try {
      accessToken = await getAccessToken()
    } catch {
      console.error('Error retrieving accessToken from openapi.emtmadrid.com. Trying again".')
    }
  }
}

// FUNCTIONS
async function getAccessToken () {
  let token
  // Token in cache?
  token = sessionStorage.getItem('accessToken')
  if (token) return token
  // Get token from api
  const link = 'https://openapi.emtmadrid.es/v1/mobilitylabs/user/login/'
  const response = await fetch(link, {
    method: 'GET',
    headers: {
      'X-ClientId': '1c01cca7-d37e-482f-8d97-8839b5d8a1ad',
      passKey:
        '5B44D90F759F420484431EB3427A7289F2643DB45F71294B75277E403819687A23A81A42ADAEFEC798D6189632772E91A674079D53401900FFD0A16D64617519'
    }
  })
  const json = await response.json()
  const data = json.data[0]
  token = data.accessToken
  // Save token in cache
  sessionStorage.setItem('accessToken', token)
  return token
}

function getData (url, method = 'GET', body) {
  return new Promise((resolve, reject) => {
    const request = {
      method: method.toLocaleUpperCase(),
      url,
      headers: {
        accessToken
      },
      success: (data) => {
        resolve(data.data)
      },
      error: (jqXHR, textStatus, errorThrown) => {
        reject(new Error('getData: ' + errorThrown))
      }
    }
    if (body !== undefined && method.toLocaleUpperCase() === 'POST') {
      request.data = JSON.stringify(body)
      request.contentType = 'application/json'
    }
    $.ajax(request)
  })
}
