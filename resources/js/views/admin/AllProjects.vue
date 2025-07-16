<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1 class="text-2xl font-semibold text-gray-900">Tous les projets</h1>
        <p class="mt-2 text-sm text-gray-600">Liste de tous les projets dans le système.</p>
      </div>
    </div>
    
    <!-- Loading State -->
    <div v-if="loading" class="mt-8 text-center">
      <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-white bg-purple-600">
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
Chargement des projets...
      </div>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="mt-8 bg-red-50 border-l-4 border-red-400 p-4">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
          </svg>
        </div>
        <div class="ml-3">
          <p class="text-sm text-red-700">
            {{ error }}
          </p>
        </div>
      </div>
    </div>

    <!-- Projects List -->
    <div v-else class="mt-8 flex flex-col">
      <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Projet</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Type</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Localisation</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Prix</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Unités</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Livraison</th>
                  <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">Actions</span>
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                <tr v-for="project in projects" :key="project.id" class="hover:bg-gray-50">
                  <td class="whitespace-nowrap py-4 pl-4 pr-3 sm:pl-6">
                    <div class="flex items-center">
                      <div v-if="project.images && project.images.length > 0" class="h-10 w-10 flex-shrink-0">
                        <img class="h-10 w-10 rounded-md object-cover" :src="project.images[0].image_path" :alt="project.name" />
                      </div>
                      <div class="ml-4">
                        <div class="font-medium text-gray-900">{{ project.name }}</div>
                        <div class="text-gray-500 text-xs">ID: {{ project.id }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                      {{ project.housing_type }}
                    </span>
                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    {{ project.location }}
                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    {{ formatPrice(project.price) }}
                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    {{ project.num_units }}
                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    {{ formatDate(project.delivery_date) }}
                  </td>
                  <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                    <button @click="viewProject(project)" class="text-indigo-600 hover:text-indigo-900 mr-4">Voir</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const projects = ref([]);
const loading = ref(true);
const error = ref(null);

// Format price with thousands separator in DZD
const formatPrice = (price) => {
  if (!price) return 'N/D';
  return new Intl.NumberFormat('ar-DZ', {
    style: 'decimal',
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(price) + ' DZD';
};

// Format date
const formatDate = (dateString) => {
  if (!dateString) return 'N/D';
  const options = { year: 'numeric', month: 'short', day: 'numeric' };
  return new Date(dateString).toLocaleDateString(undefined, options);
};

// View project details
const viewProject = (project) => {
  // TODO: Implement view project details
  console.log('View project:', project);
};

// Edit project
const editProject = (project) => {
  // TODO: Implement edit project
  console.log('Edit project:', project);
};

// Fetch projects from API
const fetchProjects = async () => {
  try {
    loading.value = true;
    error.value = null;
    
    const response = await axios.get('/api/projects', {
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      }
    });
    
    projects.value = response.data;
  } catch (err) {
    console.error('Error fetching projects:', err);
    error.value = 'Échec du chargement des projets. Veuillez réessayer plus tard.';
  } finally {
    loading.value = false;
  }
};

// Fetch projects when component is mounted
onMounted(() => {
  fetchProjects();
});
</script>

<style scoped>
/* Add any custom styles here */
</style>
