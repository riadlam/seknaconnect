<template>
  <div class="py-12">
    <!-- Hero Section -->
    <div class="bg-indigo-700">
      <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
          Find Your Dream Home
        </h1>
        <p class="mt-6 text-xl text-indigo-100 max-w-3xl mx-auto">
          Discover the perfect property that matches your lifestyle and budget.
        </p>
        <div class="mt-8 flex justify-center">
          <div class="inline-flex rounded-md shadow">
            <a href="#" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50">
              Browse Properties
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Featured Properties -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="lg:text-center">
        <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
          Featured Properties
        </h2>
        <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
          Check out our latest and most popular properties on the market.
        </p>
      </div>

      <!-- Property Grid -->
      <div class="mt-10">
        <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
          <div v-for="property in properties" :key="property.id" class="group relative bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
            <div class="relative h-64 w-full overflow-hidden">
              <img :src="property.imageUrl" :alt="property.title" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-300">
              <div class="absolute top-4 right-4 bg-indigo-600 text-white text-xs font-semibold px-3 py-1 rounded-full">
                {{ property.type }}
              </div>
            </div>
            <div class="p-6">
              <div class="flex justify-between items-start">
                <div>
                  <h3 class="text-lg font-semibold text-gray-900">
                    {{ property.title }}
                  </h3>
                  <p class="mt-1 text-sm text-gray-500">
                    {{ property.location }}
                  </p>
                </div>
                <p class="text-lg font-semibold text-indigo-600">
                  ${{ property.price.toLocaleString() }}
                </p>
              </div>
              <div class="mt-4 flex items-center justify-between">
                <div class="flex space-x-4">
                  <span class="flex items-center text-sm text-gray-500">
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0116 8H4a5 5 0 014.5 2.92A6.97 6.97 0 009 16c0 .34.024.673.07 1h3.86z" />
                    </svg>
                    {{ property.bedrooms }}
                  </span>
                  <span class="flex items-center text-sm text-gray-500">
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H5a1 1 0 01-1-1V4z" clip-rule="evenodd" />
                    </svg>
                    {{ property.bathrooms }}
                  </span>
                  <span class="flex items-center text-sm text-gray-500">
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 2a1 1 0 011-1h2a1 1 0 011 1v1a1 1 0 01-1 1H7a1 1 0 01-1-1V6zm5 0a1 1 0 00-1 1v1a1 1 0 001 1h4a1 1 0 001-1V6a1 1 0 00-1-1h-4z" clip-rule="evenodd" />
                    </svg>
                    {{ property.area }} m²
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-indigo-50">
      <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
        <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
          <span class="block">Ready to find your dream home?</span>
          <span class="block text-indigo-600">Start your property search today.</span>
        </h2>
        <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
          <div class="inline-flex rounded-md shadow">
            <a href="#" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
              Get started
            </a>
          </div>
          <div class="ml-3 inline-flex rounded-md shadow">
            <a href="#" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50">
              Learn more
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'HomePage',
  data() {
    return {
      properties: [
        {
          id: 1,
          title: 'Modern Villa with Ocean View',
          location: 'Malibu, California',
          price: 2500000,
          type: 'For Sale',
          bedrooms: 5,
          bathrooms: 4.5,
          area: 350,
          imageUrl: 'https://images.unsplash.com/photo-1613977257363-707ba9348227?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80'
        },
        {
          id: 2,
          title: 'Luxury Apartment in Downtown',
          location: 'New York, NY',
          price: 850000,
          type: 'For Sale',
          bedrooms: 3,
          bathrooms: 2,
          area: 180,
          imageUrl: 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80'
        },
        {
          id: 3,
          title: 'Beachfront Villa with Pool',
          location: 'Miami, Florida',
          price: 3200000,
          type: 'For Sale',
          bedrooms: 6,
          bathrooms: 5,
          area: 420,
          imageUrl: 'https://images.unsplash.com/photo-1613977257365-aaae40286aec?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80'
        },
        {
          id: 4,
          title: 'Mountain View Cabin',
          location: 'Aspen, Colorado',
          price: 1950000,
          type: 'For Sale',
          bedrooms: 4,
          bathrooms: 3,
          area: 280,
          imageUrl: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80'
        },
        {
          id: 5,
          title: 'Modern Loft in Arts District',
          location: 'Los Angeles, California',
          price: 1200000,
          type: 'For Sale',
          bedrooms: 2,
          bathrooms: 2,
          area: 160,
          imageUrl: 'https://images.unsplash.com/photo-1600210492493-832627500a66?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1374&q=80'
        },
        {
          id: 6,
          title: 'Lakeside Cottage',
          location: 'Lake Tahoe, Nevada',
          price: 2750000,
          type: 'For Sale',
          bedrooms: 5,
          bathrooms: 4,
          area: 320,
          imageUrl: 'https://images.unsplash.com/photo-1600046050370-4bca97512646?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80'
        }
      ]
    };
  }
};
</script>

<style scoped>
/* Custom styles can be added here */
</style>
