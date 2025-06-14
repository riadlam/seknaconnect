<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-purple-700 to-indigo-800 text-white py-24">
      <div class="absolute inset-0 bg-black/30"></div>
      <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
          <h1 class="text-4xl md:text-5xl font-bold mb-6">About SeknaConnect</h1>
          <p class="text-xl text-purple-100 max-w-3xl mx-auto">
            Connecting you with your dream property through innovation, integrity, and exceptional service.
          </p>
        </div>
      </div>
    </div>

    <!-- Our Story Section -->
    <div class="py-16 bg-white">
      <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
          <div class="grid md:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
              <h2 class="text-3xl font-bold text-gray-900">Our Story</h2>
              <p class="text-gray-600 leading-relaxed">
                Founded in 2023, SeknaConnect was born from a simple idea: to transform the real estate experience by making it more transparent, efficient, and enjoyable for everyone involved.
              </p>
              <p class="text-gray-600 leading-relaxed">
                What started as a small team of passionate real estate professionals has grown into a trusted platform connecting thousands of buyers, sellers, and renters with their perfect properties.
              </p>
              <div class="bg-purple-50 p-6 rounded-xl border-l-4 border-purple-500">
                <p class="text-purple-800 font-medium italic">
                  "Our mission is to simplify property transactions and help people find not just a house, but a place to call home."
                </p>
              </div>
            </div>
            <div class="relative rounded-xl overflow-hidden shadow-xl">
              <img 
                src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                alt="Our team"
                class="w-full h-full object-cover aspect-video"
              >
              <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
              <div class="absolute bottom-0 left-0 p-6 text-white">
                <p class="text-sm font-medium">Our team at the annual real estate conference 2024</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Our Values -->
    <div class="py-16 bg-gradient-to-br from-purple-50 to-indigo-50">
      <div class="container mx-auto px-4">
        <div class="text-center mb-16">
          <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Core Values</h2>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            These principles guide everything we do at SeknaConnect
          </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
          <!-- Value 1 -->
          <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
            <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
              <svg class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">Integrity</h3>
            <p class="text-gray-600">
              We believe in complete transparency and honesty in all our dealings, ensuring you can trust us with your real estate journey.
            </p>
          </div>
          
          <!-- Value 2 -->
          <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
            <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
              <svg class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">Innovation</h3>
            <p class="text-gray-600">
              We leverage cutting-edge technology to simplify the property search and transaction process, saving you time and effort.
            </p>
          </div>
          
          <!-- Value 3 -->
          <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
            <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
              <svg class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">Community</h3>
            <p class="text-gray-600">
              We're committed to building strong relationships and giving back to the communities we serve, because home is where the heart is.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Team Section -->
    <div class="py-16 bg-white">
      <div class="container mx-auto px-4">
        <div class="text-center mb-16">
          <h2 class="text-3xl font-bold text-gray-900 mb-4">Meet Our Leadership</h2>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            The passionate individuals driving SeknaConnect forward
          </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
          <!-- Team Member 1 -->
          <div class="text-center">
            <div class="w-48 h-48 mx-auto mb-6 rounded-full overflow-hidden border-4 border-white shadow-xl">
              <img 
                src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=774&q=80" 
                alt="Sarah Johnson"
                class="w-full h-full object-cover"
              >
            </div>
            <h3 class="text-xl font-semibold text-gray-900">Sarah Johnson</h3>
            <p class="text-purple-600 font-medium mb-2">CEO & Founder</p>
            <p class="text-gray-600 text-sm max-w-xs mx-auto">
              With over 15 years in real estate, Sarah founded SeknaConnect to revolutionize the industry.
            </p>
          </div>
          
          <!-- Team Member 2 -->
          <div class="text-center">
            <div class="w-48 h-48 mx-auto mb-6 rounded-full overflow-hidden border-4 border-white shadow-xl">
              <img 
                src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=774&q=80" 
                alt="Michael Chen"
                class="w-full h-full object-cover"
              >
            </div>
            <h3 class="text-xl font-semibold text-gray-900">Michael Chen</h3>
            <p class="text-purple-600 font-medium mb-2">CTO</p>
            <p class="text-gray-600 text-sm max-w-xs mx-auto">
              Tech visionary with a passion for creating seamless digital experiences in real estate.
            </p>
          </div>
          
          <!-- Team Member 3 -->
          <div class="text-center">
            <div class="w-48 h-48 mx-auto mb-6 rounded-full overflow-hidden border-4 border-white shadow-xl">
              <img 
                src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                alt="Emily Rodriguez"
                class="w-full h-full object-cover"
              >
            </div>
            <h3 class="text-xl font-semibold text-gray-900">Emily Rodriguez</h3>
            <p class="text-purple-600 font-medium mb-2">Head of Customer Success</p>
            <p class="text-gray-600 text-sm max-w-xs mx-auto">
              Dedicated to ensuring every client has an exceptional experience with SeknaConnect.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-purple-600 to-indigo-700 text-white py-16">
      <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Ready to find your dream home?</h2>
        <p class="text-xl text-purple-100 mb-8 max-w-2xl mx-auto">
          Join thousands of satisfied clients who found their perfect property with SeknaConnect.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
          <router-link 
            to="/properties" 
            class="bg-white text-purple-700 hover:bg-purple-50 font-medium py-3 px-8 rounded-lg transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white"
          >
            Browse Properties
          </router-link>
          <router-link 
            to="/contact" 
            class="bg-transparent border-2 border-white text-white hover:bg-white/10 font-medium py-3 px-8 rounded-lg transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white"
          >
            Contact Us
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'About',
  setup() {
    return {
      // Component logic here
    };
  }
};
</script>

<style scoped>
/* Custom styles if needed */
</style>
