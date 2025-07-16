<template>
    <div>
      <!-- Loading State -->
      <div v-if="isLoading" class="min-h-screen flex items-center justify-center">
        <div class="text-center">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600 mx-auto"></div>
          <p class="mt-4 text-gray-600">Chargement des détails du bien...</p>
        </div>
      </div>
  
      <!-- Error State -->
      <div v-else-if="error" class="min-h-screen flex items-center justify-center">
        <div class="text-center max-w-md p-6 bg-white rounded-lg shadow-md">
          <div class="text-red-500 text-5xl mb-4">⚠️</div>
          <h2 class="text-2xl font-bold text-gray-800 mb-2">Erreur lors du chargement du bien</h2>
          <p class="text-gray-600 mb-6">{{ error }}</p>
          <button 
            @click="fetchProperty"
            class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors"
          >
            Réessayer
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
              <span class="text-gray-400">Aucune image disponible</span>
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
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  <span class="line-clamp-1">{{ formatLocation(property.location) || 'Localisation non spécifiée' }}</span>
                </div>
              </div>
  
              <!-- Highlights -->
              <div class="py-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Détails du bien</h2>
                <div class="grid grid-cols-2 gap-4">
                  <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span class="text-gray-600">{{ property.housingType || 'Non spécifié' }}</span>
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
                    <span class="text-gray-600">Livraison : {{ property.deliveryDate || 'Non spécifiée' }}</span>
                  </div>
                  <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-gray-600">Publié le : {{ new Date(property.createdAt).toLocaleDateString('fr-FR') }}</span>
                  </div>
                </div>
              </div>
  
              <!-- Description -->
              <div class="py-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Description</h2>
                <p class="text-gray-600 whitespace-pre-line">{{ property.description || 'Aucune description disponible.' }}</p>
              </div>
            </div>
  
            <!-- Right Column - Contact Form -->
            <div class="mt-8 lg:mt-0">
              <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-purple-600 to-indigo-600 p-6 text-white">
                  <h3 class="text-xl font-semibold">Intéressé par ce bien ?</h3>
                  <p class="mt-1 text-purple-100">Contactez le vendeur pour plus d'informations</p>
                </div>
                <div class="p-4 sm:p-6">
                  <form @submit.prevent="submitInquiry" class="space-y-5 relative" :class="{ 'opacity-50': isSubmitting }">
                    <div v-if="isSubmitting" class="absolute inset-0 bg-white/80 backdrop-blur-sm flex items-center justify-center z-10 rounded-lg">
                      <div class="bg-white p-4 rounded-lg shadow-lg flex flex-col items-center">
                        <div class="animate-spin rounded-full h-10 w-10 border-t-2 border-b-2 border-purple-600"></div>
                        <p class="mt-2 text-sm text-gray-600">Envoi de votre message...</p>
                      </div>
                    </div>
                    
                    <!-- Grid Layout for Name, Email, and Phone -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                      <!-- Name Field -->
                      <div class="space-y-1">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nom complet <span class="text-red-500">*</span></label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                              <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                          </div>
                          <input 
                            type="text" 
                            id="name" 
                            v-model="inquiryForm.name"
                            :disabled="isSubmitting"
                            required
                            class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md py-3 border"
                            placeholder="Votre nom complet"
                          >
                        </div>
                      </div>
                      
                      <!-- Email Field -->
                      <div class="space-y-1">
                        <label for="email" class="block text-sm font-medium text-gray-700">E-mail <span class="text-red-500">*</span></label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                              <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                              <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                          </div>
                          <input 
                            type="email" 
                            id="email" 
                            v-model="inquiryForm.email"
                            required
                            class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md py-3 border"
                            placeholder="votre@email.com"
                          >
                        </div>
                      </div>
                      
                      <!-- Phone Field (full width on mobile, half on larger screens) -->
                      <div class="space-y-1 sm:col-span-2">
                        <label for="phone" class="block text-sm font-medium text-gray-700">Numéro de téléphone</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                          <div class="absolute inset-y-0 left-0 flex items-center">
                            <label for="country" class="sr-only">Pays</label>
                            <select id="country" name="country" class="focus:ring-purple-500 focus:border-purple-500 h-full py-0 pl-3 pr-7 border-transparent bg-transparent text-gray-500 sm:text-sm rounded-l-md">
                              <option>DZ +213</option>
                            </select>
                          </div>
                          <input 
                            type="tel" 
                            id="phone" 
                            v-model="inquiryForm.phone"
                            class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-24 sm:text-sm border-gray-300 rounded-md py-3 border"
                            :disabled="isSubmitting"
                            placeholder="06 12 34 56 78"
                          >
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Facultatif, mais recommandé pour une réponse plus rapide</p>
                      </div>
                    </div>
                    
                    <!-- Message Field (full width) -->
                    <div class="space-y-1">
                      <label for="message" class="block text-sm font-medium text-gray-700">Votre message <span class="text-red-500">*</span></label>
                      <div class="mt-1">
                        <textarea 
                          id="message" 
                          v-model="inquiryForm.message"
                          rows="4"
                          required
                          class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 rounded-md py-3 px-4 border"
                          :disabled="isSubmitting"
                          placeholder="Bonjour, je suis intéressé par ce bien. Pourriez-vous me fournir plus d'informations concernant..."
                        ></textarea>
                      </div>
                      <p class="mt-1 text-xs text-gray-500">Veuillez inclure toutes questions ou exigences particulières</p>
                    </div>
                    <!-- Form Actions -->
                    <div class="space-y-3 pt-2">
                      <button 
                        type="submit" 
                        :disabled="isSubmitting"
                        class="w-full flex justify-center items-center py-3 px-6 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 disabled:opacity-70 disabled:cursor-not-allowed transition-all duration-200 ease-in-out transform hover:-translate-y-0.5"
                      >
                        <span v-if="!isSubmitting" class="flex items-center">
                          <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                          </svg>
                          Envoyer le message
                        </span>
                        <span v-else class="flex items-center">
                          <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                          </svg>
                          Envoi en cours...
                        </span>
                      </button>
                      
                      <!-- Form Error Message -->
                      <div v-if="formError" class="mt-3 p-3 bg-red-50 border-l-4 border-red-500 rounded-r">
                        <div class="flex items-center">
                          <svg class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                          </svg>
                          <p class="text-sm font-medium text-red-700">{{ formError }}</p>
                        </div>
                      </div>
                      
                      <!-- Success Message -->
                      <div v-if="submissionSuccess" class="mt-3 p-3 bg-green-50 border-l-4 border-green-500 rounded-r">
                        <div class="flex items-start">
                          <svg class="h-5 w-5 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>
                          <div>
                            <p class="text-sm font-medium text-green-800">Message envoyé avec succès !</p>
                            <p class="text-xs text-green-600 mt-1">Nous avons bien reçu votre demande et vous répondrons dans les plus brefs délais.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                  
                  <!-- Contact Information -->
                  <div v-if="property?.user" class="mt-6 pt-4 border-t border-gray-100">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Coordonnées</h4>
                    <p class="text-sm font-medium text-gray-900">{{ property.user.name }}</p>
                    <p class="text-sm text-purple-600 mt-1">
                      <a :href="'mailto:' + property.user.email" class="hover:underline">{{ property.user.email }}</a>
                    </p>
                    <p v-if="property.user.phone" class="text-sm text-purple-600 mt-1">
                      <a :href="'tel:' + property.user.phone" class="hover:underline">{{ property.user.phone }}</a>
                    </p>
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
        throw new Error('Aucune réponse reçue du serveur');
      }
      
      // Handle case where response might be the data directly
      const responseData = response.data || response;
      
      if (!responseData) {
        throw new Error('Aucune donnée dans la réponse');
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
  
  // Format location object/string into readable text
  const formatLocation = (location) => {
    if (!location) return '';
    
    try {
      // If it's already a string, try to parse it as JSON
      const locationObj = typeof location === 'string' ? JSON.parse(location) : location;
      
      // Extract address components
      const parts = [
        locationObj.street,
        locationObj.baladia,
        locationObj.daira,
        locationObj.wilaya
      ].filter(Boolean); // Remove any empty/undefined parts
      
      return parts.join(', ');
    } catch (e) {
      // If parsing fails or it's not an object, return as is
      return typeof location === 'string' ? location : '';
    }
  };

  // Format price in DZD with proper formatting
  const formattedPrice = computed(() => {
    if (!property.value?.price) return 'N/A';
    const numericValue = Number(String(property.value.price).replace(/[^0-9,.-]+/g, "").replace(',', '.'));
    return `${numericValue.toLocaleString('ar-DZ')} DZD`;
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
  