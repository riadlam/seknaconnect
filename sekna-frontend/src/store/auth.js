import { defineStore } from 'pinia'
import axios from '../services/api'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token') || null,
  }),
  actions: {
    async login(credentials) {
      const res = await axios.post('/login', credentials)
      this.token = res.data.token
      this.user = res.data.user
      localStorage.setItem('token', this.token)
    },
    async logout() {
      await axios.post('/logout')
      this.token = null
      this.user = null
      localStorage.removeItem('token')
    },
    async fetchUser() {
      const res = await axios.get('/user')
      this.user = res.data
    }
  }
})
