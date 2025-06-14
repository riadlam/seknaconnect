<template>
  <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
        {{ isLogin ? 'Sign in to your account' : 'Create a new account' }}
      </h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        {{ isLogin ? 'Or' : 'Already have an account?' }}
        <button 
          @click="toggleAuthMode" 
          class="font-medium text-purple-600 hover:text-purple-500 focus:outline-none focus:underline transition duration-150 ease-in-out"
        >
          {{ isLogin ? 'create a new account' : 'sign in' }}
        </button>
      </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow-xl rounded-lg sm:px-10">
        <form class="space-y-6" @submit.prevent="handleSubmit">
          <!-- Login Form -->
          <div v-if="isLogin" class="space-y-6">
            <div>
              <label for="login-email" class="block text-sm font-medium text-gray-700">
                Email address
              </label>
              <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                  </svg>
                </div>
                <input 
                  id="login-email" 
                  v-model="loginForm.email" 
                  name="email" 
                  type="email" 
                  autocomplete="email" 
                  required 
                  class="appearance-none block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                  placeholder="you@example.com"
                >
              </div>
            </div>

            <div>
              <label for="login-password" class="block text-sm font-medium text-gray-700">
                Password
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
                  name="password" 
                  type="password" 
                  autocomplete="current-password" 
                  required 
                  class="appearance-none block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                  placeholder="••••••••"
                >
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
                  Remember me
                </label>
              </div>

              <div class="text-sm">
                <a href="#" class="font-medium text-purple-600 hover:text-purple-500 focus:outline-none focus:underline transition duration-150 ease-in-out">
                  Forgot your password?
                </a>
              </div>
            </div>
          </div>

          <!-- Register Form -->
          <div v-else class="space-y-6">
            <div>
              <label for="register-name" class="block text-sm font-medium text-gray-700">
                Full Name
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
                  placeholder="John Doe"
                >
              </div>
            </div>

            <div>
              <label for="register-email" class="block text-sm font-medium text-gray-700">
                Email address
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
                  placeholder="you@example.com"
                >
              </div>
            </div>

            <div>
              <label for="register-phone" class="block text-sm font-medium text-gray-700">
                Phone Number
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
                  name="phone" 
                  type="tel" 
                  autocomplete="tel" 
                  required 
                  class="appearance-none block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                  placeholder="+1 (555) 123-4567"
                >
              </div>
            </div>

            <div>
              <label for="register-password" class="block text-sm font-medium text-gray-700">
                Password
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
                Confirm Password
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
                  Become a seller
                </label>
                <p class="text-gray-500">
                  Check this if you want to list properties for sale or rent.
                </p>
              </div>
            </div>

            <!-- Seller Information (Conditional) -->
            <div v-if="registerForm.isSeller" class="mt-4 p-4 bg-purple-50 rounded-lg border-l-4 border-purple-600">
              <h3 class="text-sm font-medium text-purple-800 mb-3">Seller Information</h3>
              <div class="space-y-4">
                <div>
                  <label for="company-name" class="block text-sm font-medium text-gray-700">
                    Company Name (Optional)
                  </label>
                  <div class="mt-1">
                    <input 
                      id="company-name" 
                      v-model="registerForm.companyName" 
                      type="text" 
                      class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                      placeholder="Your company name"
                    >
                  </div>
                </div>
                <div>
                  <label for="license-number" class="block text-sm font-medium text-gray-700">
                    Real Estate License Number (If applicable)
                  </label>
                  <div class="mt-1">
                    <input 
                      id="license-number" 
                      v-model="registerForm.licenseNumber" 
                      type="text" 
                      class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                      placeholder="Enter your license number"
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
                  I agree to the <a href="#" class="text-purple-600 hover:text-purple-500">Terms</a> and <a href="#" class="text-purple-600 hover:text-purple-500">Privacy Policy</a>
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
              {{ isLogin ? 'Sign in' : 'Create account' }}
            </button>
          </div>
        </form>

        <div class="mt-6">
          <div class="relative">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="px-2 bg-white text-gray-500">
                Or continue with
              </span>
            </div>
          </div>

          <div class="mt-6 grid grid-cols-3 gap-3">
            <div>
              <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                <span class="sr-only">Sign in with Google</span>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                  <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.477 0 10c0 4.42 2.865 8.167 6.839 9.49.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.155-1.11-1.462-1.11-1.462-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.527 2.34 1.086 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.11-4.555-4.94 0-1.092.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.268 2.75 1.025A9.564 9.564 0 0110 4.845c.85.004 1.705.114 2.504.336 1.909-1.293 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.591 1.028 2.683 0 3.84-2.34 4.683-4.566 4.93.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.578.688.48C17.14 18.162 20 14.418 20 10c0-5.523-4.477-10-10-10z" clip-rule="evenodd" />
                </svg>
              </a>
            </div>

            <div>
              <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                <span class="sr-only">Sign in with Facebook</span>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                  <path fill-rule="evenodd" d="M20 10c0-5.523-4.477-10-10-10S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z" clip-rule="evenodd" />
                </svg>
              </a>
            </div>

            <div>
              <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                <span class="sr-only">Sign in with Twitter</span>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                  <path d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84" />
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

export default {
  name: 'Auth',
  setup() {
    const router = useRouter();
    const isLogin = ref(true);
    const isLoading = ref(false);
    
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
      licenseNumber: '',
      agreeTerms: false
    });
    
    // Toggle between login and register forms
    const toggleAuthMode = () => {
      isLogin.value = !isLogin.value;
    };
    
    // Handle form submission
    const handleSubmit = async () => {
      isLoading.value = true;
      
      try {
        if (isLogin.value) {
          // Handle login logic
          console.log('Login form submitted:', loginForm.value);
          // Simulate API call
          await new Promise(resolve => setTimeout(resolve, 1000));
          // Redirect to dashboard or home after successful login
          router.push('/');
        } else {
          // Handle registration logic
          console.log('Register form submitted:', registerForm.value);
          // Simulate API call
          await new Promise(resolve => setTimeout(resolve, 1000));
          // Show success message and switch to login
          alert('Registration successful! Please log in.');
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
            licenseNumber: '',
            agreeTerms: false
          };
        }
      } catch (error) {
        console.error('Authentication error:', error);
        alert('An error occurred. Please try again.');
      } finally {
        isLoading.value = false;
      }
    };
    
    return {
      isLogin,
      isLoading,
      loginForm,
      registerForm,
      toggleAuthMode,
      handleSubmit
    };
  }
};
</script>

<style scoped>
/* Custom styles if needed */
</style>
