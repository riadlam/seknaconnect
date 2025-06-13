import axios from 'axios'

const instance = axios.create({
  baseURL: 'http://192.168.1.8:8000/api', // your Laravel API
})

instance.interceptors.request.use(config => {
  const token = localStorage.getItem('token')
  if (token) config.headers.Authorization = `Bearer ${token}`
  return config
})

export default instance
