<template>
    <div>
      <!-- Loading State -->
      <div v-if="isLoading" class="min-h-screen flex items-center justify-center">
        <div class="text-center">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600 mx-auto"></div>
          <p class="mt-4 text-gray-600">Loading property details...</p>
        </div>
      </div>
  
      <!-- Error State -->
      <div v-else-if="error" class="min-h-screen flex items-center justify-center">
        <div class="text-center max-w-md p-6 bg-white rounded-lg shadow-md">
          <div class="text-red-500 text-5xl mb-4">⚠️</div>
          <h2 class="text-2xl font-bold text-gray-800 mb-2">Error Loading Property</h2>
          <p class="text-gray-600 mb-6">{{ error }}</p>
          <button 
            @click="fetchProperty"
            class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors"
          >
            Try Again
          </button>
        </div>
      </div>
  
      <!-- Main Content -->
      <div v-else class="min-h-screen bg-gray-50">
        <!-- Property Header with Image Gallery -->
        <div class="relative bg-white overflow-hidden">
          <!-- Back Button -->
          <div class="absolute top-4 left-4 z-10">
            <button 
              @click="$router.go(-1)" 
              class="bg-white/90 backdrop-blur-sm p-2 rounded-full shadow-md hover:bg-white transition-colors duration-200"
              aria-label="Go back"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
            </button>
          </div>
  
          <!-- Main Image -->
          <div class="relative h-96 w-full bg-gray-200 overflow-hidden">
            <img 
              v-if="currentImage"
              :src="currentImage" 
              :alt="property.title"
              class="w-full h-full object-cover transition-opacity duration-500"
              :class="{'opacity-0': !imageLoaded}"
              @load="onImageLoad"
            >
            <div v-else class="w-full h-full bg-gray-200 flex items-center justify-center">
              <span class="text-gray-400">No image available</span>
            </div>
            <div v-if="!imageLoaded" class="absolute inset-0 bg-gray-200 animate-pulse"></div>
          </div>
  
          <!-- Image Thumbnails -->
          <div class="flex px-4 py-3 space-x-2 overflow-x-auto bg-white border-t border-gray-100">
            <button 
              v-for="(img, index) in property.images.slice(0, 5)" 
              :key="index"
              @click="setCurrentImage(img)"
              class="flex-shrink-0 w-16 h-16 rounded-md overflow-hidden border-2 transition-all duration-200"
              :class="{
                'border-purple-600 ring-2 ring-purple-400': currentImage === getImageUrl(img),
                'border-transparent hover:border-gray-300': currentImage !== getImageUrl(img)
              }"
            >
              <img :src="getImageUrl(img)" class="w-full h-full object-cover" :alt="'Property image ' + (index + 1)">
            </button>
          </div>
        </div>
  
        <!-- Property Details -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-2">
              <!-- Title and Price -->
              <div class="border-b border-gray-200 pb-6">
                <h1 class="text-3xl font-bold text-gray-900">{{ property.name }}</h1>
                <div class="mt-2 flex items-center">
                  <span class="text-2xl font-semibold text-purple-700">{{ formattedPrice }}</span>
                  <span v-if="property.pricePer" class="ml-2 text-gray-500">/ {{ property.pricePer }}</span>
                </div>
                <div class="mt-3 flex items-center text-sm text-gray-500">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  <span>{{ property.location || 'Location not specified' }}</span>
                </div>
              </div>
  
              <!-- Highlights -->
              <div class="py-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Property Details</h2>
                <div class="grid grid-cols-2 gap-4">
                  <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span class="text-gray-600">{{ property.housingType || 'N/A' }}</span>
                  </div>
                  <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="text-gray-600">{{ property.surfaceArea }} m²</span>
                  </div>
                  <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-gray-600">Delivery: {{ property.deliveryDate || 'N/A' }}</span>
                  </div>
                  <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-gray-600">Posted: {{ new Date(property.createdAt).toLocaleDateString() }}</span>
                  </div>
                </div>
              </div>
  
              <!-- Description -->
              <div class="py-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Description</h2>
                <p class="text-gray-600 whitespace-pre-line">{{ property.description || 'No description available.' }}</p>
              </div>
  
              <!-- Features -->
              <div class="py-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Features & Amenities</h2>
                <div class="grid grid-cols-2 gap-4">
                  <div v-for="(feature, index) in property.features" :key="index" class="flex items-center">
                    <div class="flex-shrink-0 h-5 w-5 text-purple-500">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                      </svg>
                    </div>
                    <span class="ml-2 text-gray-700">{{ feature }}</span>
                  </div>
                </div>
              </div>
            </div>
  
            <!-- Right Column - Contact Form -->
            <div class="mt-8 lg:mt-0">
              <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-purple-600 to-indigo-600 p-6 text-white">
                  <h3 class="text-xl font-semibold">Interested in this property?</h3>
                  <p class="mt-1 text-purple-100">Contact the seller for more information</p>
                </div>
                <div class="p-6">
                  <form @submit.prevent="submitInquiry" class="space-y-4 relative" :class="{ 'opacity-50': isSubmitting }">
                    <div v-if="isSubmitting" class="absolute inset-0 bg-white/50 flex items-center justify-center z-10">
                      <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-purple-600"></div>
                    </div>
                    <div>
                      <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                      <input 
                        type="text" 
                        id="name" 
                        v-model="inquiryForm.name"
                        :disabled="isSubmitting"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm disabled:bg-gray-50 disabled:text-gray-500"
                        placeholder="Your name"
                      >
                    </div>
                    <div>
                      <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                      <input 
                        type="email" 
                        id="email" 
                        v-model="inquiryForm.email"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                        placeholder="your@email.com"
                      >
                    </div>
                    <div>
                      <label for="phone" class="block text-sm font-medium text-gray-700">Phone (optional)</label>
                      <input 
                        type="tel" 
                        id="phone" 
                        v-model="inquiryForm.phone"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm disabled:bg-gray-50 disabled:text-gray-500"
                        :disabled="isSubmitting"
                        placeholder="+212 6XX-XXXXXX"
                      >
                    </div>
                    <div>
                      <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                      <textarea 
                        id="message" 
                        v-model="inquiryForm.message"
                        rows="4"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm disabled:bg-gray-50 disabled:text-gray-500"
                        :disabled="isSubmitting"
                        placeholder="I'm interested in this property..."
                      ></textarea>
                    </div>
                    <div class="space-y-2">
                      <button 
                        type="submit" 
                        :disabled="isSubmitting"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                      >
                        <span v-if="!isSubmitting">Send Message</span>
                        <span v-else class="flex items-center">
                          <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                          </svg>
                          Sending...
                        </span>
                      </button>
                      
                      <div v-if="formError" class="text-red-600 text-sm p-2 bg-red-50 rounded-md">
                        {{ formError }}
                      </div>
                      
                      <div v-if="submissionSuccess" class="p-3 bg-green-50 border border-green-200 text-green-700 rounded-md text-sm transition-all duration-300 ease-in-out">
                        <div class="flex items-center">
                          <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                          </svg>
                          <span>Your message has been sent successfully! We'll get back to you soon.</span>
                        </div>
                      </div>
                    </div>
                  </form>
                  
                  <!-- Contact Information -->
                  <div v-if="property?.user" class="mt-6 pt-4 border-t border-gray-100">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Contact Information</h4>
                    <p class="text-sm font-medium text-gray-900">{{ property.user.name }}</p>
                    <p class="text-sm text-purple-600 mt-1">
                      <a :href="'mailto:' + property.user.email" class="hover:underline">{{ property.user.email }}</a>
                    </p>
                    <p v-if="property.user.phone" class="text-sm text-purple-600 mt-1">
                      <a :href="'tel:' + property.user.phone" class="hover:underline">{{ property.user.phone }}</a>
                    </p>
                  </div>
                </div>
                
                <!-- Schedule Visit Section -->
                <div class="mt-6 bg-white rounded-lg shadow-md overflow-hidden border border-gray-100">
                  <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Schedule a Visit</h3>
                    <button 
                      @click="scheduleVisit"
                      class="w-full flex items-center justify-center px-4 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                      Schedule a Visit
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Similar Properties -->
        <div class="bg-gray-50 py-12">
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Similar Properties</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
              <!-- Similar property cards would go here -->
              <div v-for="i in 3" :key="i" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="h-48 bg-gray-200 animate-pulse"></div>
                <div class="p-4">
                  <div class="h-6 bg-gray-200 rounded w-3/4 mb-2 animate-pulse"></div>
                  <div class="h-4 bg-gray-200 rounded w-1/2 mb-4 animate-pulse"></div>
                  <div class="flex justify-between items-center">
                    <div class="h-6 bg-gray-200 rounded w-1/3 animate-pulse"></div>
                    <div class="h-10 w-10 rounded-full bg-gray-200 animate-pulse"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, computed, watch } from 'vue';
  import { useRoute, useRouter } from 'vue-router';
  import api from '../services/api';
  import Project from '../models/Project';
  
  const route = useRoute();
  const router = useRouter();
  
  // State
  const property = ref(null);
  const isLoading = ref(true);
  const error = ref(null);
  const currentImage = ref('');
  const imageLoaded = ref(false);
  const isSubmitting = ref(false);
  const submissionSuccess = ref(false);
  const formError = ref('');
  
  // Form data
  const inquiryForm = ref({
    name: '',
    email: '',
    phone: '',
    message: ''
  });
  
  // Helper function to get image URL from either string or object
  const getImageUrl = (img) => {
    if (!img) return '';
    // If it's already a string URL, return it
    if (typeof img === 'string') return img;
    // If it's an object with a url/path property, return that
    if (img.url) return img.url;
    if (img.path) return img.path;
    // If it's an object with other properties, try to find the first string value
    const firstValue = Object.values(img).find(val => typeof val === 'string');
    return firstValue || '';
  };
  
  // Set current image with proper URL handling
  const setCurrentImage = (img) => {
    currentImage.value = getImageUrl(img);
    imageLoaded.value = false;
  };
  
  // Fetch property data
  const fetchProperty = async () => {
    const propertyId = route.params.id;
    
    if (!propertyId) {
      error.value = 'No property ID provided';
      isLoading.value = false;
      return;
    }
    
    try {
      console.log(`⏳ Fetching property with ID: ${propertyId}...`);
      isLoading.value = true;
      error.value = null;
      
      const response = await api.getProject(propertyId);
      console.log('✅ Raw API Response:', JSON.parse(JSON.stringify(response)));
      
      // Check if response exists and has data
      if (!response) {
        throw new Error('No response received from server');
      }
      
      // Handle case where response might be the data directly
      const responseData = response.data || response;
      
      if (!responseData) {
        throw new Error('No data in response');
      }
      
      console.log('📦 Response Data:', responseData);
      
      // Transform the API response to match the Project model's expectations
      const formattedData = {
        id: responseData.id,
        user_id: responseData.user_id,
        name: responseData.name,
        housing_type: responseData.housing_type,
        num_units: responseData.num_units,
        location: responseData.location,
        delivery_date: responseData.delivery_date,
        price: responseData.price,
        surface_area: responseData.surface_area,
        description: responseData.description,
        created_at: responseData.created_at,
        updated_at: responseData.updated_at,
        // Handle images if they exist in the response
        images: Array.isArray(responseData.images) ? responseData.images : [],
        // Include user data if available
        user: responseData.user || {}
      };
      
      console.log('🔧 Formatted Data:', formattedData);
      
      // Validate required fields
      const requiredFields = ['id', 'name', 'price', 'location'];
      const missingFields = requiredFields.filter(field => !formattedData[field]);
      
      if (missingFields.length > 0) {
        throw new Error(`Missing required fields: ${missingFields.join(', ')}`);
      }
      
      try {
        // Create a new Project instance with the formatted data
        property.value = new Project(formattedData);
        console.log('🏠 Successfully created Project instance:', property.value);
        
        // Set the first image as current if available
        if (property.value.images && property.value.images.length > 0) {
          currentImage.value = getImageUrl(property.value.images[0]);
        }
        
        // Set the first image as current if available
        if (property.value.images && property.value.images.length > 0) {
          currentImage.value = property.value.images[0].url || '';
          imageLoaded.value = false;
          console.log('🖼️ Set current image:', currentImage.value);
        }
      } catch (modelError) {
        console.error('❌ Error creating Project instance:', modelError);
        throw new Error(`Failed to create property: ${modelError.message}`);
      }
      
    } catch (err) {
      console.error('❌ Error in fetchProperty:', {
        error: err,
        message: err.message,
        stack: err.stack
      });
      error.value = err.message || 'Failed to load property details. Please try again later.';
    } finally {
      isLoading.value = false;
    }
  };
  
  // Format price using the Project model's method
  const formattedPrice = computed(() => {
    return property.value?.formattedPrice || '';
  });
  
  // Format area using the Project model's method
  const formattedArea = computed(() => {
    return property.value?.formattedArea || '';
  });
  
  // Handle image loading
  const onImageLoad = () => {
    imageLoaded.value = true;
  };
  
  // Watch for route changes to load new property when ID changes
  watch(() => route.params.id, (newId) => {
    if (newId) {
      fetchProperty();
    }
  });
  
  // Handle form submission
  const submitInquiry = async () => {
    if (!inquiryForm.value.name || !inquiryForm.value.email || !inquiryForm.value.message) {
      formError.value = 'Please fill in all required fields';
      return;
    }
    
    try {
      formError.value = '';
      submissionSuccess.value = false;
      isSubmitting.value = true;
      
      // Prepare the request data
      const inquiryData = {
        name: inquiryForm.value.name,
        email: inquiryForm.value.email,
        message: inquiryForm.value.message,
        phone: inquiryForm.value.phone || '' // Include phone if provided
      };

      // Make API call to submit the inquiry
      const response = await axios.post(
        `/api/projects/${route.params.id}/inquiries`,
        inquiryData,
        {
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          }
        }
      );
      
      // Show success state
      submissionSuccess.value = true;
      
      // Reset the form
      inquiryForm.value = { name: '', email: '', phone: '', message: '' };
      
      // Hide success message after 5 seconds
      setTimeout(() => {
        submissionSuccess.value = false;
      }, 5000);
      
      return response.data;
      
    } catch (error) {
      console.error('Error sending inquiry:', error);
      formError.value = error.response?.data?.message || 'Failed to send inquiry. Please try again.';
      throw error;
    } finally {
      isSubmitting.value = false;
    }
  };
  
  // Schedule a visit
  const scheduleVisit = () => {
    alert('Schedule visit functionality will be implemented soon!');
  };
  
  // Fetch property data when component is mounted
  onMounted(() => {
    if (route.params.id) {
      fetchProperty();
    } else {
      error.value = 'No property ID provided';
      isLoading.value = false;
    }
  });
  </script>
  
  <style scoped>
  /* Custom styles if needed */
  </style>
  