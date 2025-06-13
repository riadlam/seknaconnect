<template>
  <div class="auth">
    <h2>Login</h2>
    <form @submit.prevent="login">
      <input v-model="form.email" type="email" placeholder="Email" required />
      <input v-model="form.password" type="password" placeholder="Password" required />
      <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <router-link to="/register">Register</router-link></p>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useAuthStore } from '../store/auth'
import { useRouter } from 'vue-router'

const auth = useAuthStore()
const router = useRouter()

const form = ref({
  email: '',
  password: ''
})

const login = async () => {
  try {
    await auth.login(form.value)
    router.push('/') // or dashboard depending on role
  } catch (error) {
    alert('Login failed: ' + error.response.data.message)
  }
}
</script>
