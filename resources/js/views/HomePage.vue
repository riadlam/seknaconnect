<template>
  <div class="py-12">
    <HeroSection />
    <FeaturedProperties :properties="properties" />
    <CallToAction />
  </div>
</template>

<script>
import HeroSection from './home/components/HeroSection.vue';
import FeaturedProperties from './home/components/FeaturedProperties.vue';
import CallToAction from './home/components/CallToAction.vue';

export default {
  name: 'HomePage',
  components: {
    HeroSection,
    FeaturedProperties,
    CallToAction
  },
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
/* Global styles for the home page can be added here */
</style>
