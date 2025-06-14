<template>
  <nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <!-- Logo -->
        <div class="flex items-center">
          <router-link to="/" class="flex-shrink-0 flex items-center">
            <span class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
              SeknaConnect
            </span>
          </router-link>
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden md:ml-6 md:flex md:items-center md:space-x-8">
          <router-link 
            v-for="item in navItems" 
            :key="item.name" 
            :to="item.href"
            class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200"
            :class="[isActive(item.href) 
              ? 'border-purple-600 text-gray-900' 
              : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700']"
          >
            {{ item.name }}
          </router-link>
          
          <!-- Auth Buttons -->
          <div class="ml-6 flex items-center space-x-4">
            <router-link 
              to="/login" 
              class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-purple-600 transition-colors"
            >
              Sign In
            </router-link>
            <router-link 
              to="/register" 
              class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-indigo-600 rounded-md hover:from-purple-700 hover:to-indigo-700 transition-colors shadow-sm"
            >
              Get Started
            </router-link>
          </div>
        </div>

        <!-- Mobile menu button -->
        <div class="-mr-2 flex items-center md:hidden">
          <button 
            @click="isOpen = !isOpen"
            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-purple-500"
            aria-expanded="false"
          >
            <span class="sr-only">Open main menu</span>
            <svg 
              class="h-6 w-6" 
              :class="{'hidden': isOpen, 'block': !isOpen}" 
              xmlns="http://www.w3.org/2000/svg" 
              fill="none" 
              viewBox="0 0 24 24" 
              stroke="currentColor" 
              aria-hidden="true"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg 
              class="h-6 w-6" 
              :class="{'hidden': !isOpen, 'block': isOpen}" 
              xmlns="http://www.w3.org/2000/svg" 
              fill="none" 
              viewBox="0 0 24 24" 
              stroke="currentColor" 
              aria-hidden="true"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile menu -->
    <div 
      class="md:hidden transition-all duration-300 ease-in-out overflow-hidden" 
      :class="{'max-h-0': !isOpen, 'max-h-96': isOpen}"
    >
      <div class="pt-2 pb-3 space-y-1">
        <router-link
          v-for="item in navItems"
          :key="`mobile-${item.name}`"
          :to="item.href"
          @click="isOpen = false"
          class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors duration-200"
          :class="[isActive(item.href) 
            ? 'bg-purple-50 border-purple-500 text-purple-700' 
            : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800']"
        >
          {{ item.name }}
        </router-link>
        <div class="pt-4 pb-3 border-t border-gray-200">
          <div class="mt-3 space-y-1">
            <router-link
              to="/login"
              @click="isOpen = false"
              class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100"
            >
              Sign in
            </router-link>
            <router-link
              to="/register"
              @click="isOpen = false"
              class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100"
            >
              Create account
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'Navbar',
  data() {
    return {
      isOpen: false,
      navItems: [
        { name: 'Home', href: '/' },
        { name: 'Properties', href: '/properties' },
        { name: 'About', href: '/about' },
        { name: 'Contact', href: '/contact' }
      ]
    }
  },
  methods: {
    isActive(route) {
      return this.$route.path === route;
    },
    closeMenu() {
      this.isOpen = false;
    }
  },
  watch: {
    $route() {
      this.closeMenu();
    }
  }
}
</script>

<style scoped>
/* Add any custom styles here */
</style>
