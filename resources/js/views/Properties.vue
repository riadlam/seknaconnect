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
              <h3 class="text-sm font-medium text-gray-700 mb-3">Price Range</h3>
              <div class="flex items-center space-x-4">
                <div class="flex-1">
                  <label for="min-price" class="sr-only">Min price</label>
                  <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <span class="text-gray-500 sm:text-sm">$</span>
                    </div>
                    <input
                      type="number"
                      id="min-price"
                      v-model.number="filters.minPrice"
                      placeholder="Min"
                      class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-7 pr-3 sm:text-sm border-gray-300 rounded-md"
                    >
                  </div>
                </div>
                <div class="flex-1">
                  <label for="max-price" class="sr-only">Max price</label>
                  <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <span class="text-gray-500 sm:text-sm">$</span>
                    </div>
                    <input
                      type="number"
                      id="max-price"
                      v-model.number="filters.maxPrice"
                      placeholder="Max"
                      class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-7 pr-3 sm:text-sm border-gray-300 rounded-md"
                    >
                  </div>
                </div>
              </div>
            </div>

            <!-- Bedrooms -->
            <div class="mb-6">
              <h3 class="text-sm font-medium text-gray-700 mb-3">Bedrooms</h3>
              <div class="grid grid-cols-3 gap-2">
                <button
                  v-for="option in bedroomOptions"
                  :key="option.value"
                  @click="filters.bedrooms = option.value"
                  type="button"
                  class="py-2 px-3 text-center text-sm rounded-md border transition-colors"
                  :class="{
                    'bg-purple-600 text-white border-purple-600': filters.bedrooms === option.value,
                    'bg-white text-gray-700 border-gray-300 hover:bg-gray-50': filters.bedrooms !== option.value
                  }"
                >
                  {{ option.label }}
                </button>
              </div>
            </div>

            <!-- Bathrooms -->
            <div class="mb-6">
              <h3 class="text-sm font-medium text-gray-700 mb-3">Bathrooms</h3>
              <div class="grid grid-cols-3 gap-2">
                <button
                  v-for="option in bathroomOptions"
                  :key="option.value"
                  @click="filters.bathrooms = option.value"
                  type="button"
                  class="py-2 px-3 text-center text-sm rounded-md border transition-colors"
                  :class="{
                    'bg-purple-600 text-white border-purple-600': filters.bathrooms === option.value,
                    'bg-white text-gray-700 border-gray-300 hover:bg-gray-50': filters.bathrooms !== option.value
                  }"
                >
                  {{ option.label }}
                </button>
              </div>
            </div>

            <!-- Features -->
            <div class="mb-6">
              <h3 class="text-sm font-medium text-gray-700 mb-3">Features</h3>
              <div class="space-y-2">
                <div v-for="feature in features" :key="feature.value" class="flex items-center">
                  <input
                    :id="`feature-${feature.value}`"
                    v-model="filters.features"
                    type="checkbox"
                    :value="feature.value"
                    class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                  >
                  <label :for="`feature-${feature.value}`" class="ml-3 text-sm text-gray-700">
                    {{ feature.label }}
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Property List -->
        <div class="flex-1">
          <!-- Sort and View Options -->
          <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <p class="text-sm text-gray-600">
              Showing <span class="font-medium">{{ filteredProperties.length }}</span> properties
            </p>
            <div class="flex items-center space-x-4">
              <div class="flex items-center">
                <label for="sort" class="mr-2 text-sm font-medium text-gray-700">Sort by:</label>
                <select
                  id="sort"
                  v-model="sortOption"
                  class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md"
                >
                  <option value="featured">Featured</option>
                  <option value="price-asc">Price: Low to High</option>
                  <option value="price-desc">Price: High to Low</option>
                  <option value="newest">Newest First</option>
                </select>
              </div>
              <div class="hidden sm:flex items-center space-x-1">
                <button
                  @click="viewMode = 'grid'"
                  type="button"
                  class="p-2 rounded-md hover:bg-gray-100"
                  :class="{ 'text-purple-600 bg-purple-50': viewMode === 'grid' }"
                >
                  <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                  </svg>
                  <span class="sr-only">Grid view</span>
                </button>
                <button
                  @click="viewMode = 'list'"
                  type="button"
                  class="p-2 rounded-md hover:bg-gray-100"
                  :class="{ 'text-purple-600 bg-purple-50': viewMode === 'list' }"
                >
                  <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                  </svg>
                  <span class="sr-only">List view</span>
                </button>
              </div>
            </div>
          </div>

          <!-- Property Grid -->
          <div v-if="filteredProperties.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
            <PropertyCard
              v-for="property in sortedProperties"
              :key="property.id"
              :property="property"
              class="h-full"
            />
          </div>
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
          <div v-if="filteredProperties.length > 0" class="mt-12 flex justify-center">
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
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
              <button
                v-for="page in totalPages"
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
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, watch } from 'vue';
import PropertyCard from './home/components/PropertyCard.vue';

export default {
  name: 'Properties',
  components: {
    PropertyCard
  },
  setup() {
    // Sample property data - replace with your actual data
    const properties = ref([
      {
        id: 1,
        title: 'Modern Villa with Ocean View',
        location: 'Malibu, California',
        price: 2500000,
        featured: true,
        bedrooms: 5,
        bathrooms: 4.5,
        area: 320,
        listedDate: '2023-05-15',
        type: 'house',
        images: [
          'https://images.unsplash.com/photo-1613977257363-707ba9348227?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
          'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
          'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80'
        ]
      },
      // Add more sample properties as needed
      {
        id: 2,
        title: 'Luxury Apartment in Downtown',
        location: 'New York, NY',
        price: 1200000,
        featured: false,
        bedrooms: 3,
        bathrooms: 2,
        area: 180,
        listedDate: '2023-06-20',
        type: 'apartment',
        images: [
          'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
          'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80'
        ]
      },
      {
        id: 3,
        title: 'Beachfront Villa with Pool',
        location: 'Miami, Florida',
        price: 3200000,
        featured: true,
        bedrooms: 6,
        bathrooms: 5,
        area: 420,
        listedDate: '2023-04-10',
        type: 'villa',
        images: [
          'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
          'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80'
        ]
      },
      {
        id: 4,
        title: 'Mountain View Cabin',
        location: 'Aspen, Colorado',
        price: 1950000,
        featured: false,
        bedrooms: 4,
        bathrooms: 3,
        area: 280,
        listedDate: '2023-07-05',
        type: 'cabin',
        images: [
          'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
          'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80'
        ]
      },
      {
        id: 5,
        title: 'Modern Loft in Arts District',
        location: 'Los Angeles, California',
        price: 1200000,
        featured: true,
        bedrooms: 2,
        bathrooms: 2,
        area: 160,
        listedDate: '2023-06-30',
        type: 'loft',
        images: [
          'https://images.unsplash.com/photo-1613977257363-707ba9348227?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
          'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80'
        ]
      },
      {
        id: 6,
        title: 'Luxury Penthouse with City View',
        location: 'Chicago, Illinois',
        price: 1850000,
        featured: true,
        bedrooms: 3,
        bathrooms: 3.5,
        area: 240,
        listedDate: '2023-07-12',
        type: 'penthouse',
        images: [
          'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1453&q=80',
        ]
      },
      {
        id: 7,
        title: 'Cozy Cottage by the Lake',
        location: 'Lake Tahoe, Nevada',
        price: 950000,
        featured: false,
        bedrooms: 3,
        bathrooms: 2,
        area: 180,
        listedDate: '2023-07-18',
        type: 'cottage',
        images: [
          'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
          'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80'
        ]
      },
      {
        id: 8,
        title: 'Modern Farmhouse Retreat',
        location: 'Austin, Texas',
        price: 1750000,
        featured: true,
        bedrooms: 4,
        bathrooms: 3.5,
        area: 320,
        listedDate: '2023-06-22',
        type: 'farmhouse',
        images: [
          'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
          'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80'
        ]
      },
      {
        id: 9,
        title: 'Luxury Waterfront Mansion',
        location: 'Naples, Florida',
        price: 4850000,
        featured: true,
        bedrooms: 7,
        bathrooms: 6.5,
        area: 580,
        listedDate: '2023-07-01',
        type: 'mansion',
        images: [
          'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1453&q=80',
          'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80'
        ]
      },
      {
        id: 10,
        title: 'Charming Brownstone',
        location: 'Boston, Massachusetts',
        price: 2250000,
        featured: false,
        bedrooms: 3,
        bathrooms: 2.5,
        area: 240,
        listedDate: '2023-07-15',
        type: 'brownstone',
        images: [
          'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
          'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80'
        ]
      }
    ]);

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

    // View mode (grid/list)
    const viewMode = ref('grid');
    
    // Sort option
    const sortOption = ref('featured');
    
    // Pagination
    const itemsPerPage = 12;
    const currentPage = ref(1);

    // Filter and sort options
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

    const bedroomOptions = [
      { value: null, label: 'Any' },
      { value: 1, label: '1+' },
      { value: 2, label: '2+' },
      { value: 3, label: '3+' },
      { value: 4, label: '4+' },
      { value: 5, label: '5+' }
    ];

    const bathroomOptions = [
      { value: null, label: 'Any' },
      { value: 1, label: '1+' },
      { value: 2, label: '2+' },
      { value: 3, label: '3+' },
      { value: 4, label: '4+' },
      { value: 5, label: '5+' }
    ];

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

    // Filtered properties
    const filteredProperties = computed(() => {
      return properties.value.filter(property => {
        // Search filter
        if (filters.value.search) {
          const searchTerm = filters.value.search.toLowerCase();
          const titleMatch = property.title.toLowerCase().includes(searchTerm);
          const locationMatch = property.location.toLowerCase().includes(searchTerm);
          if (!titleMatch && !locationMatch) return false;
        }

        // Type filter
        if (filters.value.types.length > 0 && !filters.value.types.includes(property.type)) {
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

        // Features filter (if implemented in property data)
        // if (filters.value.features.length > 0) {
        //   const propertyFeatures = property.features || [];
        //   const hasAllFeatures = filters.value.features.every(feature => 
        //     propertyFeatures.includes(feature)
        //   );
        //   if (!hasAllFeatures) return false;
        // }


        return true;
      });
    });

    // Sorted properties
    const sortedProperties = computed(() => {
      const filtered = [...filteredProperties.value];
      
      switch (sortOption.value) {
        case 'price-asc':
          return filtered.sort((a, b) => a.price - b.price);
        case 'price-desc':
          return filtered.sort((a, b) => b.price - a.price);
        case 'newest':
          return filtered.sort((a, b) => new Date(b.listedDate) - new Date(a.listedDate));
        case 'featured':
        default:
          return filtered.sort((a, b) => {
            // Featured first, then by date (newest first)
            if (a.featured && !b.featured) return -1;
            if (!a.featured && b.featured) return 1;
            return new Date(b.listedDate) - new Date(a.listedDate);
          });
      }
    });

    // Pagination
    const totalPages = computed(() => {
      return Math.ceil(filteredProperties.value.length / itemsPerPage);
    });

    const paginatedProperties = computed(() => {
      const start = (currentPage.value - 1) * itemsPerPage;
      const end = start + itemsPerPage;
      return sortedProperties.value.slice(0, end); // Show all items for now, implement pagination if needed
    });

    // Reset pagination when filters change
    watch([filters, sortOption], () => {
      currentPage.value = 1;
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

    return {
      properties,
      filters,
      viewMode,
      sortOption,
      currentPage,
      totalPages,
      filteredProperties,
      sortedProperties,
      paginatedProperties,
      propertyTypes,
      bedroomOptions,
      bathroomOptions,
      features,
      resetFilters
    };
  }
};
</script>

<style scoped>
/* Custom styles if needed */
</style>
