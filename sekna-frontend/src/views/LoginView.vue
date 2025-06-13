<template>
  <form @submit.prevent="login">
    <input v-model="form.email" placeholder="Email" />
    <input v-model="form.password" type="password" placeholder="Password" />
    <button type="submit">Login</button>
  </form>
</template>

<script setup>
import { ref } from 'vue'
import { useAuthStore } from '../store/auth'
import { useRouter } from 'vue-router'

const auth = useAuthStore()
const router = useRouter()
const form = ref({ email: '', password: '' })

const login = async () => {
  try {
    await auth.login(form.value)
    router.push('/')
  } catch (e) {
    alert('Login failed')
  }
}
</script>
