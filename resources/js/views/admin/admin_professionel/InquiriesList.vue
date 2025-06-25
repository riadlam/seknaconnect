<template>
  <div class="min-h-screen bg-gray-50 p-4 sm:p-6">
    <div class="max-w-7xl mx-auto">
      <!-- Header Section -->
      <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
          <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
            Property Inquiries
          </h1>
          <p class="mt-1 text-sm text-gray-500">
            Manage and respond to property inquiries from potential clients
          </p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
          <button 
            @click="fetchInquiries"
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150"
            :disabled="loading"
          >
            <svg v-if="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <svg v-else class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            {{ loading ? 'Refreshing...' : 'Refresh' }}
          </button>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="loading && inquiries.length === 0" class="bg-white shadow rounded-lg p-6">
        <div class="animate-pulse space-y-4">
          <div class="h-6 bg-gray-200 rounded w-1/3"></div>
          <div class="space-y-2">
            <div class="h-4 bg-gray-200 rounded w-5/6"></div>
            <div class="h-4 bg-gray-200 rounded w-4/6"></div>
          </div>
          <div class="h-12 bg-gray-200 rounded mt-4"></div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else-if="inquiries.length === 0" class="bg-white shadow overflow-hidden sm:rounded-lg text-center py-16 px-4">
        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>
        <h3 class="mt-4 text-lg font-medium text-gray-900">No inquiries yet</h3>
        <p class="mt-1 text-sm text-gray-500">Your property inquiries will appear here when clients contact you.</p>
        <div class="mt-6">
          <button @click="fetchInquiries" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Refresh
          </button>
        </div>
      </div>

      <!-- Inquiries List -->
      <div v-else class="space-y-4">
        <div 
          v-for="inquiry in inquiries" 
          :key="inquiry.id"
          class="bg-white shadow overflow-hidden rounded-lg transition-all duration-200 hover:shadow-md"
        >
          <div class="px-6 py-5 sm:px-6">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between">
              <div class="flex-1 min-w-0">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-r from-purple-500 to-indigo-600 flex items-center justify-center text-white font-medium">
                    {{ inquiry.name.charAt(0).toUpperCase() }}
                  </div>
                  <div class="ml-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">{{ inquiry.project.name }}</h3>
                    <p class="mt-1 text-sm text-gray-500">
                      <span class="inline-flex items-center">
                        <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                          <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        {{ inquiry.name }}
                      </span>
                      <span class="mx-2 text-gray-300">•</span>
                      <span class="inline-flex items-center">
                        <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                          <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        {{ inquiry.email }}
                      </span>
                    </p>
                  </div>
                </div>
              </div>
              <div class="mt-4 sm:mt-0 sm:ml-4">
                <span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                  <svg class="-ml-1 mr-1.5 h-2 w-2 text-purple-600" fill="currentColor" viewBox="0 0 8 8">
                    <circle cx="4" cy="4" r="3" />
                  </svg>
                  {{ formatDate(inquiry.created_at) }}
                </span>
              </div>
            </div>

            <div class="mt-5">
              <h4 class="text-sm font-medium text-gray-700 mb-2">Message</h4>
              <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <p class="text-gray-700 whitespace-pre-line">{{ inquiry.message }}</p>
              </div>
            </div>

            <div class="mt-5 border-t border-gray-200 pt-5">
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div class="flex items-start">
                  <div class="flex-shrink-0 h-6 w-6 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                    </svg>
                  </div>
                  <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Project</p>
                    <p class="text-sm font-medium text-gray-900">{{ inquiry.project.name }}</p>
                  </div>
                </div>
                <div class="flex items-start">
                  <div class="flex-shrink-0 h-6 w-6 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                  </div>
                  <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Location</p>
                    <p class="text-sm text-gray-900">{{ inquiry.project.location }}</p>
                  </div>
                </div>
                <div class="flex items-start">
                  <div class="flex-shrink-0 h-6 w-6 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                  </div>
                  <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Property Type</p>
                    <p class="text-sm text-gray-900">{{ inquiry.project.housing_type }}</p>
                  </div>
                </div>
                <div class="flex items-start">
                  <div class="flex-shrink-0 h-6 w-6 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 3.9a5 5 0 003.168-5.189a5 5 0 00-5.22-4.398L6 6l3-1z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16a3 3 0 100-6 3 3 0 000 6z" />
                    </svg>
                  </div>
                  <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Price</p>
                    <p class="text-sm text-gray-900">${{ Number(inquiry.project.price).toLocaleString() }}</p>
                  </div>
                </div>
                <div class="flex items-start">
                  <div class="flex-shrink-0 h-6 w-6 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                  </div>
                  <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Surface Area</p>
                    <p class="text-sm text-gray-900">{{ Number(inquiry.project.surface_area).toLocaleString() }} m²</p>
                  </div>
                </div>
                <div class="flex items-start">
                  <div class="flex-shrink-0 h-6 w-6 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                  </div>
                  <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Delivery Date</p>
                    <p class="text-sm text-gray-900">{{ formatDate(inquiry.project.delivery_date) }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="bg-gray-50 px-6 py-3 flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
            <button 
              @click="markAsContacted(inquiry.id)"
              class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150"
            >
              <svg class="mr-2 h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
              Reply via Email
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const inquiries = ref([]);
const loading = ref(true);
const error = ref(null);

const fetchInquiries = async () => {
  try {
    loading.value = true;
    error.value = null;
    const response = await axios.get('/api/professional/inquiries');
    inquiries.value = response.data;
  } catch (err) {
    console.error('Error fetching inquiries:', err);
    error.value = 'Failed to load inquiries. Please try again.';
  } finally {
    loading.value = false;
  }
};

const markAsContacted = async (inquiryId) => {
  try {
    // TODO: Implement mark as contacted API call when backend is ready
    console.log('Reply via Email:', inquiryId);
    fetchInquiries(); // Refresh the list
  } catch (err) {
    console.error('Error updating inquiry status:', err);
  }
};

const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'short', day: 'numeric' };
  return new Date(dateString).toLocaleDateString(undefined, options);
};

// Fetch inquiries when component mounts
onMounted(fetchInquiries);
</script>

<style scoped>
/* Custom styles if needed */
</style>
