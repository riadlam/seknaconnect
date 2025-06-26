<template>
  <div
    class="group relative bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 h-full w-full flex flex-col cursor-pointer"
    @click="viewPropertyDetails"
  >
    <!-- Image Gallery -->
    <div class="relative w-full aspect-[4/3] overflow-hidden">
      <!-- Main Image -->
      <div class="relative w-full h-full">
        <img
          :src="property.image"
          :alt="property.alt || 'Property image'"
          class="w-full h-full object-cover object-center transition-transform duration-700 ease-in-out"
          :class="{ 'scale-105': isHovered }"
          @mouseenter="isHovered = true"
          @mouseleave="isHovered = false"
          @error="handleImageError"
        />
        
        <!-- Navigation Dots -->
        <div v-if="property.images?.length > 1" class="absolute bottom-4 left-0 right-0 flex justify-center gap-1 sm:gap-2">
          <button
            v-for="(img, index) in property.images"
            :key="index"
            @click="currentImageIndex = index"
            class="h-2 rounded-full transition-all duration-300 focus:outline-none"
            :class="currentImageIndex === index ? 'w-5 bg-white' : 'w-2 bg-white/50'"
            :aria-label="`View image ${index + 1}`"
          ></button>
        </div>

        <!-- Arrows -->
        <button
          v-if="property.images?.length > 1"
          @click.stop="prevImage"
          class="absolute left-2 sm:left-3 top-1/2 -translate-y-1/2 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-black/30 hover:bg-black/50 flex items-center justify-center text-white transition-opacity opacity-0 group-hover:opacity-100 focus:opacity-100"
          aria-label="Previous image"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>
        <button
          v-if="property.images?.length > 1"
          @click.stop="nextImage"
          class="absolute right-2 sm:right-3 top-1/2 -translate-y-1/2 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-black/30 hover:bg-black/50 flex items-center justify-center text-white transition-opacity opacity-0 group-hover:opacity-100 focus:opacity-100"
          aria-label="Next image"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>

        <!-- Badges -->
        <div class="absolute top-3 sm:top-4 left-3 sm:left-4 flex flex-col gap-1">
          
          <span v-if="property.featured" class="inline-flex items-center px-2.5 py-0.5 text-xs sm:text-sm font-semibold bg-amber-400 text-amber-900 rounded-full shadow">
            Featured
          </span>
        </div>
      </div>
    </div>

    <!-- Details -->
    <div class="p-4 sm:p-6 flex-1 flex flex-col min-h-[200px]">
      <div class="flex justify-between items-start flex-wrap gap-2">
        <div>
          <h3 class="text-lg sm:text-xl font-semibold text-gray-900 group-hover:text-purple-700 transition-colors line-clamp-1">
            {{ property.title }}
          </h3>
          <p class="text-sm text-gray-500 mt-1">
            {{ property.type }}
          </p>
          <div class="flex items-center text-sm mt-1 text-gray-600 flex-wrap gap-1">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="ml-1">{{ property.location }}</span>
          </div>
        </div>
        <div class="text-right">
          <p class="text-xl sm:text-2xl font-bold text-purple-700">
            {{ property.price }}
          </p>
          <p v-if="property.originalPrice" class="text-sm text-gray-400 line-through">
            ${{ property.originalPrice.toLocaleString() }}
          </p>
        </div>
      </div>

      <!-- Features -->
      <div class="mt-4 border-t pt-4 grid grid-cols-3 gap-2 text-center text-xs sm:text-sm">
        <div class="flex flex-col items-center gap-1 hover:bg-gray-50 p-2 rounded-lg">
          <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
          </svg>
          <span>{{ property.bedrooms || 'N/A' }} Beds</span>
        </div>
        <div class="flex flex-col items-center gap-1 hover:bg-gray-50 p-2 rounded-lg">
          <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          <span>{{ property.bathrooms || 'N/A' }} Baths</span>
        </div>
        <div class="flex flex-col items-center gap-1 hover:bg-gray-50 p-2 rounded-lg">
          <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h.5A2.5 2.5 0 0022 5.5v-1.6a1 1 0 00-.293-.707l-1.4-1.4A1 1 0 0019.4 2H4.6a1 1 0 00-.707.293l-1.4 1.4A1 1 0 002 4.6V18a2 2 0 002 2h3m8-12h.01M3 21h18m-7-6h.01" />
          </svg>
          <span>{{ property.area || 'N/A' }}</span>
        </div>
      </div>

      <!-- CTA -->
      <div class="mt-4">
        <button class="w-full py-2.5 px-4 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center">
          <span>View Details</span>
          <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
          </svg>
        </button>
      </div>
    </div>

    <!-- Tag -->
    <div v-if="property.tag" class="absolute top-3 right-3 rotate-12">
      <span class="inline-flex items-center px-3 py-1 text-xs font-semibold bg-white text-purple-700 rounded-full shadow-md">
        {{ property.tag }}
      </span>
    </div>
  </div>
</template>


<script>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';

export default {
  name: 'PropertyCard',
  props: {
    property: {
      type: Object,
      required: true,
      default: () => ({
        id: null,
        title: 'No Title',
        location: 'Location not specified',
        price: 'Price on request',
        image: 'https://via.placeholder.com/600x400?text=No+Image',
        alt: 'Property image',
        area: 'N/A',
        type: 'Property',
        bedrooms: 0,
        bathrooms: 0,
        featured: false,
        isNew: false
      })
    }
  },
  setup(props) {
    const router = useRouter();
    const isHovered = ref(false);
    const currentImageIndex = ref(0);
    const showShareOptions = ref(false);
    const isFavorite = ref(false);

    const viewPropertyDetails = () => {
      if (props.property.id) {
        router.push({ name: 'property-details', params: { id: props.property.id } });
      }
    };
    
    const handleImageError = (e) => {
      // If image fails to load, show a placeholder
      e.target.src = 'https://via.placeholder.com/600x400?text=Image+Not+Available';
    };
    
    const toggleFavorite = (e) => {
      e.stopPropagation();
      isFavorite.value = !isFavorite.value;
      // Here you would typically make an API call to update the favorite status
    };
    
    // Auto-rotate images if there are multiple
    let rotationInterval;
    
    onMounted(() => {
      if (props.property.images?.length > 1) {
        rotationInterval = setInterval(() => {
          if (isHovered.value) return; // Pause on hover
          nextImage();
        }, 5000);
      }
      
      return () => {
        if (rotationInterval) clearInterval(rotationInterval);
      };
    });
    
    return {
      isHovered,
      showShareOptions,
      isFavorite,
      viewPropertyDetails,
      handleImageError,
      toggleFavorite
    };
  }
}
</script>

<style scoped>
/* Custom scrollbar for the image gallery */
.image-gallery {
  scrollbar-width: thin;
  scrollbar-color: #8b5cf6 #e9d5ff;
}

.image-gallery::-webkit-scrollbar {
  height: 6px;
}

.image-gallery::-webkit-scrollbar-track {
  background: #e9d5ff;
  border-radius: 3px;
}

.image-gallery::-webkit-scrollbar-thumb {
  background-color: #8b5cf6;
  border-radius: 3px;
}

/* Smooth transitions for the image gallery */
.gallery-enter-active,
.gallery-leave-active {
  transition: all 0.5s ease;
}

.gallery-enter-from,
.gallery-leave-to {
  opacity: 0;
  transform: scale(0.95);
}

/* Card hover effect */
.card-hover {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-hover:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}
</style>
