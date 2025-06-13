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

    async register(data) {
      const res = await axios.post('/register', data)
      this.token = res.data.token
      this.user = res.data.user
      localStorage.setItem('token', this.token)
    },

    async logout() {
      await axios.post('/logout')
      this.user = null
      this.token = null
      localStorage.removeItem('token')
    },

    async fetchUser() {
      const res = await axios.get('/user')
      this.user = res.data
    }
  }
})
