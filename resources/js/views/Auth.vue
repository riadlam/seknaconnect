<template>
  <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <router-link to="/" class="flex justify-center">
        <span class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
          SeknaConnect
        </span>
      </router-link>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
        {{ isLogin ? 'Connectez-vous à votre compte' : 'Créer un nouveau compte' }}
      </h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        {{ isLogin ? 'Ou' : 'Vous avez déjà un compte ?' }}
        <button @click="toggleAuthMode" class="font-medium text-purple-600 hover:text-purple-500 focus:outline-none focus:underline transition duration-150 ease-in-out">
          {{ isLogin ? 'créer un compte' : 'se connecter' }}
        </button>
      </p>
      
      <!-- Error Alert -->
      <div v-if="authError" class="mt-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-md">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <p class="text-sm text-red-700">{{ authError }}</p>
          </div>
        </div>
      </div>
      
      <!-- Success Message -->
      <div v-if="authSuccess" class="mt-4 p-4 bg-green-50 border-l-4 border-green-500 rounded-md">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <p class="text-sm text-green-700">{{ authSuccess }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow-xl rounded-lg sm:px-10">
        <form class="space-y-6" @submit.prevent="handleSubmit">
          <!-- Login Form -->
          <div v-if="isLogin" class="space-y-6">
            <div>
              <label for="login-email" class="block text-sm font-medium text-gray-700">
                Adresse e-mail
              </label>
              <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                  </svg>
                </div>
                <input 
                  id="login-email" 
                  v-model="loginForm.email" 
                  @input="clearError('email')"
                  name="email" 
                  type="email" 
                  autocomplete="email" 
                  required 
                  :class="[
                    'appearance-none block w-full pl-10 pr-3 py-2 border rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-1 sm:text-sm',
                    validationErrors.email 
                      ? 'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500' 
                      : 'border-gray-300 focus:ring-purple-500 focus:border-purple-500'
                  ]"
                  placeholder="vous@example.com"
                >
                <p v-if="validationErrors.email" class="mt-1 text-sm text-red-600">
                  {{ validationErrors.email }}
                </p>
              </div>
            </div>

            <div>
              <label for="login-password" class="block text-sm font-medium text-gray-700">
                Mot de passe
              </label>
              <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                  </svg>
                </div>
                <input 
                  id="login-password" 
                  v-model="loginForm.password" 
                  @input="clearError('password')"
                  name="password" 
                  type="password" 
                  autocomplete="current-password" 
                  required 
                  :class="[
                    'appearance-none block w-full pl-10 pr-3 py-2 border rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-1 sm:text-sm',
                    validationErrors.password 
                      ? 'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500' 
                      : 'border-gray-300 focus:ring-purple-500 focus:border-purple-500'
                  ]"
                  placeholder="••••••••"
                >
                <p v-if="validationErrors.password" class="mt-1 text-sm text-red-600">
                  {{ validationErrors.password }}
                </p>
              </div>
            </div>

            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <input 
                  id="remember-me" 
                  name="remember-me" 
                  type="checkbox" 
                  v-model="loginForm.remember"
                  class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                >
                <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                  Se souvenir de moi
                </label>
              </div>

              <div class="text-sm">
                <a href="#" class="font-medium text-purple-600 hover:text-purple-500 focus:outline-none focus:underline transition duration-150 ease-in-out">
                  Mot de passe oublié ?
                </a>
              </div>
            </div>
          </div>

          <!-- Register Form -->
          <div v-else class="space-y-6">
            <div>
              <label for="register-name" class="block text-sm font-medium text-gray-700">
                Nom complet
              </label>
              <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                  </svg>
                </div>
                <input 
                  id="register-name" 
                  v-model="registerForm.name" 
                  name="name" 
                  type="text" 
                  autocomplete="name" 
                  required 
                  class="appearance-none block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                  placeholder="Jean Dupont"
                >
              </div>
            </div>

            <div>
              <label for="register-email" class="block text-sm font-medium text-gray-700">
                Adresse e-mail
              </label>
              <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                  </svg>
                </div>
                <input 
                  id="register-email" 
                  v-model="registerForm.email" 
                  name="email" 
                  type="email" 
                  autocomplete="email" 
                  required 
                  class="appearance-none block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                  placeholder="vous@example.com"
                >
              </div>
            </div>

            <div>
              <label for="register-phone" class="block text-sm font-medium text-gray-700">
                Numéro de téléphone
              </label>
              <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                  </svg>
                </div>
                <input 
                  id="register-phone" 
                  v-model="registerForm.phone" 
                  @input="clearError('phone')"
                  name="phone" 
                  type="tel" 
                  autocomplete="tel" 
                  required 
                  :class="[
                    'appearance-none block w-full pl-10 pr-3 py-2 border rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-1 sm:text-sm',
                    validationErrors.phone 
                      ? 'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500' 
                      : 'border-gray-300 focus:ring-purple-500 focus:border-purple-500'
                  ]"
                  placeholder="ex: 0555123456"
                >
                <p v-if="validationErrors.phone" class="mt-1 text-sm text-red-600">
                  {{ validationErrors.phone }}
                </p>
              </div>
            </div>

            <div>
              <label for="register-password" class="block text-sm font-medium text-gray-700">
                Mot de passe
              </label>
              <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                  </svg>
                </div>
                <input 
                  id="register-password" 
                  v-model="registerForm.password" 
                  name="password" 
                  type="password" 
                  autocomplete="new-password" 
                  required 
                  class="appearance-none block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                  placeholder="••••••••"
                >
              </div>
            </div>

            <div>
              <label for="register-confirm-password" class="block text-sm font-medium text-gray-700">
                Confirmer le mot de passe
              </label>
              <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                  </svg>
                </div>
                <input 
                  id="register-confirm-password" 
                  v-model="registerForm.password_confirmation" 
                  name="password_confirmation" 
                  type="password" 
                  autocomplete="new-password" 
                  required 
                  class="appearance-none block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                  placeholder="••••••••"
                >
              </div>
            </div>

            <div class="flex items-start">
              <div class="flex items-center h-5">
                <input 
                  id="become-seller" 
                  v-model="registerForm.isSeller" 
                  name="become-seller" 
                  type="checkbox" 
                  class="focus:ring-purple-500 h-4 w-4 text-purple-600 border-gray-300 rounded"
                >
              </div>
              <div class="ml-3 text-sm">
                <label for="become-seller" class="font-medium text-gray-700">
                  Devenir vendeur
                </label>
                <p class="text-gray-500">
                  Cochez cette case si vous souhaitez proposer des biens à la vente ou à la location.
                </p>
              </div>
            </div>

            <!-- Seller Information (Conditional) -->
            <div v-if="registerForm.isSeller" class="mt-4 p-4 bg-purple-50 rounded-lg border-l-4 border-purple-600">
              <h3 class="text-sm font-medium text-purple-800 mb-3">Informations vendeur</h3>
              <div class="space-y-4">
                <div>
                  <label for="company-name" class="block text-sm font-medium text-gray-700">
                    Nom de l'entreprise (optionnel)
                  </label>
                  <div class="mt-1">
                    <input 
                      id="company-name" 
                      v-model="registerForm.companyName" 
                      type="text" 
                      class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                      placeholder="Nom de votre entreprise"
                    >
                  </div>
                </div>
                <div>
                  <label for="license-number" class="block text-sm font-medium text-gray-700">
                    Numéro de carte professionnelle (si applicable)
                  </label>
                  <div class="mt-1">
                    <input 
                      id="license-number" 
                      v-model="registerForm.licenseNumber" 
                      type="text" 
                      class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                      placeholder="Votre numéro de carte"
                    >
                  </div>
                </div>
              </div>
            </div>

            <div class="flex items-start">
              <div class="flex items-center h-5">
                <input 
                  id="terms" 
                  v-model="registerForm.agreeTerms" 
                  name="terms" 
                  type="checkbox" 
                  required
                  class="focus:ring-purple-500 h-4 w-4 text-purple-600 border-gray-300 rounded"
                >
              </div>
              <div class="ml-3 text-sm">
                <label for="terms" class="font-medium text-gray-700">
                  J'accepte les <a href="#" class="text-purple-600 hover:text-purple-500">Conditions d'utilisation</a> et la <a href="#" class="text-purple-600 hover:text-purple-500">Politique de confidentialité</a>
                </label>
              </div>
            </div>
          </div>

          <div>
            <button 
              type="submit" 
              class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200"
              :disabled="isLoading"
            >
              <svg v-if="isLoading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              {{ isLogin ? 'Se connecter' : 'Créer un compte' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex'; 
import axios from 'axios';

export default {
  name: 'Auth',
  setup() {
    const router = useRouter();
    const store = useStore();
    const isLogin = ref(true);
    const isLoading = ref(false);
    const authError = ref('');
    const authSuccess = ref('');
    const validationErrors = ref({});
    const showPassword = ref(false);
    
    // Login form data
    const loginForm = ref({
      email: '',
      password: '',
      remember: false
    });
    
    // Register form data
    const registerForm = ref({
      name: '',
      email: '',
      phone: '',
      password: '',
      password_confirmation: '',
      isSeller: false,
      companyName: '',
      license: '',
      bio: '',
      agreeTerms: false
    });
    
    // Check if user is already logged in
    onMounted(() => {
      if (store.getters['auth/isAuthenticated']) {
        router.push('/');
      }
    });
    
    // Clear errors when toggling between login/register
    const toggleAuthMode = () => {
      isLogin.value = !isLogin.value;
      authError.value = '';
      validationErrors.value = {};
      authSuccess.value = '';
    };
    
    // Clear error message when user starts typing
    const clearError = (field) => {
      if (field) {
        const newErrors = { ...validationErrors.value };
        delete newErrors[field];
        validationErrors.value = newErrors;
      } else {
        authError.value = '';
        validationErrors.value = {};
      }
    };
    
    // Handle field validation
    const validateField = (field, value) => {
      const errors = { ...validationErrors.value };
      
      if (!value || value.trim() === '') {
        errors[field] = `${field.charAt(0).toUpperCase() + field.slice(1)} is required`;
      } else {
        delete errors[field];
        
        // Email validation
        if (field === 'email') {
          const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          if (!emailRegex.test(value)) {
            errors[field] = 'Please enter a valid email address';
          }
        }
        
        // Password validation (for registration)
        if (field === 'password' && !isLogin.value) {
          if (value.length < 8) {
            errors[field] = 'Password must be at least 8 characters';
          } else if (!/[A-Z]/.test(value)) {
            errors[field] = 'Password must contain at least one uppercase letter';
          } else if (!/[0-9]/.test(value)) {
            errors[field] = 'Password must contain at least one number';
          }
        }
        
        // Password confirmation
        if (field === 'password_confirmation' && value !== registerForm.value.password) {
          errors[field] = 'Passwords do not match';
        }
        
        // Phone validation
        if (field === 'phone' && !isLogin.value) {
          const phoneRegex = /^[0-9]{10}$/;
          if (!phoneRegex.test(value)) {
            errors[field] = 'Please enter a valid 10-digit phone number';
          }
        }
      }
      
      validationErrors.value = errors;
      return Object.keys(errors).length === 0;
    };
    
    // Check if form is valid
    const isFormValid = (formData) => {
      console.log('Validating form data:', formData);
      const errors = {};
      
      // Common fields for both login and register
      if (!formData.email || formData.email.trim() === '') {
        errors.email = 'Email is required';
      } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
        errors.email = 'Please enter a valid email address';
      }
      
      if (!formData.password || formData.password.trim() === '') {
        errors.password = 'Password is required';
      } else if (formData.password.length < 8) {
        errors.password = 'Password must be at least 8 characters';
      }
      
      // Additional fields for registration
      if (!isLogin.value) {
        if (!formData.name || formData.name.trim() === '') {
          errors.name = 'Name is required';
        }
        
        // Clean phone number by removing all non-digit characters
        const cleanPhone = formData.phone ? formData.phone.replace(/\D/g, '') : '';
        
        if (!formData.phone || cleanPhone === '') {
          errors.phone = 'Phone number is required';
        } else if (!/^[0-9]{10,15}$/.test(cleanPhone)) {
          errors.phone = 'Please enter a valid phone number (10-15 digits)';
        } else {
          // Update the phone number with cleaned version
          registerForm.value.phone = cleanPhone;
        }
        
        if (formData.password !== formData.password_confirmation) {
          errors.password_confirmation = 'Passwords do not match';
        }
        
        if (!formData.agreeTerms) {
          errors.agreeTerms = 'You must agree to the terms and conditions';
        }
      }
      
      console.log('Validation errors:', errors);
      validationErrors.value = errors;
      return Object.keys(errors).length === 0;
    };
    
    // Handle form submission
    const handleSubmit = async () => {
      authError.value = '';
      authSuccess.value = '';
      validationErrors.value = {};
      
      // Validate form
      const formData = isLogin.value ? loginForm.value : registerForm.value;
      const isValid = isFormValid(formData);
      
      if (!isValid) {
        return;
      }
      
      isLoading.value = true;
      
      try {
        if (isLogin.value) {
          console.log('Attempting to login with:', loginForm.value.email);
          const loginSuccess = await store.dispatch('auth/login', {
            email: loginForm.value.email.trim(),
            password: loginForm.value.password,
            remember: loginForm.value.remember
          });
          
          console.log('Login result:', loginSuccess);
          
          if (loginSuccess) {
            // Only redirect if login was successful
            authSuccess.value = 'Login successful! Redirecting...';
            console.log('Login successful, redirecting...');
            router.push('/');
          } else {
            // Show error from the store
            const errorMsg = store.state.auth?.error || 'Login failed. Please check your credentials and try again.';
            console.error('Login failed:', errorMsg);
            authError.value = errorMsg;
            window.scrollTo({ top: 0, behavior: 'smooth' });
          }
          
          return;
        } else {
          // Handle registration
          await store.dispatch('auth/register', {
            name: registerForm.value.name,
            email: registerForm.value.email,
            phone: registerForm.value.phone,
            password: registerForm.value.password,
            password_confirmation: registerForm.value.password_confirmation,
            isSeller: registerForm.value.isSeller,
            company: registerForm.value.companyName,
            license: registerForm.value.license
          });
          
          // If we get here, registration was successful
          authSuccess.value = `Merci pour votre inscription. Votre compte est en attente de validation par un administrateur.
Une fois approuvé, vos produits seront visibles sur la plateforme.
Vous pouvez dès maintenant vous connecter pour gérer votre profil.`;
         isLogin.value = true;
          // Reset form
          registerForm.value = {
            name: '',
            email: '',
            phone: '',
            password: '',
            password_confirmation: '',
            isSeller: false,
            companyName: '',
            license: '',
            bio: '',
            agreeTerms: false
          };
          validationErrors.value = {};
        }
      } catch (error) {
        console.error('Authentication error:', error);
        // Handle errors from the store
        if (error.response && error.response.data.errors) {
          // Handle validation errors
          const errors = error.response.data.errors;
          for (const field in errors) {
            validationErrors.value[field] = errors[field][0];
          }
        } else if (error.response && error.response.data.message) {
          authError.value = error.response.data.message;
        } else {
          authError.value = error.message || 'An unexpected error occurred. Please try again.';
        }
      } finally {
        isLoading.value = false;
      }
    };
    
    return {
      isLogin,
      isLoading,
      loginForm,
      registerForm,
      authError,
      authSuccess,
      validationErrors,
      showPassword,
      toggleAuthMode,
      handleSubmit,
      validateField,
      clearError
    };
  }
};
</script>

<style scoped>
/* Custom styles if needed */
</style>
