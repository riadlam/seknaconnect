<template>
  <div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1 class="text-xl font-semibold text-gray-900">Projets</h1>
        <p class="mt-2 text-sm text-gray-700">Liste de tous les projets immobiliers dans le système.</p>
      </div>
      <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
        <button
          @click="openAddProjectDialog"
          class="inline-flex items-center justify-center rounded-md border border-transparent bg-purple-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 sm:w-auto"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
Ajouter un projet
        </button>
      </div>
    </div>
    <!-- Loading state -->
      <div v-if="isLoading" class="mt-8 text-center">
        <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-white bg-purple-600">
          <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
Chargement des projets...
        </div>
      </div>

      <!-- Error state -->
      <div v-else-if="error" class="mt-8 p-4 bg-red-50 text-red-700 rounded-md">
        {{ error }}
      </div>

      <!-- Empty state -->
      <div v-else-if="projects.length === 0" class="mt-8 text-center">
        <div class="p-8 bg-gray-50 rounded-lg">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun projet</h3>
          <p class="mt-1 text-sm text-gray-500">Commencez par créer un nouveau projet.</p>
          <div class="mt-6">
            <button
              type="button"
              @click="openAddProjectDialog"
              class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
            >
              <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
              </svg>
Nouveau projet
            </button>
          </div>
        </div>
      </div>

      <!-- Projects list -->
      <div v-else class="mt-8 flex flex-col">
      <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">ID</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Nom</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Type de bien</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Unités</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date de livraison</th>
                  <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">Actions</span>
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                <tr v-for="project in paginatedProjects" :key="project.id">
                  <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ project.id }}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    <div class="flex items-center">
                      <div v-if="project.images && project.images.length > 0" class="h-10 w-10 flex-shrink-0">
                        <img class="h-10 w-10 rounded-full object-cover" :src="project.images[0].image_path" :alt="project.name" />
                      </div>
                      <div class="ml-4">
                        <div class="font-medium text-gray-900">{{ project.name }}</div>
                        <div class="text-gray-500">{{ formatLocation(project.location) }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize" :class="{
                      'bg-purple-100 text-purple-800': project.housing_type.toLowerCase() === 'villa',
                      'bg-blue-100 text-blue-800': project.housing_type.toLowerCase() === 'apartment',
                      'bg-green-100 text-green-800': project.housing_type.toLowerCase() === 'duplex',
                      'bg-yellow-100 text-yellow-800': project.housing_type.toLowerCase() === 'townhouse',
                      'bg-gray-100 text-gray-800': !['villa', 'apartment', 'duplex', 'townhouse'].includes(project.housing_type.toLowerCase())
                    }">
                      {{ project.housing_type }}
                    </span>
                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    {{ project.num_units }} {{ project.num_units === 1 ? 'unité' : 'unités' }}
                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    <div class="text-xs text-gray-400 mt-1">
                      <span v-if="project.delivery_date">
                        Livraison : {{ new Date(project.delivery_date).toLocaleDateString('fr-FR') }}
                      </span>
                      <span v-else class="text-yellow-600">Pas de date de livraison</span>
                    </div>
                  </td>
                  <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                    <div class="flex space-x-2 justify-end">
                      <router-link 
                        :to="`/admin/projects/${project.id}`"
                        class="text-purple-600 hover:text-purple-900 flex items-center"
                        title="View details"
                      >
                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
Voir
                      </router-link>
                      <button 
                        @click="editProject(project)" 
                        class="text-blue-600 hover:text-blue-900 flex items-center"
                        title="Edit project"
                      >
                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
Modifier
                      </button>
                      <button 
                        @click="deleteProject(project.id)" 
                        class="text-red-600 hover:text-red-900 flex items-center ml-2"
                        title="Delete project"
                      >
                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
Supprimer
                      </button>
                    </div>
                  </td>
                </tr>
                <tr v-if="projects.length === 0">
                  <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
Aucun projet trouvé.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
    <!-- Add Project Dialog -->
    <AddProjectDialog 
      :is-open="showAddDialog" 
      :project="currentProject"
      @close="() => { showAddDialog = false; currentProject = null; }"
      @submit="handleAddProject"
      :key="currentProject ? currentProject.id : 'new'"
    />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/20/solid';
import AddProjectDialog from '../../../components/projects/AddProjectDialog.vue';
import axios from 'axios';
import { useStore } from 'vuex';

const projects = ref([]);
const isLoading = ref(true);
const error = ref(null);
const showAddDialog = ref(false);
const currentProject = ref(null);
const isEditing = computed(() => !!currentProject.value);

// Pagination
const currentPage = ref(1);
const perPage = ref(10);
const totalItems = computed(() => projects.value.length);
const totalPages = computed(() => Math.ceil(totalItems.value / perPage.value));

const visiblePages = computed(() => {
  const range = [];
  const maxVisible = 5; // Show max 5 page numbers
  let start = Math.max(1, currentPage.value - Math.floor(maxVisible / 2));
  let end = Math.min(totalPages.value, start + maxVisible - 1);
  
  if (end - start + 1 < maxVisible) {
    start = Math.max(1, end - maxVisible + 1);
  }
  
  for (let i = start; i <= end; i++) {
    range.push(i);
  }
  
  return range;
});

// Filter projects based on pagination
const paginatedProjects = computed(() => {
  const start = (currentPage.value - 1) * perPage.value;
  const end = start + perPage.value;
  return projects.value.slice(start, end);
});

// Format location display
const formatLocation = (location) => {
  if (!location) return '';
  
  try {
    const locationObj = typeof location === 'string' ? JSON.parse(location) : location;
    const parts = [
      locationObj.daira,
      locationObj.commune,
      locationObj.wilaya
    ].filter(Boolean);
    
    return parts.join(', ');
  } catch (e) {
    console.warn('Error formatting location:', e);
    return location;
  }
};

// Format price with thousands separator
const formatPrice = (price) => {
  if (!price) return 'N/A';
  return new Intl.NumberFormat('en-US', {
    style: 'decimal',
    maximumFractionDigits: 0
  }).format(price) + ' DZD';
};

// Format date
const formatDate = (dateString) => {
  if (!dateString) return 'N/A';
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
};

// Delete project function
const deleteProject = async (id) => {
  if (!confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')) return;
  
  try {
    const token = store.state.auth.token;
    if (!token) {
      throw new Error('Veuillez vous reconnecter');
    }
    
    await axios.delete(`/api/projects/${id}`, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      }
    });
    
    // Remove the project from the local state
    projects.value = projects.value.filter(project => project.id !== id);
    
    // Show success message or toast
    alert('Projet supprimé avec succès !');
  } catch (error) {
    console.error('Error deleting project:', error);
    const errorMessage = error.response?.data?.message || 'Échec de la suppression du projet. Veuillez réessayer.';
    alert(errorMessage);
  }
};

const openAddProjectDialog = (project = null) => {
  isEditing.value = false;
  currentProject.value = null;
  showAddDialog.value = true;
};

const handleAddProject = (projectData) => {
  if (projectData.id) {
    // Update existing project in the list
    const index = projects.value.findIndex(p => p.id === projectData.id);
    if (index !== -1) {
      projects.value[index] = projectData;
    }
  } else {
    // Add new project to the beginning of the list
    projects.value.unshift(projectData);
  }
  showAddDialog.value = false;
  currentProject.value = null;
};

const editProject = (project) => {
  isEditing.value = true;
  currentProject.value = project;
  showAddDialog.value = true;
};

// Fetch projects from API
const store = useStore();

const fetchProjects = async () => {
  isLoading.value = true;
  error.value = null;
  
  try {
    const token = store.state.auth.token;
    if (!token) {
      throw new Error('Authentication token not found. Please log in again.');
    }
    
    const response = await axios.get('/api/user/projects', {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      }
    });
    
    projects.value = response.data;
  } catch (err) {
    console.error('Error fetching projects:', err);
    error.value = 'Échec du chargement des projets. Veuillez réessayer plus tard.';
  } finally {
    isLoading.value = false;
  }
};

onMounted(() => {
  fetchProjects();
});
</script>

<style scoped>
/* Add any custom styles here */
</style>
