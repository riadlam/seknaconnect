<template>
  <div v-if="isInitialized" class="min-h-screen bg-gray-50 flex flex-col md:flex-row">
    <!-- Loading state -->
    <div v-if="!isReady" class="fixed inset-0 bg-white bg-opacity-80 flex items-center justify-center z-50">
      <div class="text-center">
        <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-white bg-purple-600">
          <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          Loading...
        </div>
      </div>
    </div>
    <!-- Mobile menu button -->
    <div class="md:hidden flex items-center justify-between p-4 bg-white border-b border-gray-200">
      <button 
        @click="isMobileMenuOpen = !isMobileMenuOpen"
        class="p-2 rounded-md text-gray-500 hover:bg-gray-100 focus:outline-none"
      >
        <Bars3Icon class="h-6 w-6" />
      </button>
      <span class="text-lg font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
        SeknaConnect Pro
      </span>
      <div class="w-10"></div> <!-- Spacer for alignment -->
    </div>

    <!-- Sidebar -->
    <div 
      class="fixed inset-y-0 left-0 transform md:relative md:translate-x-0 transition-transform duration-300 ease-in-out z-40"
      :class="{ '-translate-x-full': !isMobileMenuOpen }"
    >
      <div class="flex flex-col w-64 h-full bg-white border-r border-gray-200">
        <!-- Logo -->
        <div class="flex items-center h-16 px-4 border-b border-gray-200">
          <span class="text-xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
            SeknaConnect Pro
          </span>
          <button 
            @click="isMobileMenuOpen = false"
            class="ml-auto p-2 rounded-md text-gray-500 hover:bg-gray-100 md:hidden"
          >
            <XMarkIcon class="h-5 w-5" />
          </button>
        </div>
        
        <!-- Navigation -->
        <nav class="flex-1 px-2 py-4 space-y-1">
          <router-link 
            v-for="item in navigation" 
            :key="item.name" 
            :to="item.href" 
            class="flex items-center px-3 py-2 text-sm font-medium rounded-md group"
            :class="[isActive(item.href) 
              ? 'bg-purple-50 text-purple-600' 
              : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900']"
            @click="isMobileMenuOpen = false"
          >
            <component 
              :is="getIconComponent(item.icon)" 
              class="mr-3 flex-shrink-0 h-5 w-5" 
              :class="[isActive(item.href) ? 'text-purple-500' : 'text-gray-400 group-hover:text-gray-500']" 
              aria-hidden="true" 
            />
            <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-900">{{ item.name }}</span>
          </router-link>
        </nav>
      </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Top Navigation -->
      <header class="bg-white shadow-sm z-10">
        <div class="flex items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
          <div class="flex items-center">
            <button 
              @click="isMobileMenuOpen = !isMobileMenuOpen"
              class="mr-2 p-2 text-gray-500 hover:text-gray-600 hover:bg-gray-100 rounded-full md:hidden"
            >
              <Bars3Icon class="h-5 w-5" />
              <span class="ml-3">{{ userName }}</span>
            </button>
            <h1 class="text-lg font-medium text-gray-900">
              {{ pageTitle }}
            </h1>
          </div>
          
          <div class="flex items-center space-x-4">
            <button class="p-2 text-gray-500 hover:text-gray-600 hover:bg-gray-100 rounded-full">
              <BellIcon class="h-5 w-5" />
              <span class="sr-only">View notifications</span>
            </button>
            
            <!-- Profile dropdown -->
            <div class="relative ml-3">
              <div ref="profileMenuRef" class="relative">
                <button 
                  @click.stop="isProfileMenuOpen = !isProfileMenuOpen"
                  class="flex items-center max-w-xs text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                  :class="{ 'bg-gray-100': isProfileMenuOpen }"
                >
                  <span class="sr-only">Open user menu</span>
                  <div class="h-8 w-8 rounded-full bg-purple-600 flex items-center justify-center text-white font-medium">
                    {{ userInitials }}
                  </div>
                  <span class="ml-2 text-sm font-medium text-gray-700">
                    {{ userName }}
                  </span>
                </button>
              </div>
              
              <!-- Profile dropdown panel -->
              <transition
                enter-active-class="transition ease-out duration-100"
                enter-from-class="transform opacity-0 scale-95"
                enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75"
                leave-from-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95"
              >
                <div 
                  v-show="isProfileMenuOpen"
                  class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                  role="menu"
                  tabindex="-1"
                >
                  <div class="py-1" role="none">
                    <router-link 
                      to="/admin/profile" 
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      role="menuitem"
                      @click="isProfileMenuOpen = false"
                    >
                      <div class="flex items-center">
                        <span>Your Profile</span>
                      </div>
                    </router-link>
                    <button
                      @click="logout"
                      class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700"
                      role="menuitem"
                    >
                      <div class="flex items-center">
                        <span>Sign out</span>
                      </div>
                    </button>
                  </div>
                </div>
              </transition>
            </div>
          </div>
        </div>
      </header>

      <!-- Page Content -->
      <main class="flex-1 overflow-y-auto bg-gray-50 p-4 sm:p-6">
        <router-view v-slot="{ Component }">
          <transition name="fade" mode="out-in">
            <component :is="Component" />
          </transition>
        </router-view>
      </main>
    </div>

    <!-- Mobile menu overlay -->
    <div 
      v-show="isMobileMenuOpen" 
      class="md:hidden fixed inset-0 bg-gray-600 bg-opacity-75 z-30 transition-opacity duration-300 ease-in-out"
      :class="{ 'opacity-0': !isMobileMenuOpen, 'opacity-100': isMobileMenuOpen }"
      @click="isMobileMenuOpen = false"
    ></div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch, onUnmounted, nextTick } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useStore } from 'vuex';
import { 
  HomeIcon,
  UserGroupIcon,
  BuildingOfficeIcon,
  DocumentTextIcon,
  Cog6ToothIcon,
  ArrowLeftOnRectangleIcon,
  Bars3Icon,
  XMarkIcon,
  BellIcon,
  HomeModernIcon,
  MapPinIcon,
  CalendarIcon
} from '@heroicons/vue/24/outline';

const route = useRoute();
const router = useRouter();
const store = useStore();
const isInitialized = ref(false);
const isReady = ref(false);
const isProfileMenuOpen = ref(false);
const profileMenuRef = ref(null);

// Close profile menu when clicking outside
const handleClickOutside = (event) => {
  if (profileMenuRef.value && !profileMenuRef.value.contains(event.target)) {
    isProfileMenuOpen.value = false;
  }
};

// Add click outside listener when component mounts
onMounted(() => {
  document.addEventListener('click', handleClickOutside);
  checkAuth();
});

// Cleanup event listener
onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
  if (unwatch) unwatch();
});

// Clean up event listener
onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
});

// Check authentication status
const checkAuth = async () => {
  try {
    // Check if user is already authenticated in store
    if (!store.getters['auth/isAuthenticated']) {
      // Try to initialize from storage
      const token = localStorage.getItem('token') || sessionStorage.getItem('token');
      const user = localStorage.getItem('user') || sessionStorage.getItem('user');
      
      if (token && user) {
        await store.dispatch('auth/checkAuth', { token, user: JSON.parse(user) });
      } else {
        // No valid session found
        if (!route.path.includes('/login')) {
          return router.push('/login');
        }
        return;
      }
    }
    
    // If not authenticated and not on login page, redirect to login
    if (!store.getters['auth/isAuthenticated'] && !route.path.includes('/login')) {
      return router.push('/login');
    }
    
    // If authenticated and on login page, redirect to dashboard
    if (store.getters['auth/isAuthenticated'] && route.path === '/login') {
      return router.push('/dashboard');
    }
    
    isReady.value = true;
  } catch (error) {
    console.error('Auth check failed:', error);
    if (!route.path.includes('/login')) {
      router.push('/login');
    }
  } finally {
    isInitialized.value = true;
  }
};

// Watch for route changes to check auth
watch(() => route.path, async () => {
  if (!isInitialized.value) return;
  await checkAuth();
});



// State
const isMobileMenuOpen = ref(false);
const pageTitle = ref('Dashboard');

// Watch for route changes to update page title
watch(() => route.meta, (newMeta) => {
  pageTitle.value = newMeta.title || 'Dashboard';
}, { immediate: true });

// Navigation items based on user role and authentication
const navigation = computed(() => {
  // If not authenticated, return empty array
  if (!store.getters['auth/isAuthenticated']) {
    return [];
  }
  
  // Get user role
  const userRole = store.getters['auth/currentUser']?.role;
  
  const adminNav = [
    { name: 'Dashboard', href: '/admin/dashboard', icon: 'HomeIcon' },
    { name: 'Users', href: '/admin/users', icon: 'UserGroupIcon' },
    { name: 'All Projects', href: '/admin/documents', icon: 'DocumentTextIcon' },
  ];
  
  const professionalNav = [
    { name: 'Dashboard', href: '/admin/dashboard', icon: 'HomeIcon' },
    { name: 'Projects', href: '/admin/projects', icon: 'HomeModernIcon' },
    { name: 'Inquiries', href: '/admin/inquiries', icon: 'UserGroupIcon' },
  ];
  
  // Default to admin navigation if role is not recognized
  return userRole === 'professional' ? professionalNav : adminNav;
});

// Dynamic component for icons
const getIconComponent = (iconName) => {
  const icons = {
    HomeIcon,
    UserGroupIcon,
    BuildingOfficeIcon,
    DocumentTextIcon,
    Cog6ToothIcon,
    ArrowLeftOnRectangleIcon,
    Bars3Icon,
    XMarkIcon,
    BellIcon,
    HomeModernIcon,
    MapPinIcon,
    CalendarIcon
  };
  return icons[iconName] || HomeIcon; // Fallback to HomeIcon if icon not found
};

// Check if a navigation item is active
const isActive = (path) => {
  return route.path.startsWith(path);
};

// Get user initials for avatar
const userInitials = computed(() => {
  const user = store.getters['auth/currentUser'];
  if (!user) return 'U';
  
  if (user.name) {
    return user.name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
  }
  return user.email ? user.email[0].toUpperCase() : 'U';
  return name
    .split(' ')
    .map(part => part[0])
    .join('')
    .toUpperCase()
    .substring(0, 2);
});

// Get user display name
const userName = computed(() => {
  const user = store.getters['auth/currentUser'];
  return user?.name || user?.email || 'User';
});

// Logout function
const logout = async () => {
  try {
    await store.dispatch('auth/logout');
    router.push('/login');
  } catch (error) {
    console.error('Logout failed:', error);
  }
};

// Close mobile menu when route changes
const unwatch = router.afterEach((to) => {
  isMobileMenuOpen.value = false;
  document.title = to.meta.title ? `${to.meta.title} | SeknaConnect Admin` : 'SeknaConnect Admin';
});

// Click outside directive
const vClickOutside = {
  beforeMount(el, binding) {
    el.clickOutsideEvent = function(event) {
      if (!(el === event.target || el.contains(event.target))) {
        binding.value();
      }
    };
    document.addEventListener('click', el.clickOutsideEvent);
  },
  unmounted(el) {
    document.removeEventListener('click', el.clickOutsideEvent);
  }
};

// Cleanup
onUnmounted(() => {
  if (unwatch) unwatch();
});
</script>

<style scoped>
/* Fade transition */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
/* Smooth transitions for mobile menu */
.transition-transform {
  transition-property: transform;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 300ms;
}

/* Ensure the main content doesn't overflow */
.overflow-y-auto {
  -webkit-overflow-scrolling: touch;
}

/* Better touch targets for mobile */
@media (max-width: 768px) {
  .btn-mobile {
    min-height: 2.5rem;
    min-width: 2.5rem;
  }
  
  .nav-item {
    padding: 0.75rem 1rem;
  }
}

/* Fix for iOS scrolling */
@supports (-webkit-touch-callout: none) {
  .overflow-y-auto {
    -webkit-overflow-scrolling: touch;
  }
}

/* Ensure dropdowns appear above other content */
.z-50 {
  z-index: 50;
}
</style>
