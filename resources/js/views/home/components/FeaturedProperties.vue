<template>
  <section class="relative py-16 sm:py-20 bg-gradient-to-b from-gray-50 to-white">
    <div class="absolute inset-0 overflow-hidden opacity-10">
      <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiB2aWV3Qm94PSIwIDAgMTAwIDEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIj48cGF0dGVybiBpZD0icGF0dGVybi1iYWNrZ3JvdW5kIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSgzMCkiPjxwYXRoIGQ9Ik0wIDBoNDB2NDBINHYtMzZIMHoiIGZpbGw9IiM4YjVjZjYiIGZpbGwtb3BhY2l0eT0iMC4xIi8+PC9wYXR0ZXJuPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjcGF0dGVybi1iYWNrZ3JvdW5kKSIvPjwvc3ZnPg==')]"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Section Header -->
      <div class="text-center max-w-3xl mx-auto mb-12">
        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-semibold tracking-wide uppercase bg-purple-100 text-purple-700 mb-4">
          <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.355a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.355A1 1 0 0112 2z" clip-rule="evenodd" />
          </svg>
          Featured Properties
        </span>
        <h2 class="text-4xl font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
          <span class="block">Discover Your</span>
          <span class="block text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600">Dream Home</span>
        </h2>
        <p class="mt-4 text-xl text-gray-500 max-w-2xl mx-auto">
          Explore our handpicked selection of premium properties that match your lifestyle and budget.
        </p>
      </div>

      <!-- Property Filters -->
      <div class="mb-10 flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0 sm:space-x-4">
        <div class="flex-1 w-full sm:max-w-md">
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
              </svg>
            </div>
            <input
              v-model="searchQuery"
              type="text"
              class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
              placeholder="Search by location, property type, etc..."
            >
          </div>
        </div>
        <div class="flex space-x-2 overflow-x-auto w-full sm:w-auto pb-2 sm:pb-0">
          <button
            v-for="(filter, index) in propertyFilters"
            :key="index"
            @click="activeFilter = filter.id"
            class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition-colors duration-200"
            :class="activeFilter === filter.id 
              ? 'bg-purple-600 text-white shadow-md' 
              : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
          >
            {{ filter.label }}
          </button>
        </div>
      </div>

      <!-- Property Slider -->
      <div class="relative">
        <!-- Navigation Arrows -->
        <button 
          @click="scrollSlider('prev')"
          class="hidden md:flex absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 z-10 w-12 h-12 rounded-full bg-white shadow-lg items-center justify-center text-purple-600 hover:bg-purple-50 transition-colors focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
          aria-label="Previous slide"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>
        
        <button 
          @click="scrollSlider('next')"
          class="hidden md:flex absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 z-10 w-12 h-12 rounded-full bg-white shadow-lg items-center justify-center text-purple-600 hover:bg-purple-50 transition-colors focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
          aria-label="Next slide"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>
        
        <!-- Slider Container -->
        <div ref="slider" class="relative w-full overflow-hidden">
          <div 
            class="flex transition-transform duration-500 ease-out"
            :style="{ transform: `translateX(-${currentSlide * (100 / slidesToShow)}%)` }"
          >
            <div v-if="isLoading" class="flex w-full justify-center py-12">
              <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-purple-500"></div>
            </div>
            <template v-else-if="error">
              <div class="w-full text-center py-8 text-red-500">
                {{ error }}
              </div>
            </template>
            <template v-else-if="filteredProperties.length === 0">
              <div class="w-full text-center py-8 text-gray-500">
                No properties found matching your criteria.
              </div>
            </template>
            <template v-else>
              <div
                v-for="(property, index) in filteredProperties"
                :key="property.id"
                class="flex-shrink-0 px-2 w-[calc(100%-1rem)] sm:w-1/2 lg:w-1/4"
              >
                <PropertyCard 
                  :property="{
                    id: property.id,
                    title: property.title || property.name,
                    location: property.location,
                    price: property.price,
                    image: property.image,
                    images: property.images,
                    alt: property.title || property.name,
                    area: property.area,
                    type: property.type || property.housing_type,
                    bedrooms: property.bedrooms,
                    bathrooms: property.bathrooms,
                    featured: property.featured || false,
                    description: property.description,
                    delivery_date: property.delivery_date
                  }" 
                  class="h-full w-full cursor-pointer hover:shadow-lg transition-shadow duration-300"
                  @click="viewProperty(property)"
                />
              </div>
            </template>
          </div>
        </div>
        
        <!-- Slider Dots -->
        <div v-if="filteredProperties.length > slidesToShow" class="flex justify-center mt-8 space-x-2">
          <button
            v-for="i in Math.ceil(filteredProperties.length / slidesToShow)"
            :key="i"
            @click="goToSlide(i - 1)"
            class="w-3 h-3 rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
            :class="currentSlide / slidesToShow <= i && currentSlide / slidesToShow > i - 1 ? 'bg-purple-600 w-8' : 'bg-gray-300 hover:bg-gray-400'"
            :aria-label="`Go to slide ${i}`"
          ></button>
        </div>
      </div>
      
      <!-- View All Button -->
      <div class="mt-12 text-center">
        <router-link 
          to="/properties" 
          class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-lg"
        >
          View All Properties
          <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
          </svg>
        </router-link>
      </div>
    </div>
  </section>
</template>

<script>
import { ref, computed, watch, onMounted, onBeforeUnmount } from 'vue';
import { useRouter } from 'vue-router';
import api from '../../../services/api';
import Project from '../../../models/Project';
import PropertyCard from './PropertyCard.vue';

export default {
  name: 'FeaturedProperties',
  components: {
    PropertyCard
  },
  setup() {
    const router = useRouter();
    const slider = ref(null);
    const currentSlide = ref(0);
    const searchQuery = ref('');
    const activeFilter = ref('all');
    const slidesToShow = ref(4);
    const projects = ref([]);
    const isLoading = ref(true);
    const error = ref(null);

    // Fetch projects from API
    const fetchProjects = async () => {
      console.log('⏳ Fetching all projects...');
      try {
        isLoading.value = true;
        error.value = null;
        
        // Get all projects using a direct fetch to ensure we get the raw data
        const response = await fetch('http://192.168.1.8:8000/api/projects', {
          headers: {
            'Accept': 'application/json'
          }
        });
        
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const projectsData = await response.json();
        console.log('✅ Projects API Response:', projectsData);
        
        if (projectsData.length > 0) {
          // Map the API response to the format expected by PropertyCard
          const mappedProjects = projectsData.map(project => ({
            id: project.id,
            name: project.name,
            title: project.name, // For backward compatibility
            type: project.housing_type,
            housing_type: project.housing_type, // Keep original for reference
            location: project.location,
            price: `$${parseFloat(project.price).toLocaleString()}`,
            area: project.surface_area ? `${project.surface_area} m²` : 'N/A',
            image: project.images?.[0]?.image_path || 'https://via.placeholder.com/600x400?text=No+Image',
            images: project.images?.map(img => ({
              image_path: img.image_path,
              url: img.image_path, // Add url as an alias for image_path
              caption: img.caption || ''
            })) || [],
            bedrooms: project.num_units || 0,
            bathrooms: 1, // Default to 1 bathroom
            featured: project.featured || false,
            delivery_date: project.delivery_date,
            description: project.description || '',
            // Add original data in case it's needed
            _original: project
          }));
          
          console.log('🏠 Mapped projects:', mappedProjects);
          projects.value = mappedProjects;
        } else {
          console.warn('⚠️ No projects found in the response');
          projects.value = [];
        }
      } catch (err) {
        console.error('❌ Error fetching projects:', err);
        error.value = 'Failed to load properties. Please try again later.';
        projects.value = [];
      } finally {
        isLoading.value = false;
        console.log('🏁 Finished loading projects. Loading state:', isLoading.value);
      }
    };

    // Navigate to property details
    const viewProperty = (property) => {
      if (property.id) {
        router.push({ name: 'property-details', params: { id: property.id } });
      }
    };
    
    // Update slides to show based on viewport width
    const updateSlidesToShow = () => {
      if (window.innerWidth < 640) {
        slidesToShow.value = 1; // 1 on mobile (w-full)
      } else if (window.innerWidth < 1024) {
        slidesToShow.value = 2; // 2 on tablet (sm:w-1/2)
      } else {
        slidesToShow.value = 4; // 4 on desktop (lg:w-1/4)
      }
      // Reset to first slide when changing slide count
      currentSlide.value = 0;
    };
    
    // Property filters
    const propertyFilters = [
      { id: 'all', label: 'All Properties' },
      { id: 'featured', label: 'Featured' },
      { id: 'new', label: 'New Listings' },
    ];
    
    // Return all properties without filtering
    const filteredProperties = computed(() => {
      console.log('📦 Returning all projects:', projects.value);
      return [...projects.value]; // Return a copy of all projects
    });
    
    // Navigation functions
    const scrollSlider = (direction) => {
      const maxSlide = Math.max(0, filteredProperties.value.length - slidesToShow.value);
      if (direction === 'next') {
        currentSlide.value = Math.min(currentSlide.value + 1, maxSlide);
      } else {
        currentSlide.value = Math.max(0, currentSlide.value - 1);
      }
    };
    
    const goToSlide = (index) => {
      currentSlide.value = index * slidesToShow.value;
    };
    
    // Auto-advance slides
    let slideInterval;
    
    const startSlideShow = () => {
      stopSlideShow();
      if (filteredProperties.value.length > slidesToShow.value) {
        slideInterval = setInterval(() => {
          const maxSlide = Math.max(0, filteredProperties.value.length - slidesToShow.value);
          currentSlide.value = currentSlide.value >= maxSlide ? 0 : currentSlide.value + 1;
        }, 5000);
      }
    };
    
    const stopSlideShow = () => {
      if (slideInterval) {
        clearInterval(slideInterval);
      }
    };
    
    // Handle window resize
    const handleResize = () => {
      updateSlidesToShow();
    };
    
    // Lifecycle hooks
    // Watch for changes in filtered properties
    watch(filteredProperties, (newVal) => {
      console.log('🔄 Filtered properties updated:', newVal);
      // Reset to first slide when filters change
      currentSlide.value = 0;
    }, { immediate: true });

    onMounted(() => {
      console.log('🚀 Component mounted, initializing...');
      updateSlidesToShow();
      window.addEventListener('resize', handleResize);
      fetchProjects().then(() => {
        console.log('🏠 Projects loaded, starting slideshow...');
        startSlideShow();
      }).catch(err => {
        console.error('❌ Failed to initialize component:', err);
      });
    });
    
    onBeforeUnmount(() => {
      window.removeEventListener('resize', handleResize);
      stopSlideShow();
    });
    
    return {
      slider,
      currentSlide,
      searchQuery,
      activeFilter,
      propertyFilters,
      filteredProperties,
      slidesToShow,
      scrollSlider,
      goToSlide,
      viewProperty,
      isLoading,
      error,
      startSlideShow,
      stopSlideShow
    };
  }
}
</script>

<style scoped>
/* Custom scrollbar for the slider */
.slider-container {
  scrollbar-width: thin;
  scrollbar-color: #8b5cf6 #e9d5ff;
  -ms-overflow-style: none;  /* IE and Edge */
}

.slider-container::-webkit-scrollbar {
  height: 6px;
}

.slider-container::-webkit-scrollbar-track {
  background: #e9d5ff;
  border-radius: 3px;
}

.slider-container::-webkit-scrollbar-thumb {
  background-color: #8b5cf6;
  border-radius: 3px;
}

/* Hide scrollbar for Chrome, Safari and Opera */
.no-scrollbar::-webkit-scrollbar {
  display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.no-scrollbar {
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}

/* Smooth transitions */
.slide-enter-active,
.slide-leave-active {
  transition: all 0.5s ease;
}

.slide-enter-from,
.slide-leave-to {
  opacity: 0;
  transform: translateX(30px);
}

/* Responsive grid for mobile */
@screen sm {
  .property-grid {
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  }
}
</style>
