<template>
  <div class="space-y-6">
    <!-- Page Header -->
    <div class="md:flex md:items-center md:justify-between">
      <div class="min-w-0 flex-1">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
          Dashboard
        </h2>
      </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
      <div 
        v-for="stat in stats" 
        :key="stat.name"
        class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6"
      >
        <div class="flex items-center">
          <div class="flex-shrink-0" :class="stat.iconBackground">
            <component 
              :is="getIconComponent(stat.icon)" 
              class="h-6 w-6 text-white" 
              aria-hidden="true" 
            />
          </div>
          <div class="ml-5 w-0 flex-1">
            <dt class="truncate text-sm font-medium text-gray-500">
              {{ stat.name }}
            </dt>
            <dd class="flex items-baseline">
              <p class="text-2xl font-semibold text-gray-900">
                {{ stat.value }}
              </p>
            </dd>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Projects -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
      <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Recent Projects</h3>
        <p class="mt-1 text-sm text-gray-500">A list of your most recent property projects.</p>
      </div>
      <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul role="list" class="divide-y divide-gray-200">
          <li v-for="project in recentProjects" :key="project.id">
            <div class="px-4 py-4 sm:px-6">
              <div class="flex items-center justify-between">
                <p class="truncate text-sm font-medium text-indigo-600">{{ project.name }}</p>
                <div class="ml-2 flex flex-shrink-0">
                  <p :class="`inline-flex rounded-full px-2 text-xs font-semibold leading-5 ${project.statusColor}`">
                    {{ project.status }}
                  </p>
                </div>
              </div>
              <div class="mt-2 sm:flex sm:justify-between">
                <div class="sm:flex">
                  <p class="flex items-center text-sm text-gray-500">
                    <component :is="getIconComponent('HomeModernIcon')" class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" />
                    {{ project.type }}
                  </p>
                  <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                    <component :is="getIconComponent('MapPinIcon')" class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" />
                    {{ project.location }}
                  </p>
                </div>
                <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                  <component :is="getIconComponent('CalendarIcon')" class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" />
                  <p>Added {{ project.date }}</p>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { 
  HomeModernIcon,
  UserGroupIcon,
  BuildingOfficeIcon,
  DocumentTextIcon,
  MapPinIcon,
  CalendarIcon
} from '@heroicons/vue/24/outline';

const route = useRoute();
const router = useRouter();

// Stats data
const stats = [
  { name: 'Total Projects', value: '24', icon: 'HomeModernIcon', iconBackground: 'rounded-md bg-purple-500 p-3' },
  { name: 'Active Projects', value: '8', icon: 'HomeModernIcon', iconBackground: 'rounded-md bg-green-500 p-3' },
  { name: 'Total Clients', value: '42', icon: 'UserGroupIcon', iconBackground: 'rounded-md bg-blue-500 p-3' },
  { name: 'Revenue', value: '$124,500', icon: 'DocumentTextIcon', iconBackground: 'rounded-md bg-yellow-500 p-3' },
];

// Dynamic component for icons
const getIconComponent = (iconName) => {
  const icons = {
    HomeModernIcon,
    UserGroupIcon,
    BuildingOfficeIcon,
    DocumentTextIcon,
    MapPinIcon,
    CalendarIcon
  };
  return icons[iconName] || null;
};

// Recent projects data
const recentProjects = [
  { 
    id: 1, 
    name: 'Sunset Villas', 
    type: 'Villa', 
    location: 'Marrakech', 
    date: '2 days ago',
    status: 'In Progress',
    statusColor: 'bg-yellow-100 text-yellow-800'
  },
  { 
    id: 2, 
    name: 'Ocean View Residences', 
    type: 'Apartment', 
    location: 'Casablanca', 
    date: '1 week ago',
    status: 'Active',
    statusColor: 'bg-green-100 text-green-800'
  },
  { 
    id: 3, 
    name: 'Palm Oasis', 
    type: 'Townhouse', 
    location: 'Agadir', 
    date: '2 weeks ago',
    status: 'Completed',
    statusColor: 'bg-blue-100 text-blue-800'
  },
];

// Check if a navigation item is active
const isActive = (path) => {
  return route.path.startsWith(path);
};

// Logout function
const logout = () => {
  // Add logout logic here
  router.push('/login');
};

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
</script>

<style scoped>
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
