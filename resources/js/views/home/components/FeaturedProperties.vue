<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="lg:text-center">
      <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
        Featured Properties
      </h2>
      <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
        Check out our latest and most popular properties on the market.
      </p>
    </div>

    <div class="mt-10">
      <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
        <PropertyCard 
          v-for="property in properties" 
          :key="property.id" 
          :property="property"
        />
      </div>
    </div>
  </div>
</template>

<script>
import PropertyCard from './PropertyCard.vue';

export default {
  name: 'FeaturedProperties',
  components: {
    PropertyCard
  },
  props: {
    properties: {
      type: Array,
      required: true
    }
  }
}
</script>
