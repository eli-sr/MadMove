async function getAccessToken () {
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
  return data.accessToken
}

async function getData (link, method = 'GET', body) {
  try {
    const request = {
      method,
      headers: {
        accessToken
      }
    }
    if (body !== undefined && method === 'POST') request.body = JSON.stringify(body)
    const response = await fetch(link, request)
    const data = await response.json()
    return data.data
  } catch (error) {
    console.error(error)
  }
}
