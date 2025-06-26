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
        <div class="flex items-center justify-between">
          <div>
            <h3 class="text-lg font-medium leading-6 text-gray-900">Recent Projects</h3>
            <p class="mt-1 text-sm text-gray-500">A list of your most recent property projects.</p>
          </div>
          <button 
            @click="fetchProjects"
            :disabled="loading"
            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <svg v-if="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ loading ? 'Refreshing...' : 'Refresh' }}
          </button>
        </div>
      </div>
      <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div v-if="loading && projects.length === 0" class="px-4 py-12 text-center">
          <div class="flex justify-center">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
          </div>
          <p class="mt-2 text-sm text-gray-500">Loading projects...</p>
        </div>
        <div v-else-if="error" class="px-4 py-12 text-center">
          <div class="text-red-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <p class="mt-2">{{ error }}</p>
            <button 
              @click="fetchProjects"
              class="mt-4 inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              Try Again
            </button>
          </div>
        </div>
        <div v-else-if="projects.length === 0" class="px-4 py-12 text-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">No projects</h3>
          <p class="mt-1 text-sm text-gray-500">Get started by creating a new project.</p>
          <div class="mt-6">
            <button 
              @click="$router.push('/admin/projects/create')" 
              class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
              </svg>
              New Project
            </button>
          </div>
        </div>
        <ul v-else role="list" class="divide-y divide-gray-200">
          <li v-for="project in recentProjects" :key="project.id" class="hover:bg-gray-50 cursor-pointer" @click="$router.push(`/admin/projects/${project.id}`)">
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
                    {{ project.type || 'N/A' }}
                  </p>
                  <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                    <component :is="getIconComponent('MapPinIcon')" class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" />
                    {{ project.location || 'Location not specified' }}
                  </p>
                </div>
                <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                  <component :is="getIconComponent('CalendarIcon')" class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" />
                  <p>Added {{ project.date }}</p>
                </div>
              </div>
              <div v-if="project.images && project.images.length > 0" class="mt-2">
                <div class="flex -space-x-2 overflow-hidden">
                  <img 
                    v-for="(image, index) in project.images.slice(0, 3)" 
                    :key="index"
                    :src="image.image_path" 
                    :alt="image.caption || 'Project image'"
                    class="inline-block h-8 w-8 rounded-full ring-2 ring-white object-cover"
                  />
                  <span v-if="project.images.length > 3" class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-200 text-gray-600 text-xs font-medium">
                    +{{ project.images.length - 3 }}
                  </span>
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
import { ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { 
  HomeModernIcon,
  UserGroupIcon,
  BuildingOfficeIcon,
  DocumentTextIcon,
  MapPinIcon,
  CalendarIcon
} from '@heroicons/vue/24/outline';
import axios from 'axios';

const route = useRoute();
const router = useRouter();
const projects = ref([]);
const loading = ref(true);
const error = ref(null);

// Fetch projects from API
const fetchProjects = async () => {
  try {
    loading.value = true;
    const response = await axios.get('/api/projects', {
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      }
    });
    projects.value = response.data;
  } catch (err) {
    console.error('Error fetching projects:', err);
    error.value = 'Failed to load projects. Please try again later.';
  } finally {
    loading.value = false;
  }
};

// Format date to relative time (e.g., '2 days ago')
const formatDate = (dateString) => {
  const date = new Date(dateString);
  const now = new Date();
  const diffInDays = Math.floor((now - date) / (1000 * 60 * 60 * 24));
  
  if (diffInDays === 0) return 'Today';
  if (diffInDays === 1) return 'Yesterday';
  if (diffInDays < 7) return `${diffInDays} days ago`;
  
  const diffInWeeks = Math.floor(diffInDays / 7);
  if (diffInWeeks === 1) return '1 week ago';
  if (diffInWeeks < 4) return `${diffInWeeks} weeks ago`;
  
  return date.toLocaleDateString();
};

// Get status color based on project status
const getStatusColor = (status) => {
  const statusMap = {
    'active': 'bg-green-100 text-green-800',
    'in_progress': 'bg-yellow-100 text-yellow-800',
    'completed': 'bg-blue-100 text-blue-800',
    'on_hold': 'bg-gray-100 text-gray-800',
    'cancelled': 'bg-red-100 text-red-800'
  };
  return statusMap[status.toLowerCase()] || 'bg-gray-100 text-gray-800';
};

// Format status text
const formatStatus = (status) => {
  return status
    .split('_')
    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
    .join(' ');
};

// Stats data - now computed based on actual projects
const stats = computed(() => {
  const totalProjects = projects.value.length;
  const activeProjects = projects.value.filter(p => p.status === 'active').length;
  const totalClients = 4;
  const totalRevenue = projects.value.reduce((sum, project) => {
    return sum + parseFloat(project.price || 0);
  }, 0);

  return [
    { 
      name: 'Total Projects', 
      value: totalProjects.toString(), 
      icon: 'HomeModernIcon', 
      iconBackground: 'rounded-md bg-purple-500 p-3' 
    },
    // { 
    //   name: 'Active Projects', 
    //   value: activeProjects.toString(), 
    //   icon: 'HomeModernIcon', 
    //   iconBackground: 'rounded-md bg-green-500 p-3' 
    // },
    { 
      name: 'Total Clients', 
      value: totalClients.toString(), 
      icon: 'UserGroupIcon', 
      iconBackground: 'rounded-md bg-blue-500 p-3' 
    },
    // { 
    //   name: 'Revenue', 
    //   value: `$${totalRevenue.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`, 
    //   icon: 'DocumentTextIcon', 
    //   iconBackground: 'rounded-md bg-yellow-500 p-3' 
    // },
  ];
});

// Get recent projects (last 3)
const recentProjects = computed(() => {
  return [...projects.value]
    .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
    .slice(0, 3)
    .map(project => ({
      id: project.id,
      name: project.name,
      type: project.housing_type,
      location: project.location,
      date: formatDate(project.created_at),
      status: formatStatus(project.status || 'completed'),
      statusColor: getStatusColor(project.status || 'completed')
    }));
});

// Fetch projects when component is mounted
onMounted(() => {
  fetchProjects();
});

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

// Recent projects data is now computed from the API response

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
