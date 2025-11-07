<template>
  <section id="featured-properties" class="relative py-16 sm:py-20 bg-gradient-to-b from-gray-50 to-white featured-properties-section">
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
          Propriétés en Vedette
        </span>
        <h2 class="text-4xl font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
          <span class="block">Découvrez Votre</span>
          <span class="block text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600">Maison de Rêve</span>
        </h2>
        <p class="mt-4 text-xl text-gray-500 max-w-2xl mx-auto">
          Découvrez notre sélection de propriétés haut de gamme qui correspondent à votre style de vie et à votre budget.
        </p>
      </div>

      <!-- Property Search -->
      <div class="mb-10 w-full max-w-2xl mx-auto">
        <div class="relative">
          <div class="relative rounded-lg bg-white/80 backdrop-blur-sm border border-gray-200 shadow-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
              </svg>
            </div>
            <input
              type="text"
              v-model="searchQuery"
              @focus="onSearchFocus"
              @blur="onSearchBlur"
              @input="onSearchInput"
              class="block w-full pl-10 pr-10 py-3 border-0 bg-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-0 sm:text-sm rounded-lg"
              placeholder="Rechercher des biens..."
            />
            <div v-if="isSearchLoading" class="absolute inset-y-0 right-0 flex items-center pr-3">
              <svg class="animate-spin h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
            </div>
            <div v-else-if="searchQuery" class="absolute inset-y-0 right-0 flex items-center pr-3">
              <button @click.prevent="clearSearch" class="text-gray-400 hover:text-gray-500">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>

          <!-- Search Results Dropdown -->
          <div v-if="searchQuery && isSearchFocused" class="absolute z-20 mt-1 w-full rounded-md bg-white shadow-lg max-h-96 overflow-auto border border-gray-200">
            <div v-if="isSearchLoading" class="p-4 flex justify-center">
              <svg class="animate-spin h-5 w-5 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
            </div>
            <div v-else-if="searchResults.length > 0" class="py-1">
              <router-link 
                v-for="result in searchResults" 
                :key="result.id" 
                :to="`/properties/${result.id}`"
                class="block px-4 py-3 hover:bg-gray-50 cursor-pointer transition-colors border-b border-gray-100 last:border-b-0"
              >
                <div class="flex items-start">
                  <div class="flex-shrink-0 h-16 w-16 rounded-md overflow-hidden bg-gray-100">
                    <img 
                      v-if="result.images && result.images.length > 0"
                      :src="result.images[0].image_path" 
                      :alt="result.name"
                      class="h-full w-full object-cover"
                    />
                    <div v-else class="h-full w-full bg-gray-200 flex items-center justify-center">
                      <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                    </div>
                  </div>
                  <div class="ml-3 flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ result.name }}</p>
                    <p class="text-sm text-gray-500">
                      {{ result.housing_type }} · {{ formatPrice(result.price) }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1 truncate">
                      {{ getLocation(result.location) }}
                    </p>
                  </div>
                </div>
              </router-link>
            </div>
            <div v-else-if="!isSearchLoading" class="p-4 text-center text-sm text-gray-500">
              Aucun résultat trouvé
            </div>
          </div>
        </div>
      </div>

      <!-- Property Slider -->
      <div class="relative">
        <!-- Navigation Arrows -->
        <button 
          v-if="featuredProperties.length > slidesToShow"
          @click="scrollSlider('prev')"
          class="hidden md:flex absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 z-10 w-12 h-12 rounded-full bg-white shadow-lg items-center justify-center text-purple-600 hover:bg-purple-50 transition-colors focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
          aria-label="Previous slide"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>
        
        <button 
          v-if="featuredProperties.length > slidesToShow"
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
            <template v-else-if="featuredProperties.length === 0">
              <div class="w-full text-center py-8 text-gray-500">
                Aucune propriété ne correspond à vos critères.
              </div>
            </template>
            <template v-else>
              <div
                v-for="(property, index) in featuredProperties"
                :key="property.id"
                :class="[
                  'flex-shrink-0 px-2',
                  slidesToShow === 1 ? 'w-full' : slidesToShow === 2 ? 'w-1/2' : 'w-1/4'
                ]"
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
        <div v-if="featuredProperties.length > slidesToShow" class="flex justify-center mt-8 space-x-2">
          <button
            v-for="i in Math.ceil(featuredProperties.length / slidesToShow)"
            :key="i"
            @click="goToSlide(i - 1)"
            class="w-3 h-3 rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
            :class="Math.floor(currentSlide / slidesToShow) === (i - 1) ? 'bg-purple-600 w-8' : 'bg-gray-300 hover:bg-gray-400'"
            :aria-label="`Go to slide ${i}`"
          ></button>
        </div>
      </div>
      
      <!-- All Projects Grid Section -->
      <div class="mt-20">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600">Tous les Projets</span>
          </h2>
          <p class="mt-4 text-lg text-gray-500">
            Explorez notre collection complète de propriétés
          </p>
        </div>
        
        <!-- Projects Grid -->
        <div v-if="isLoading" class="flex justify-center py-12">
          <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-purple-500"></div>
        </div>
        <div v-else-if="error" class="text-center py-8 text-red-500">
          {{ error }}
        </div>
        <div v-else-if="allProjects.length === 0" class="text-center py-8 text-gray-500">
          Aucun projet disponible.
        </div>
        <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <PropertyCard 
            v-for="property in allProjects"
            :key="property.id"
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
      </div>
      
      <!-- View All Button -->
      <div class="mt-12 text-center">
        <router-link 
          to="/properties" 
          class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-lg"
        >
          Voir toutes les propriétés
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
import axios from 'axios';
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
    const slidesToShow = ref(3); // Default for larger screens
    
    // Search functionality
    const searchQuery = ref('');
    const searchResults = ref([]);
    const isSearchLoading = ref(false);
    const isSearchFocused = ref(false);
    const searchTimeout = ref(null);
    
    const activeFilter = ref('all');
    const projects = ref([]);
    const isLoading = ref(true);
    const error = ref(null);
    
    // Helper function to get price from payment plan or regular price field
    const getProjectPrice = (project) => {
      // First, check payment plan for cash or bank amount
      if (project.payment_plan) {
        try {
          const paymentPlanData = typeof project.payment_plan === 'string' 
            ? JSON.parse(project.payment_plan) 
            : project.payment_plan;
          
          if (paymentPlanData.paymentMethod === 'cash' && paymentPlanData.cashAmount) {
            return paymentPlanData.cashAmount;
          } else if (paymentPlanData.paymentMethod === 'bank' && paymentPlanData.bankFullAmount) {
            return paymentPlanData.bankFullAmount;
          }
        } catch (e) {
          console.warn('Could not parse payment plan:', e);
        }
      }
      
      // Fall back to regular price field
      return project.price || null;
    };

    // Fetch projects from API
    const fetchProjects = async () => {
      console.log('⏳ Fetching all projects...');
      try {
        isLoading.value = true;
        error.value = null;
        
        // Get all projects using a direct fetch to ensure we get the raw data
        const response = await fetch('https://sekna.soexplast.com/api/projects', {
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
          const mappedProjects = projectsData.map(project => {
            const projectPrice = getProjectPrice(project);
            return {
              id: project.id,
              name: project.name,
              title: project.name, // For backward compatibility
              type: project.housing_type,
              housing_type: project.housing_type, // Keep original for reference
              location: project.location,
              price: projectPrice, // Use the extracted price
              payment_plan: project.payment_plan, // Pass payment plan for reference
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
            };
          });
          
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
        slidesToShow.value = 3; // 3 on desktop (lg:w-1/4)
      }
      // Reset to first slide when changing slide count
      currentSlide.value = 0;
    };
    
    // Search functions
    const formatPrice = (price) => {
      if (!price && price !== 0) return 'N/A';
      const numericValue = Number(price);
      if (isNaN(numericValue)) return 'N/A';
      return new Intl.NumberFormat('fr-DZ', {
        style: 'currency',
        currency: 'DZD',
        maximumFractionDigits: 0
      }).format(numericValue);
    };

    const getLocation = (location) => {
      if (!location) return '';
      try {
        const loc = typeof location === 'string' ? JSON.parse(location) : location;
        return [loc.wilaya, loc.commune, loc.daira].filter(Boolean).join(', ');
      } catch (e) {
        return location;
      }
    };

    const searchProjects = async (query) => {
      if (!query.trim()) {
        searchResults.value = [];
        return;
      }

      isSearchLoading.value = true;
      try {
        const response = await axios.get(`/api/projects/search?q=${encodeURIComponent(query)}`);
        // Map search results to include extracted price
        searchResults.value = response.data.map(project => ({
          ...project,
          price: getProjectPrice(project)
        }));
      } catch (error) {
        console.error('Search error:', error);
        searchResults.value = [];
      } finally {
        isSearchLoading.value = false;
      }
    };

    const onSearchInput = () => {
      clearTimeout(searchTimeout.value);
      searchTimeout.value = setTimeout(() => {
        searchProjects(searchQuery.value);
      }, 300); // 300ms debounce
    };

    const onSearchFocus = () => {
      isSearchFocused.value = true;
      if (searchQuery.value) {
        searchProjects(searchQuery.value);
      }
    };

    const onSearchBlur = () => {
      // Small delay to allow click on results before hiding
      setTimeout(() => {
        isSearchFocused.value = false;
      }, 200);
    };

    const clearSearch = () => {
      searchQuery.value = '';
      searchResults.value = [];
    };

    // Property filters
    const propertyFilters = [
      { id: 'all', label: 'Toutes les propriétés' },
      { id: 'featured', label: 'En vedette' },
      { id: 'new', label: 'Nouvelles annonces' },
    ];
    
    // Featured properties: Last 5 projects
    const featuredProperties = computed(() => {
      return [...projects.value].slice(-5).reverse(); // Get last 5 and reverse to show newest first
    });
    
    // All projects for grid display
    const allProjects = computed(() => {
      return [...projects.value].reverse(); // Reverse to show newest first
    });
    
    // Return all properties without filtering (kept for backward compatibility)
    const filteredProperties = computed(() => {
      return featuredProperties.value; // Use featured properties for slider
    });
    
    // Navigation functions
    const scrollSlider = (direction) => {
      if (featuredProperties.value.length === 0) return;
      
      const maxSlide = Math.max(0, featuredProperties.value.length - slidesToShow.value);
      
      if (direction === 'next') {
        if (currentSlide.value >= maxSlide) {
          // Loop back to start
          currentSlide.value = 0;
        } else {
          currentSlide.value = Math.min(currentSlide.value + 1, maxSlide);
        }
      } else {
        // Previous
        if (currentSlide.value <= 0) {
          // Loop to end
          currentSlide.value = maxSlide;
        } else {
          currentSlide.value = Math.max(0, currentSlide.value - 1);
        }
      }
    };
    
    const goToSlide = (index) => {
      const maxSlide = Math.max(0, featuredProperties.value.length - slidesToShow.value);
      currentSlide.value = Math.min(index * slidesToShow.value, maxSlide);
    };
    
    // Auto-advance slides
    let slideInterval;
    
    const startSlideShow = () => {
      stopSlideShow();
      if (featuredProperties.value.length > slidesToShow.value) {
        slideInterval = setInterval(() => {
          const maxSlide = Math.max(0, featuredProperties.value.length - slidesToShow.value);
          if (currentSlide.value >= maxSlide) {
            // Loop back to start
            currentSlide.value = 0;
          } else {
            currentSlide.value = currentSlide.value + 1;
          }
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
    // Watch for changes in featured properties
    watch(featuredProperties, (newVal) => {
      console.log('🔄 Featured properties updated:', newVal);
      // Reset to first slide when properties change
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
      if (searchTimeout.value) {
        clearTimeout(searchTimeout.value);
      }
    });
    
    return {
      slider,
      currentSlide,
      // Search related
      searchQuery,
      searchResults,
      isSearchLoading,
      isSearchFocused,
      onSearchInput,
      onSearchFocus,
      onSearchBlur,
      clearSearch,
      formatPrice,
      getLocation,
      
      // Filters
      activeFilter,
      propertyFilters,
      filteredProperties,
      featuredProperties,
      allProjects,
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
