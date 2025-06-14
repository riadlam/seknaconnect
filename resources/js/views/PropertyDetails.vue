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
              @click="currentImage = img"
              class="flex-shrink-0 w-16 h-16 rounded-md overflow-hidden border-2 transition-all duration-200"
              :class="{
                'border-purple-600 ring-2 ring-purple-400': currentImage === img,
                'border-transparent hover:border-gray-300': currentImage !== img
              }"
            >
              <img :src="img" class="w-full h-full object-cover" :alt="'Property image ' + (index + 1)">
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
                <h1 class="text-3xl font-bold text-gray-900">{{ property.title }}</h1>
                <div class="mt-2 flex items-center">
                  <span class="text-2xl font-semibold text-purple-700">{{ formattedPrice }}</span>
                  <span v-if="property.pricePer" class="ml-2 text-gray-500">/ {{ property.pricePer }}</span>
                </div>
                <div class="mt-3 flex items-center text-sm text-gray-500">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  <span>{{ property.address }}</span>
                </div>
              </div>
  
              <!-- Highlights -->
              <div class="py-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Property Highlights</h2>
                <div class="grid grid-cols-2 gap-4">
                  <div v-for="(feature, index) in property.highlights" :key="index" class="flex items-center">
                    <div class="flex-shrink-0 h-6 w-6 text-purple-600">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                      </svg>
                    </div>
                    <span class="ml-2 text-gray-700">{{ feature }}</span>
                  </div>
                </div>
              </div>
  
              <!-- Description -->
              <div class="py-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Description</h2>
                <p class="text-gray-700 leading-relaxed">{{ property.description }}</p>
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
                
                <form @submit.prevent="submitInquiry" class="p-6">
                  <div class="space-y-4">
                    <div>
                      <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                      <input 
                        type="text" 
                        id="name" 
                        v-model="inquiry.name"
                        required 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                        placeholder="Your name"
                      >
                    </div>
                    
                    <div>
                      <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                      <input 
                        type="email" 
                        id="email" 
                        v-model="inquiry.email"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                        placeholder="your@email.com"
                      >
                    </div>
                    
                    <div>
                      <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                      <input 
                        type="tel" 
                        id="phone" 
                        v-model="inquiry.phone"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                        placeholder="+212 6XX-XXXXXX"
                      >
                    </div>
                    
                    <div>
                      <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                      <textarea 
                        id="message" 
                        v-model="inquiry.message"
                        rows="4"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                        placeholder="I'm interested in this property. Please provide more details."
                      ></textarea>
                    </div>
                    
                    <button 
                      type="submit" 
                      :disabled="isSubmitting"
                      class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 disabled:opacity-70 disabled:cursor-not-allowed transition-all duration-200"
                    >
                      <span v-if="!isSubmitting">Send Message</span>
                      <span v-else>Sending...</span>
                    </button>
                  </div>
                </form>
                
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                  <div class="flex items-center">
                    <div class="flex-shrink-0">
                      <img 
                        class="h-10 w-10 rounded-full" 
                        :src="property.agent.avatar || 'https://ui-avatars.com/api/?name=' + property.agent.name" 
                        :alt="property.agent.name"
                      >
                    </div>
                    <div class="ml-4">
                      <p class="text-sm font-medium text-gray-900">{{ property.agent.name }}</p>
                      <p class="text-sm text-purple-600">
                        <a :href="'tel:' + property.agent.phone" class="hover:underline">{{ property.agent.phone }}</a>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Schedule a Visit -->
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
  import { ref, onMounted, computed } from 'vue';
  import { useRoute, useRouter } from 'vue-router';
  import axios from 'axios';
  
  const route = useRoute();
  const router = useRouter();
  
  // State
  const currentImage = ref('');
  const imageLoaded = ref(false);
  const isLoading = ref(true);
  const isSubmitting = ref(false);
  const property = ref(null);
  const error = ref(null);
  
  // Form data
  const inquiry = ref({
    name: '',
    email: '',
    phone: '',
    message: ''
  });
  
  // Fetch property data
  const fetchProperty = async () => {
    try {
      isLoading.value = true;
      error.value = null;
      // Simulate API call - replace with actual API endpoint
      await new Promise(resolve => setTimeout(resolve, 800));
      
      // Mock data - replace with actual API response
      property.value = {
        id: route.params.id,
        title: 'Modern Apartment with Stunning View',
        price: 2500000,
        pricePer: 'month',
        address: '123 Palm Street, Casablanca',
        description: 'Beautiful modern apartment located in the heart of the city. Features 3 bedrooms, 2 bathrooms, and a spacious living area with floor-to-ceiling windows offering breathtaking views of the city skyline. The apartment comes with high-end finishes, modern appliances, and access to building amenities including a swimming pool, gym, and 24/7 security.',
        bedrooms: 3,
        bathrooms: 2,
        area: 1800,
        yearBuilt: 2020,
        highlights: [
          '3 Bedrooms',
          '2 Bathrooms',
          '1800 sq. ft.',
          '2 Parking Spots',
          'Balcony',
          'Fully Furnished'
        ],
        images: [
          'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80',
          'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80',
          'https://images.unsplash.com/photo-1493809842364-78817add7ffb?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80',
          'https://images.unsplash.com/photo-1502672260266-37eb8b0e4a26?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80'
        ],
        features: [
          'Air Conditioning',
          'Heating',
          'Elevator',
          'Dishwasher',
          'Washer/Dryer',
          'Gym',
          'Swimming Pool',
          '24/7 Security',
          'Parking',
          'Balcony',
          'Furnished',
          'Pet Friendly'
        ],
        agent: {
          name: 'Ahmed Benali',
          phone: '+212 6XX-XXXXXX',
          email: 'ahmed@example.com',
          avatar: 'https://randomuser.me/api/portraits/men/1.jpg',
          company: 'Luxury Estates',
          experience: '10+ years',
          propertiesSold: 245
        }
      };
      
      currentImage.value = property.value.images?.[0] || '';
    } catch (err) {
      console.error('Error fetching property:', err);
      error.value = 'Failed to load property details. Please try again later.';
    } finally {
      isLoading.value = false;
    }
  };
  
  // Format price
  const formattedPrice = computed(() => {
    if (!property.value) return '';
    return new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'MAD',
      maximumFractionDigits: 0
    }).format(property.value.price);
  });
  
  // Handle image loading
  const onImageLoad = () => {
    imageLoaded.value = true;
  };
  
  // Handle form submission
  const submitInquiry = async () => {
    if (!inquiry.value.name || !inquiry.value.email || !inquiry.value.message) {
      alert('Please fill in all required fields');
      return;
    }
    
    try {
      isSubmitting.value = true;
      // Simulate API call - replace with actual API endpoint
      await new Promise(resolve => setTimeout(resolve, 1000));
      
      // In a real app, you would make an API call like this:
      // await axios.post(`/api/properties/${route.params.id}/inquiry`, inquiry.value);
      
      alert('Your inquiry has been sent successfully!');
      inquiry.value = { name: '', email: '', phone: '', message: '' };
    } catch (error) {
      console.error('Error sending inquiry:', error);
      alert('Failed to send inquiry. Please try again.');
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
    fetchProperty();
  });
  </script>
  
  <style scoped>
  /* Custom styles if needed */
  </style>
  