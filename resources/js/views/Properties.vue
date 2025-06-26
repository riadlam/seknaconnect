<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-purple-700 to-indigo-800 text-white py-20">
      <div class="absolute inset-0 bg-black/30"></div>
      <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
          <h1 class="text-4xl md:text-5xl font-bold mb-4">Find Your Dream Property</h1>
          <p class="text-xl text-purple-100">
            Browse our selection of premium properties and find your perfect match
          </p>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-12">
      <div class="flex flex-col md:flex-row gap-8">
        <!-- Filters Sidebar -->
        <div class="w-full md:w-80 flex-shrink-0">
          <div class="bg-white rounded-xl shadow-md p-6 sticky top-4">
            <div class="flex justify-between items-center mb-6">
              <h2 class="text-lg font-semibold text-gray-900">Filters</h2>
              <button 
                @click="resetFilters"
                class="text-sm text-purple-600 hover:text-purple-700"
              >
                Reset All
              </button>
            </div>

            <!-- Search -->
            <div class="mb-6">
              <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
              <div class="relative">
                <input
                  type="text"
                  v-model="filters.search"
                  placeholder="Search properties..."
                  class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Property Type -->
            <div class="mb-6">
              <h3 class="text-sm font-medium text-gray-700 mb-3">Property Type</h3>
              <div class="space-y-2">
                <div v-for="type in propertyTypes" :key="type.value" class="flex items-center">
                  <input
                    :id="`type-${type.value}`"
                    v-model="filters.types"
                    type="checkbox"
                    :value="type.value"
                    class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                  >
                  <label :for="`type-${type.value}`" class="ml-3 text-sm text-gray-700">
                    {{ type.label }}
                  </label>
                </div>
              </div>
            </div>

            <!-- Price Range -->
            <div class="mb-6">
              <h3 class="text-sm font-medium text-gray-700 mb-3">Price Range (DZD)</h3>
              <div class="flex items-center gap-3">
                <div class="flex-1">
                  <label for="min-price" class="sr-only">Min price</label>
                  <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <span class="text-gray-500 text-sm">DZD</span>
                    </div>
                    <input
                      type="number"
                      id="min-price"
                      v-model.number="filters.minPrice"
                      placeholder="Min"
                      class="block w-full pl-16 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                      min="0"
                    >
                  </div>
                </div>
                <div class="text-gray-500 mt-1">-</div>
                <div class="flex-1">
                  <label for="max-price" class="sr-only">Max price</label>
                  <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <span class="text-gray-500 text-sm">DZD</span>
                    </div>
                    <input
                      type="number"
                      id="max-price"
                      v-model.number="filters.maxPrice"
                      placeholder="Max"
                      class="block w-full pl-16 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                      :min="filters.minPrice || 0"
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Property List -->
        <div class="flex-1">
          <!-- Sort and View Options -->
          <div class="flex flex-wrap items-center justify-between gap-2 mb-6 w-full">
            <p class="text-sm text-gray-600">
              <span class="hidden xs:inline">Showing</span> <span class="font-medium">{{ filteredProperties.length }}</span> <span class="hidden sm:inline">properties</span>
            </p>
            <div class="flex items-center gap-2">
              <label for="sort" class="text-sm text-gray-700 whitespace-nowrap">
                Sort:
              </label>
              <select
                id="sort"
                v-model="sortOption"
                class="text-sm border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500 py-1.5"
              >
                <option value="featured">Featured</option>
                <option value="price-asc">Price: Low to High</option>
                <option value="price-desc">Price: High to Low</option>
                <option value="newest">Newest</option>
              </select>
            </div>
          </div>

          <!-- Loading State -->
          <div v-if="isLoading" class="flex justify-center items-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600"></div>
          </div>
          
          <!-- Error State -->
          <div v-else-if="error" class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
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
          
          <!-- Property Grid -->
          <div v-else-if="properties.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
            <div 
              v-for="property in properties" 
              :key="property.id"
              @click="navigateToProperty(property.id)"
              class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg cursor-pointer"
            >
              <!-- Property Image -->
              <div class="relative h-48 bg-gray-100">
                <img 
                  v-if="getFirstImage(property)" 
                  :src="getFirstImage(property)" 
                  :alt="property.name"
                  class="w-full h-full object-cover"
                  @error="$event.target.src = 'https://via.placeholder.com/400x300?text=No+Image'"
                >
                <div v-else class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
                <div class="absolute top-2 right-2 bg-white/90 backdrop-blur-sm rounded-full px-2 py-1 text-xs font-medium text-gray-800">
                  {{ property.housing_type || 'Property' }}
                </div>
              </div>
              
              <!-- Property Details -->
              <div class="p-4">
                <div class="flex justify-between items-start">
                  <h3 class="text-lg font-semibold text-gray-900 line-clamp-1">{{ property.name }}</h3>
                  <span class="text-sm font-medium text-purple-700">{{ formatPrice(property.price) }}</span>
                </div>
                
                <p class="mt-1 text-sm text-gray-500 flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  {{ property.location || 'Location not specified' }}
                </p>
                
                <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between">
                  <div class="flex items-center text-sm text-gray-500">
                    <span class="flex items-center mr-4">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                      </svg>
                      {{ property.surface_area || 'N/A' }} m²
                    </span>
                    <span class="flex items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                      </svg>
                      {{ property.num_units || 'N/A' }} units
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Empty State -->
          <div v-else class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No properties found</h3>
            <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter to find what you're looking for.</p>
            <div class="mt-6">
              <button
                @click="resetFilters"
                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
              >
                Reset filters
              </button>
            </div>
          </div>

          <!-- Pagination -->
          <div v-if="!isLoading && !error && properties.length > 0" class="mt-12 flex justify-center">
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
              <!-- Previous Button -->
              <button
                @click="currentPage--"
                :disabled="currentPage === 1"
                :class="{ 'opacity-50 cursor-not-allowed': currentPage === 1 }"
                class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
              >
                <span class="sr-only">Previous</span>
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
              </button>
              
              <!-- Page Numbers -->
              <template v-if="totalPages <= 7">
                <button
                  v-for="page in totalPages"
                  :key="page"
                  @click="currentPage = page"
                  :class="{
                    'z-10 bg-purple-50 border-purple-500 text-purple-600': currentPage === page,
                    'bg-white border-gray-300 text-gray-500 hover:bg-gray-50': currentPage !== page
                  }"
                  class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                  :aria-current="currentPage === page ? 'page' : undefined"
                >
                  {{ page }}
                </button>
              </template>
              
              <template v-else>
                <!-- First page -->
                <button
                  @click="currentPage = 1"
                  :class="{
                    'z-10 bg-purple-50 border-purple-500 text-purple-600': currentPage === 1,
                    'bg-white border-gray-300 text-gray-500 hover:bg-gray-50': currentPage !== 1
                  }"
                  class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                >
                  1
                </button>
                
                <!-- Ellipsis before current page -->
                <span v-if="currentPage > 3" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                  ...
                </span>
                
                <!-- Current page and siblings -->
                <template v-if="currentPage <= 3">
                  <button
                    v-for="page in 3"
                    v-if="page !== 1"
                    :key="page"
                    @click="currentPage = page"
                    :class="{
                      'z-10 bg-purple-50 border-purple-500 text-purple-600': currentPage === page,
                      'bg-white border-gray-300 text-gray-500 hover:bg-gray-50': currentPage !== page
                    }"
                    class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                  >
                    {{ page }}
                  </button>
                </template>
                
                <template v-else-if="currentPage >= totalPages - 2">
                  <button
                    v-for="page in 3"
                    v-if="totalPages - 4 + page !== totalPages"
                    :key="totalPages - 4 + page"
                    @click="currentPage = totalPages - 4 + page"
                    :class="{
                      'z-10 bg-purple-50 border-purple-500 text-purple-600': currentPage === totalPages - 4 + page,
                      'bg-white border-gray-300 text-gray-500 hover:bg-gray-50': currentPage !== totalPages - 4 + page
                    }"
                    class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                  >
                    {{ totalPages - 4 + page }}
                  </button>
                </template>
                
                <template v-else>
                  <button
                    v-for="page in [-1, 0, 1]"
                    :key="currentPage + page"
                    @click="currentPage = currentPage + page"
                    :class="{
                      'z-10 bg-purple-50 border-purple-500 text-purple-600': page === 0,
                      'bg-white border-gray-300 text-gray-500 hover:bg-gray-50': page !== 0
                    }"
                    class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                  >
                    {{ currentPage + page }}
                  </button>
                </template>
                
                <!-- Ellipsis after current page -->
                <span v-if="currentPage < totalPages - 2" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                  ...
                </span>
                
                <!-- Last page -->
                <button
                  @click="currentPage = totalPages"
                  :class="{
                    'z-10 bg-purple-50 border-purple-500 text-purple-600': currentPage === totalPages,
                    'bg-white border-gray-300 text-gray-500 hover:bg-gray-50': currentPage !== totalPages
                  }"
                  class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                >
                  {{ totalPages }}
                </button>
              </template>
              
              <!-- Next Button -->
              <button
                @click="currentPage++"
                :disabled="currentPage === totalPages"
                :class="{ 'opacity-50 cursor-not-allowed': currentPage === totalPages }"
                class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
              >
                <span class="sr-only">Next</span>
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
              </button>
            </nav>
            
            <!-- Page Info -->
            <div class="hidden md:flex items-center ml-4 text-sm text-gray-700">
              <span>Page {{ currentPage }} of {{ totalPages }}</span>
              <span class="mx-2">•</span>
              <span>{{ totalItems }} total properties</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import api from '../services/api';

const router = useRouter();

// State
const properties = ref([]);
const isLoading = ref(true);
const error = ref(null);
const currentPage = ref(1);
const perPage = 12;
const totalItems = ref(0);
const totalPages = ref(1);
const viewMode = ref('grid');
const sortOption = ref('featured');

// Filters
const filters = ref({
  search: '',
  types: [],
  minPrice: null,
  maxPrice: null,
  bedrooms: null,
  bathrooms: null,
  features: []
});

// Property types
const propertyTypes = [
  { value: 'house', label: 'House' },
  { value: 'apartment', label: 'Apartment' },
  { value: 'villa', label: 'Villa' },
  { value: 'condo', label: 'Condo' },
  { value: 'townhouse', label: 'Townhouse' },
  { value: 'penthouse', label: 'Penthouse' },
  { value: 'cabin', label: 'Cabin' },
  { value: 'mansion', label: 'Mansion' },
  { value: 'loft', label: 'Loft' },
  { value: 'farmhouse', label: 'Farmhouse' },
  { value: 'brownstone', label: 'Brownstone' },
  { value: 'cottage', label: 'Cottage' }
];

// Bedroom options
const bedroomOptions = [
  { value: null, label: 'Any' },
  { value: 1, label: '1+' },
  { value: 2, label: '2+' },
  { value: 3, label: '3+' },
  { value: 4, label: '4+' },
  { value: 5, label: '5+' }
];

// Bathroom options
const bathroomOptions = [
  { value: null, label: 'Any' },
  { value: 1, label: '1+' },
  { value: 2, label: '2+' },
  { value: 3, label: '3+' },
  { value: 4, label: '4+' },
  { value: 5, label: '5+' }
];

// Features
const features = [
  { value: 'pool', label: 'Swimming Pool' },
  { value: 'garage', label: 'Garage' },
  { value: 'garden', label: 'Garden' },
  { value: 'fireplace', label: 'Fireplace' },
  { value: 'gym', label: 'Gym' },
  { value: 'security', label: '24/7 Security' },
  { value: 'furnished', label: 'Furnished' },
  { value: 'view', label: 'Scenic View' },
  { value: 'elevator', label: 'Elevator' },
  { value: 'balcony', label: 'Balcony' }
];

// Fetch properties from API
const fetchProperties = async () => {
  try {
    isLoading.value = true;
    error.value = null;
    
    // Make API call to fetch projects
    const response = await api.getProjects(currentPage.value, perPage);
    
    // Transform API response to match our component's expected format
    const formattedData = response.data.map(project => ({
      id: project.id,
      name: project.name,
      location: project.location,
      price: parseFloat(project.price),
      featured: false, // You might want to add this to your API or handle it differently
      bedrooms: 0, // Add these fields to your API or handle them appropriately
      bathrooms: 0, // Add these fields to your API or handle them appropriately
      surface_area: project.surface_area,
      housing_type: project.housing_type,
      images: project.images.map(img => ({
        id: img.id,
        url: img.image_path.startsWith('http') ? img.image_path : `http://192.168.1.8:8000${img.image_path}`,
        image_path: img.image_path,
        caption: img.caption
      })),
      created_at: project.created_at,
      updated_at: project.updated_at,
      num_units: project.num_units,
      delivery_date: project.delivery_date,
      description: project.description
    }));
    
    // Update component state with API data
    properties.value = formattedData;
    totalItems.value = response.total || 0;
    totalPages.value = response.last_page || 1;
    
  } catch (err) {
    console.error('Error fetching properties:', err);
    error.value = 'Failed to load properties. Please try again later.';
    // Reset properties on error
    properties.value = [];
    totalItems.value = 0;
    totalPages.value = 1;
  } finally {
    isLoading.value = false;
  }
};

// Handle property click
const navigateToProperty = (propertyId) => {
  router.push({ name: 'property-details', params: { id: propertyId } });
};

// Format price
const formatPrice = (price) => {
  if (!price) return 'Price on request';
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
    minimumFractionDigits: 0,
    maximumFractionDigits: 0
  }).format(price);
};

// Get first image URL from property
const getFirstImage = (property) => {
  if (!property.images || property.images.length === 0) return '';
  const firstImage = property.images[0];
  return firstImage.image_path || firstImage.url || '';
};

// Filtered properties
const filteredProperties = computed(() => {
  return properties.value.filter(property => {
    // Search filter
    if (filters.value.search) {
      const searchTerm = filters.value.search.toLowerCase();
      const nameMatch = property.name?.toLowerCase().includes(searchTerm) || false;
      const locationMatch = property.location?.toLowerCase().includes(searchTerm) || false;
      if (!nameMatch && !locationMatch) return false;
    }

    // Type filter
    if (filters.value.types.length > 0 && !filters.value.types.includes(property.housing_type)) {
      return false;
    }

    // Price range filter
    if (filters.value.minPrice !== null && property.price < filters.value.minPrice) {
      return false;
    }
    if (filters.value.maxPrice !== null && property.price > filters.value.maxPrice) {
      return false;
    }

    // Bedrooms filter
    if (filters.value.bedrooms !== null && property.bedrooms < filters.value.bedrooms) {
      return false;
    }

    // Bathrooms filter
    if (filters.value.bathrooms !== null && property.bathrooms < filters.value.bathrooms) {
      return false;
    }

    return true;
  });
});

// Sorted properties
const sortedProperties = computed(() => {
  return [...filteredProperties.value].sort((a, b) => {
    switch (sortOption.value) {
      case 'price-asc':
        return a.price - b.price;
      case 'price-desc':
        return b.price - a.price;
      case 'newest':
        return new Date(b.created_at) - new Date(a.created_at);
      case 'featured':
      default:
        // Featured first, then by date (newest first)
        if (a.featured && !b.featured) return -1;
        if (!a.featured && b.featured) return 1;
        return new Date(b.created_at) - new Date(a.created_at);
    }
  });
});

// Pagination
const itemsPerPage = 12;
const paginatedProperties = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return sortedProperties.value.slice(start, end);
});

// Reset all filters
const resetFilters = () => {
  filters.value = {
    search: '',
    types: [],
    minPrice: null,
    maxPrice: null,
    bedrooms: null,
    bathrooms: null,
    features: []
  };
};

// Watch for page changes
watch(currentPage, () => {
  window.scrollTo({ top: 0, behavior: 'smooth' });
  fetchProperties();
});

// Watch for filter changes
// Watch for filter changes
watch([filters, sortOption], () => {
  currentPage.value = 1;
  // In a real app, you might want to refetch data when filters change
  // fetchProperties();
});

// Fetch properties when component is mounted
onMounted(() => {
  fetchProperties();
});
</script>

<style scoped>
/* Custom styles if needed */
</style>
