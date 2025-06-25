<template>
  <div class="min-h-screen bg-gray-50 flex flex-col md:flex-row">
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
            {{ item.name }}
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
              <span class="sr-only">Open sidebar</span>
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
              <div>
                <button 
                  @click="isProfileMenuOpen = !isProfileMenuOpen"
                  class="flex items-center max-w-xs text-sm rounded-full focus:outline-none"
                >
                  <span class="sr-only">Open user menu</span>
                  <div class="h-8 w-8 rounded-full bg-purple-600 flex items-center justify-center text-white font-medium">
                    {{ userInitials }}
                  </div>
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
                  v-if="isProfileMenuOpen"
                  class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                  role="menu"
                  tabindex="-1"
                  v-click-outside="() => isProfileMenuOpen = false"
                >
                  <div class="py-1" role="none">
                    <router-link 
                      to="/admin/profile" 
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                      role="menuitem"
                      @click="isProfileMenuOpen = false"
                    >
                      Your Profile
                    </router-link>
                    <router-link 
                      to="/admin/settings" 
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                      role="menuitem"
                      @click="isProfileMenuOpen = false"
                    >
                      Settings
                    </router-link>
                    <button
                      @click="logout"
                      class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                      role="menuitem"
                    >
                      Sign out
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
import { ref, computed, onMounted, watch, onUnmounted, onBeforeMount } from 'vue';
import { useRoute, useRouter } from 'vue-router';
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

// State
const isMobileMenuOpen = ref(false);
const isProfileMenuOpen = ref(false);
const pageTitle = ref('Dashboard');

// Watch for route changes to update page title
watch(() => route.meta, (newMeta) => {
  pageTitle.value = newMeta.title || 'Dashboard';
}, { immediate: true });

// Navigation items
const navigation = [
  { name: 'Dashboard', href: '/admin/dashboard', icon: 'HomeIcon' },
  { name: 'Projects', href: '/admin/projects', icon: 'HomeModernIcon' },
  { name: 'Inquiries', href: '/admin/inquiries', icon: 'UserGroupIcon' },
  { name: 'Properties', href: '/admin/properties', icon: 'BuildingOfficeIcon' },
  { name: 'Documents', href: '/admin/documents', icon: 'DocumentTextIcon' },
  { name: 'Settings', href: '/admin/settings', icon: 'Cog6ToothIcon' },
];

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
  // Replace with actual user data
  const name = 'Admin User';
  return name
    .split(' ')
    .map(part => part[0])
    .join('')
    .toUpperCase()
    .substring(0, 2);
});

// Logout function
const logout = async () => {
  try {
    // Add your logout logic here
    // await authStore.logout();
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
