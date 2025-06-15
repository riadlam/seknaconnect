<template>
  <div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1 class="text-xl font-semibold text-gray-900">Projects</h1>
        <p class="mt-2 text-sm text-gray-700">A list of all property projects in the system.</p>
      </div>
      <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
        <router-link
          to="/admin/projects/new"
          class="inline-flex items-center justify-center rounded-md border border-transparent bg-purple-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 sm:w-auto"
        >
          Add Project
        </router-link>
      </div>
    </div>
    <div class="mt-8 flex flex-col">
      <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">ID</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Name</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Housing Type</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Units</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Location</th>
                  <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">Actions</span>
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                <tr v-for="project in projects" :key="project.id">
                  <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ project.id }}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ project.name }}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ project.housing_type }}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ project.num_units }}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ project.location }}</td>
                  <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                    <div class="flex space-x-2 justify-end">
                      <router-link 
                        :to="`/admin/projects/${project.id}`"
                        class="text-purple-600 hover:text-purple-900"
                      >
                        View
                      </router-link>
                      <router-link 
                        :to="`/admin/projects/${project.id}/edit`"
                        class="text-indigo-600 hover:text-indigo-900"
                      >
                        Edit
                      </router-link>
                      <button 
                        @click="deleteProject(project.id)"
                        class="text-red-600 hover:text-red-900"
                      >
                        Delete
                      </button>
                    </div>
                  </td>
                </tr>
                <tr v-if="projects.length === 0">
                  <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                    No projects found.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- Pagination -->
          <div class="mt-4 flex items-center justify-between border-t border-gray-200 px-4 py-3 sm:px-6">
            <div class="flex flex-1 justify-between sm:hidden">
              <button 
                @click="currentPage > 1 ? currentPage-- : null"
                :disabled="currentPage === 1"
                class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
              >
                Previous
              </button>
              <button 
                @click="currentPage < totalPages ? currentPage++ : null"
                :disabled="currentPage === totalPages"
                class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
              >
                Next
              </button>
            </div>
            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
              <div>
                <p class="text-sm text-gray-700">
                  Showing <span class="font-medium">{{ (currentPage - 1) * perPage + 1 }}</span>
                  to <span class="font-medium">{{ Math.min(currentPage * perPage, totalItems) }}</span>
                  of <span class="font-medium">{{ totalItems }}</span> results
                </p>
              </div>
              <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                  <button
                    @click="currentPage > 1 ? currentPage-- : null"
                    :disabled="currentPage === 1"
                    :class="{ 'opacity-50 cursor-not-allowed': currentPage === 1 }"
                    class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20"
                  >
                    <span class="sr-only">Previous</span>
                    <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
                  </button>
                  <button
                    v-for="page in visiblePages"
                    :key="page"
                    @click="currentPage = page"
                    :class="[
                      page === currentPage 
                        ? 'z-10 bg-purple-50 border-purple-500 text-purple-600' 
                        : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                      'relative inline-flex items-center border px-4 py-2 text-sm font-medium focus:z-20'
                    ]"
                    :aria-current="page === currentPage ? 'page' : undefined"
                  >
                    {{ page }}
                  </button>
                  <button
                    @click="currentPage < totalPages ? currentPage++ : null"
                    :disabled="currentPage === totalPages"
                    :class="{ 'opacity-50 cursor-not-allowed': currentPage === totalPages }"
                    class="relative inline-flex items-center rounded-r-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20"
                  >
                    <span class="sr-only">Next</span>
                    <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
                  </button>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/20/solid';

// Sample data - replace with API call
const projects = ref([
  { id: 1, name: 'Sunset Villas', housing_type: 'Villa', num_units: 24, location: 'Marrakech' },
  { id: 2, name: 'Ocean View Residences', housing_type: 'Apartment', num_units: 120, location: 'Casablanca' },
  { id: 3, name: 'Palm Oasis', housing_type: 'Townhouse', num_units: 48, location: 'Agadir' },
  { id: 4, name: 'Mountain Retreat', housing_type: 'Villa', num_units: 12, location: 'Ifrane' },
  { id: 5, name: 'Desert Mirage', housing_type: 'Apartment', num_units: 80, location: 'Ouarzazate' },
]);

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

// Delete project function
const deleteProject = (id) => {
  if (confirm('Are you sure you want to delete this project?')) {
    // Replace with actual API call
    projects.value = projects.value.filter(project => project.id !== id);
  }
};

// Fetch projects from API
const fetchProjects = async () => {
  try {
    // Replace with your actual API endpoint
    // const response = await axios.get('/api/admin/projects');
    // projects.value = response.data;
  } catch (error) {
    console.error('Error fetching projects:', error);
  }
};

onMounted(() => {
  fetchProjects();
});
</script>

<style scoped>
/* Add any custom styles here */
</style>
