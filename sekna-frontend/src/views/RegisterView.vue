<template>
  <div class="auth">
    <h2>Register</h2>
    <form @submit.prevent="register">
      <input v-model="form.name" type="text" placeholder="Full Name" required />
      <input v-model="form.email" type="email" placeholder="Email" required />
      <input v-model="form.password" type="password" placeholder="Password" required />
      <select v-model="form.role" required>
        <option disabled value="">Select Role</option>
        <option value="buyer">Buyer</option>
        <option value="professional">Professional</option>
      </select>
      <button type="submit">Register</button>
    </form>
    <p>Already have an account? <router-link to="/login">Login</router-link></p>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useAuthStore } from '../store/auth'
import { useRouter } from 'vue-router'

const auth = useAuthStore()
const router = useRouter()

const form = ref({
  name: '',
  email: '',
  password: '',
  role: ''
})

const register = async () => {
  try {
    await auth.register(form.value)
    router.push('/')
  } catch (error) {
    alert('Registration failed: ' + error.response.data.message)
  }
}
</script>
