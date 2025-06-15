<template>
  <div id="app">
    <Navbar v-if="!isAdminRoute" />
    
    <main :class="['min-h-screen', isAdminRoute ? 'bg-white' : 'bg-gray-50']">
      <router-view v-slot="{ Component }">
        <transition name="fade" mode="out-in">
          <component :is="Component" />
        </transition>
      </router-view>
    </main>

    <footer v-if="!isAdminRoute" class="bg-gray-800 text-white py-8">
      <div class="max-w-7xl mx-auto px-4">
        <div class="md:flex md:justify-between">
          <div class="mb-8 md:mb-0">
            <h2 class="text-2xl font-bold mb-4">SeknaConnect</h2>
            <p class="text-gray-400">Find your dream property with us</p>
          </div>
          <div class="grid grid-cols-2 gap-8 sm:grid-cols-3">
            <div>
              <h3 class="text-sm font-semibold uppercase tracking-wider">Company</h3>
              <ul class="mt-4 space-y-2">
                <li><a href="#" class="text-gray-400 hover:text-white">About</a></li>
                <li><a href="#" class="text-gray-400 hover:text-white">Careers</a></li>
                <li><a href="#" class="text-gray-400 hover:text-white">Contact</a></li>
              </ul>
            </div>
            <div>
              <h3 class="text-sm font-semibold uppercase tracking-wider">Legal</h3>
              <ul class="mt-4 space-y-2">
                <li><a href="#" class="text-gray-400 hover:text-white">Privacy</a></li>
                <li><a href="#" class="text-gray-400 hover:text-white">Terms</a></li>
                <li><a href="#" class="text-gray-400 hover:text-white">Cookie Policy</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="mt-8 border-t border-gray-700 pt-8">
          <p class="text-gray-400 text-sm text-center">&copy; 2023 SeknaConnect. All rights reserved.</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
import { computed } from 'vue';
import { useRoute } from 'vue-router';
import Navbar from './components/Navbar.vue';

export default {
  setup() {
    const route = useRoute();
    
    const isAdminRoute = computed(() => {
      return route.path.startsWith('/admin');
    });

    return {
      isAdminRoute
    };
  },
  name: 'App',
  components: {
    Navbar
  }
}
</script>

<style>
/* Global styles */
#app {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

/* Page transition effects */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* Smooth scrolling */
html {
  scroll-behavior: smooth;
}
</style>
