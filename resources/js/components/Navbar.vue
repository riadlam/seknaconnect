<template>
  <nav class="sticky top-0 z-50 transition-all duration-300" :class="{ 'bg-white/90 backdrop-blur-md shadow-md': isScrolled, 'bg-transparent': !isScrolled }">
    <!-- Decorative elements -->
    <div class="absolute inset-0 bg-gradient-to-b from-black/5 to-transparent opacity-0 transition-opacity duration-300" :class="{ 'opacity-100': !isScrolled }"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <!-- Logo -->
        <div class="flex items-center">
          <router-link to="/" class="flex-shrink-0 flex items-center group">
            <span class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent transition-all duration-300 transform group-hover:scale-105">
              SeknaConnect
            </span>
          </router-link>
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden md:ml-6 md:flex md:items-center md:space-x-4">
          <!-- Search Button (Mobile) -->
          <div class="relative md:hidden">
            <button @click="toggleSearch" class="p-2 rounded-full text-gray-500 hover:text-purple-600 hover:bg-gray-100 transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </button>
          </div>

          <!-- Search Bar (Desktop) -->
          <div class="hidden md:block relative w-64 transition-all duration-300" :class="{ 'w-72': isSearchFocused }">
            <div class="relative rounded-full bg-white/80 backdrop-blur-sm border border-gray-200 shadow-sm">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
              </div>
              <input
                type="text"
                v-model="searchQuery"
                @focus="onSearchFocus"
                @blur="onSearchBlur"
                @input="onSearchInput"
                class="block w-full pl-10 pr-3 py-2 border-0 bg-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-0 sm:text-sm rounded-full"
                placeholder="Rechercher des biens..."
              />
              <div v-if="isLoading" class="absolute inset-y-0 right-0 flex items-center pr-3">
                <svg class="animate-spin h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
              </div>
              <div v-else-if="searchQuery" class="absolute inset-y-0 right-0 flex items-center pr-3">
                <button @click.prevent="clearSearch" class="text-gray-400 hover:text-gray-500">
                  <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
            </div>

            <!-- Search Results Dropdown -->
            <div v-if="searchQuery && isSearchFocused" class="absolute z-10 mt-1 w-full rounded-md bg-white shadow-lg max-h-96 overflow-auto">
              <div class="p-4 border-b border-gray-100">
                <p class="text-sm text-gray-500">Résultats pour "{{ searchQuery }}"</p>
              </div>
              <div v-if="isLoading" class="p-4 flex justify-center">
                <svg class="animate-spin h-5 w-5 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
              </div>
              <div v-else-if="searchResults.length > 0" class="py-1">
                <router-link 
                  v-for="result in searchResults" 
                  :key="result.id" 
                  :to="`/properties/${result.id}`"
                  class="block px-4 py-3 hover:bg-gray-50 cursor-pointer transition-colors border-b border-gray-100 last:border-b-0"
                >
                  <div class="flex items-start">
                    <div class="flex-shrink-0 h-16 w-16 rounded-md overflow-hidden bg-gray-100">
                      <img 
                        v-if="result.images && result.images.length > 0"
                        :src="result.images[0].image_path" 
                        :alt="result.name"
                        class="h-full w-full object-cover"
                      />
                      <div v-else class="h-full w-full bg-gray-200 flex items-center justify-center">
                        <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                      </div>
                    </div>
                    <div class="ml-3 flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-900 truncate">{{ result.name }}</p>
                      <p class="text-sm text-gray-500">
                        {{ result.housing_type }} · {{ formatPrice(result.price) }}
                      </p>
                      <p class="text-xs text-gray-400 mt-1 truncate">
                        {{ getLocation(result.location) }}
                      </p>
                    </div>
                  </div>
                </router-link>
              </div>
              <div v-else-if="!isLoading" class="p-4 text-center text-sm text-gray-500">
                Aucun résultat trouvé
              </div>
            </div>
          </div>
          <div v-for="item in navItems" :key="item.name" class="relative group">
            <router-link 
              :to="item.href"
              class="inline-flex items-center px-3 py-2 text-sm font-medium transition-all duration-300 relative z-10"
              :class="[isActive(item.href) 
                ? 'text-purple-700' 
                : 'text-gray-700 hover:text-purple-600']"
            >
              {{ item.name }}
              <span 
                class="absolute -bottom-1 left-0 w-full h-0.5 bg-purple-600 transform origin-left transition-all duration-300 scale-x-0"
                :class="{ 'scale-x-100': isActive(item.href), 'group-hover:scale-x-100': !isActive(item.href) }"
              ></span>
            </router-link>
          </div>
          
          <!-- Auth Buttons -->
          <div class="ml-4 flex items-center space-x-4">
            <template v-if="!isAuthenticated">
              <router-link 
                to="/auth" 
                class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-purple-600 transition-all duration-300 relative group"
              >
                <span class="relative z-10">Connexion</span>
                <span class="absolute inset-0 bg-gradient-to-r from-purple-50 to-transparent opacity-0 group-hover:opacity-100 rounded-md transition-opacity duration-300"></span>
              </router-link>
              <router-link 
                to="/auth" 
                class="relative px-6 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-indigo-600 rounded-full hover:from-purple-700 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl hover:shadow-purple-200 overflow-hidden group"
              >
                <span class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                <span class="relative z-10 flex items-center">
                  Commencer
                  <svg class="ml-1.5 w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                  </svg>
                </span>
              </router-link>
            </template>
            <template v-else>
              <!-- Simple profile dropdown with logout -->
              <div class="relative ml-3">
                <button 
                  @click="toggleUserMenu" 
                  type="button" 
                  class="flex items-center justify-center h-8 w-8 rounded-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                  aria-label="Menu utilisateur"
                >
                  {{ userInitial }}
                </button>
                
                <!-- Enhanced dropdown with dashboard and logout -->
                <transition
                  enter-active-class="transition ease-out duration-100"
                  enter-from-class="transform opacity-0 scale-95"
                  enter-to-class="transform opacity-100 scale-100"
                  leave-active-class="transition ease-in duration-75"
                  leave-from-class="transform opacity-100 scale-100"
                  leave-to-class="transform opacity-0 scale-95"
                >
                  <div 
                    v-if="showUserMenu" 
                    class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                    @click.stop
                  >
                    <div class="py-1" role="menu">
                      <router-link
                        to="/admin/dashboard"
                        @click="showUserMenu = false"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 flex items-center"
                        role="menuitem"
                      >
                        <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Tableau de bord
                      </router-link>
                      <div class="border-t border-gray-100 my-1"></div>
                      <button
                        @click="handleLogout"
                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center"
                        role="menuitem"
                      >
                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Se déconnecter
                      </button>
                    </div>
                  </div>
                </transition>
              </div>
            </template>
          </div>
        </div>

        <!-- Mobile menu button -->
        <div class="-mr-2 flex items-center md:hidden">
          <button 
            @click="isOpen = !isOpen"
            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-purple-500"
            aria-expanded="false"
          >
            <span class="sr-only">Ouvrir le menu principal</span>
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
  </nav>
</template>

<script>
import { ref, onMounted, onUnmounted, nextTick, computed, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';
import { useStore } from 'vuex';

export default {
  name: 'Navbar',
  setup() {
    const route = useRoute();
    const router = useRouter();
    const store = useStore();
    const isOpen = ref(false);
    const isSearchFocused = ref(false);
    const searchQuery = ref('');
    const isScrolled = ref(false);
    const lastScrollY = ref(0);
    const navHidden = ref(false);
    const showMobileSearch = ref(false);
    const showUserMenu = ref(false);
    const isInitialized = ref(false);
    const searchResults = ref([]);
    const isLoading = ref(false);
    const searchTimeout = ref(null);

    // Search functionality
    const formatPrice = (price) => {
      if (!price) return '';
      return new Intl.NumberFormat('fr-DZ', {
        style: 'currency',
        currency: 'DZD',
        maximumFractionDigits: 0
      }).format(price);
    };

    const getLocation = (location) => {
      if (!location) return '';
      try {
        const loc = JSON.parse(location);
        return [loc.wilaya, loc.commune, loc.daira].filter(Boolean).join(', ');
      } catch (e) {
        return location;
      }
    };

    const searchProjects = async (query) => {
      if (!query.trim()) {
        searchResults.value = [];
        return;
      }

      isLoading.value = true;
      try {
        const response = await axios.get(`/api/projects/search?q=${encodeURIComponent(query)}`);
        searchResults.value = response.data;
      } catch (error) {
        console.error('Search error:', error);
        searchResults.value = [];
      } finally {
        isLoading.value = false;
      }
    };

    const onSearchInput = () => {
      clearTimeout(searchTimeout.value);
      searchTimeout.value = setTimeout(() => {
        searchProjects(searchQuery.value);
      }, 300); // 300ms debounce
    };

    const onSearchFocus = () => {
      isSearchFocused.value = true;
      if (searchQuery.value) {
        searchProjects(searchQuery.value);
      }
    };

    const onSearchBlur = () => {
      // Small delay to allow click on results before hiding
      setTimeout(() => {
        isSearchFocused.value = false;
      }, 200);
    };

    const clearSearch = () => {
      searchQuery.value = '';
      searchResults.value = [];
    };

    // Clean up timeouts on component unmount
    onUnmounted(() => {
      if (searchTimeout.value) {
        clearTimeout(searchTimeout.value);
      }
    });

    // Check for existing auth data in storage
    const checkAuthStatus = async () => {
      try {
        // Check both localStorage and sessionStorage
        const storedUser = localStorage.getItem('user') || sessionStorage.getItem('user');
        const storedToken = localStorage.getItem('token') || sessionStorage.getItem('token');
        
        if (storedUser && storedToken) {
          try {
            const user = JSON.parse(storedUser);
            // Use the checkAuth action instead of directly mutating state
            await store.dispatch('auth/checkAuth', { 
              user, 
              token: storedToken 
            });
            // Set auth header for subsequent requests
            if (axios && axios.defaults) {
              axios.defaults.headers.common['Authorization'] = `Bearer ${storedToken}`;
            }
          } catch (e) {
            console.error('Error parsing user data:', e);
            store.dispatch('auth/logout');
          }
        } else if (store.getters['auth/isAuthenticated']) {
          // If no token in storage but store thinks we're authenticated, log out
          store.dispatch('auth/logout');
        }
      } catch (error) {
        console.error('Auth check error:', error);
      } finally {
        isInitialized.value = true;
      }
    };
    
    // Initialize auth check
    onMounted(() => {
      checkAuthStatus();
    });
    
    // Computed properties
    const isAuthenticated = computed(() => {
      // Only check the store, as it should be the source of truth
      return store.getters['auth/isAuthenticated'];
    });
    
    const userInitial = computed(() => {
      // Get user from store first, then fall back to storage
      let user = store.state.auth.user;
      if (!user) {
        try {
          const storedUser = localStorage.getItem('user') || sessionStorage.getItem('user');
          if (storedUser) {
            user = JSON.parse(storedUser);
          }
        } catch (e) {
          console.error('Error parsing stored user:', e);
        }
      }
      if (!user || !user.name) return 'U';
      return user.name
        .split(' ')
        .map(n => n[0])
        .join('')
        .toUpperCase()
        .substring(0, 2);
    });
    const userRole = computed(() => {
      if (store.state.auth.user?.role) {
        return store.state.auth.user.role;
      }
      try {
        const storedUser = localStorage.getItem('user') || sessionStorage.getItem('user');
        if (storedUser) {
          return JSON.parse(storedUser)?.role || '';
        }
      } catch (e) {
        console.error('Error getting user role:', e);
      }
      return 'Visiteur';
    });
    
    // Toggle user menu
    const toggleUserMenu = () => {
      showUserMenu.value = !showUserMenu.value;
    };
    
    // Close user menu when clicking outside
    const handleClickOutside = (event) => {
      const profileButton = event.target.closest('button[aria-label="Menu utilisateur"]');
      const dropdownMenu = event.target.closest('.profile-dropdown');
      
      if (!profileButton && !dropdownMenu) {
        showUserMenu.value = false;
      }
    };
    
    // Handle logout
    const handleLogout = async () => {
      try {
        await store.dispatch('auth/logout');
        showUserMenu.value = false;
        router.push('/');
      } catch (error) {
        console.error('Logout error:', error);
      }
    };
    
    // Close menu when route changes
    const closeAllMenus = () => {
      isOpen.value = false;
      showUserMenu.value = false;
    };
    
    // Add event listener for outside clicks
    onMounted(() => {
      document.addEventListener('click', handleClickOutside);
      router.afterEach(closeAllMenus);
    });
    
    // Clean up event listener
    onUnmounted(() => {
      document.removeEventListener('click', handleClickOutside);
    });

    const navItems = [
      { name: 'Accueil', href: '/' },
      { name: 'Biens', href: '/properties' },
      { name: 'À propos', href: '/about' },
      { name: 'Contact', href: '/contact' }
    ];

    const isActive = (path) => {
      return route.path === path;
    };

    const closeMenu = () => {
      isOpen.value = false;
    };

    const toggleSearch = () => {
      showMobileSearch.value = !showMobileSearch.value;
      if (showMobileSearch.value) {
        // Focus the search input when toggled on mobile
        nextTick(() => {
          document.querySelector('.mobile-search-input')?.focus();
        });
      }
    };

    const handleScroll = () => {
      // Show/hide navbar on scroll
      const currentScrollY = window.scrollY;
      
      // Add background when scrolled
      isScrolled.value = currentScrollY > 10;
      
      // Hide navbar when scrolling down, show when scrolling up
      if (currentScrollY > 100) {
        if (currentScrollY > lastScrollY.value && !isOpen.value) {
          navHidden.value = true;
        } else {
          navHidden.value = false;
        }
      } else {
        navHidden.value = false;
      }
      
      lastScrollY.value = currentScrollY;
    };

    onMounted(() => {
      window.addEventListener('scroll', handleScroll, { passive: true });
    });

    onUnmounted(() => {
      window.removeEventListener('scroll', handleScroll);
    });

    return {
      isOpen,
      isSearchFocused,
      searchQuery,
      showMobileSearch,
      isScrolled,
      navItems,
      isActive,
      closeMenu,
      clearSearch,
      toggleSearch,
      navHidden,
      isAuthenticated,
      userInitial,
      userRole,
      showUserMenu,
      toggleUserMenu,
      handleLogout,
      searchResults,
      isLoading,
      onSearchInput,
      onSearchFocus,
      onSearchBlur,
      formatPrice,
      getLocation
    };
  }
}
</script>

<style scoped>
/* Navbar animations */
nav {
  transition: transform 0.3s ease-in-out, background-color 0.3s ease, box-shadow 0.3s ease;
  will-change: transform, background-color, box-shadow;
}

/* Hide/show animation */
.nav-hidden {
  transform: translateY(-100%);
  box-shadow: none !important;
}

/* Mobile menu animations */
.mobile-menu-enter-active,
.mobile-menu-leave-active {
  transition: max-height 0.5s ease-in-out, opacity 0.3s ease;
  overflow: hidden;
}

.mobile-menu-enter-from,
.mobile-menu-leave-to {
  max-height: 0 !important;
  opacity: 0;
}

/* Nav link hover effect */
.nav-link {
  position: relative;
  overflow: hidden;
}

.nav-link::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 2px;
  background: linear-gradient(90deg, #8b5cf6 0%, #4f46e5 100%);
  transform: scaleX(0);
  transform-origin: right;
  transition: transform 0.4s cubic-bezier(0.22, 0.61, 0.36, 1);
}

.nav-link:hover::after {
  transform: scaleX(1);
  transform-origin: left;
}

/* Mobile menu button animation */
.menu-btn {
  transition: all 0.3s ease-in-out;
}

.menu-btn:hover {
  transform: scale(1.05);
}

/* Backdrop filter for modern browsers */
@supports (backdrop-filter: blur(12px)) {
  .backdrop-blur {
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
  }
}
</style>
