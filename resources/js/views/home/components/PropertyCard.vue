<template>
  <div class="group relative bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
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
</template>

<script>
export default {
  name: 'PropertyCard',
  props: {
    property: {
      type: Object,
      required: true
    }
  }
}
</script>
