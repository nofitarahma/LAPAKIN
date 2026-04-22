const BASE_URL = 'http://127.0.0.1:8000/api'
let router = null

export function setRouter(r) {
  router = r
}

function getToken() {
  return localStorage.getItem('token')
}

async function request(method, path, body = null, isFormData = false) {
  const headers = { Accept: 'application/json' }
  const token = getToken()
  if (token) headers['Authorization'] = `Bearer ${token}`
  if (!isFormData) headers['Content-Type'] = 'application/json'

  const options = { method, headers }
  if (body) options.body = isFormData ? body : JSON.stringify(body)

  const res = await fetch(BASE_URL + path, options)
  const data = await res.json()
  if (!res.ok) {
    if (res.status === 401 && !path.includes('/payment/transfer')) {
      localStorage.removeItem('token')
      localStorage.removeItem('user')
      if (router) router.push('/login')
    }
    throw { status: res.status, data }
  }
  return data
}

export const api = {
  get:      (path)             => request('GET', path),
  post:     (path, body)       => request('POST', path, body),
  put:      (path, body)       => request('PUT', path, body),
  delete:   (path)             => request('DELETE', path),
  postForm: (path, formData)   => request('POST', path, formData, true),
}
