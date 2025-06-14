<template>
  <section class="relative w-full h-[80vh] min-h-[600px] overflow-hidden">
    <!-- Background Slideshow -->
    <div class="absolute inset-0 z-0">
      <div v-for="(slide, index) in slides" :key="index" 
           :class="['absolute inset-0 transition-opacity duration-1000', currentSlide === index ? 'opacity-100' : 'opacity-0 pointer-events-none']">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-900/80 to-purple-700/60"></div>
        <img :src="slide.image" :alt="slide.alt" class="w-full h-full object-cover object-center transform scale-105">
      </div>
    </div>

    <!-- Content -->
    <div class="relative z-10 h-full flex items-center">
      <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl">
          <!-- Animated Badge -->
          <div class="inline-block mb-6">
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-purple-100 text-purple-800 animate-pulse">
              <span class="flex h-2 w-2 rounded-full bg-purple-600 mr-2"></span>
              {{ slides[currentSlide].tag }}
            </span>
          </div>

          <!-- Main Heading with Animation -->
          <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold text-white leading-tight mb-6 animate-fadeInUp">
            {{ slides[currentSlide].heading }}
          </h1>
          
          <!-- Description -->
          <p class="text-lg sm:text-xl text-purple-100 mb-8 max-w-lg animate-fadeInUp animation-delay-100">
            {{ slides[currentSlide].description }}
          </p>

          <!-- CTA Buttons -->
          <div class="flex flex-col sm:flex-row gap-4 animate-fadeInUp animation-delay-200">
            <a href="#featured-properties" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-medium rounded-full text-white bg-purple-600 hover:bg-purple-700 transition-colors duration-300 transform hover:scale-105">
              Explore Properties
              <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
              </svg>
            </a>
            <a href="#contact" class="inline-flex items-center justify-center px-8 py-4 border-2 border-white/30 text-base font-medium rounded-full text-white hover:bg-white/10 transition-colors duration-300">
              Contact Agent
              <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
              </svg>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Slide Indicators -->
    <div class="absolute bottom-8 left-0 right-0 z-10">
      <div class="flex justify-center space-x-2">
        <button v-for="(_, index) in slides" :key="`indicator-${index}`"
                @click="goToSlide(index)"
                :class="['w-3 h-3 rounded-full transition-all duration-300', currentSlide === index ? 'bg-white w-8' : 'bg-white/50 hover:bg-white/80 w-3']"
                :aria-label="`Go to slide ${index + 1}`">
        </button>
      </div>
    </div>

    <!-- Scroll Down Indicator -->
    <div class="absolute bottom-8 right-8 z-10 hidden md:block">
      <a href="#featured-properties" class="flex flex-col items-center text-white/70 hover:text-white transition-colors group">
        <span class="text-sm mb-2">Scroll Down</span>
        <div class="w-6 h-10 border-2 border-white/50 rounded-full flex justify-center p-1 group-hover:border-white transition-colors">
          <div class="w-1 h-2 bg-white rounded-full animate-bounce"></div>
        </div>
      </a>
    </div>
  </section>
</template>

<script>
export default {
  name: 'HeroSection',
  data() {
    return {
      currentSlide: 0,
      slides: [
        {
          image: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80',
          alt: 'Luxury Modern House',
          tag: 'Luxury Living',
          heading: 'Discover Your Dream Home',
          description: 'Find the perfect property that matches your lifestyle and budget from our exclusive collection.'
        },
        {
          image: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80',
          alt: 'Modern Apartment Interior',
          tag: 'Modern Design',
          heading: 'Contemporary Living Spaces',
          description: 'Experience the perfect blend of comfort and modern architecture in our premium properties.'
        },
        {
          image: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80',
          alt: 'Luxury Villa with Pool',
          tag: 'Premium Collection',
          heading: 'Luxury Redefined',
          description: 'Indulge in our exclusive collection of luxury homes with premium amenities and stunning views.'
        }
      ]
    }
  },
  mounted() {
    this.startSlider();
  },
  beforeUnmount() {
    if (this.sliderInterval) {
      clearInterval(this.sliderInterval);
    }
  },
  methods: {
    startSlider() {
      this.sliderInterval = setInterval(() => {
        this.nextSlide();
      }, 5000);
    },
    nextSlide() {
      this.currentSlide = (this.currentSlide + 1) % this.slides.length;
    },
    goToSlide(index) {
      if (this.sliderInterval) {
        clearInterval(this.sliderInterval);
      }
      this.currentSlide = index;
      this.startSlider();
    }
  }
}
</script>

<style scoped>
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fadeInUp {
  animation: fadeInUp 0.8s ease-out forwards;
  opacity: 0;
}

.animation-delay-100 {
  animation-delay: 0.2s;
}

.animation-delay-200 {
  animation-delay: 0.4s;
}

/* Smooth transitions for the slider */
.slide-enter-active, .slide-leave-active {
  transition: opacity 1s ease-in-out;
}
.slide-enter-from, .slide-leave-to {
  opacity: 0;
}

/* Ensure the section takes full width */
section {
  width: 100%;
  display: block;
}

/* Make sure images cover the area properly */
img {
  min-width: 100%;
  min-height: 100%;
  object-fit: cover;
}
</style>
