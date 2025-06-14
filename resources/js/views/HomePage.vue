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
          featured: true,
          bedrooms: 5,
          bathrooms: 4.5,
          area: 350,
          listedDate: '2023-05-15',
          images: [
            'https://images.unsplash.com/photo-1613977257363-707ba9348227?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
            'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
            'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80'
          ]
        },
        {
          id: 2,
          title: 'Luxury Apartment in Downtown',
          location: 'New York, NY',
          price: 850000,
          featured: false,
          bedrooms: 3,
          bathrooms: 2,
          area: 180,
          listedDate: '2023-06-20',
          images: [
            'https://images.unsplash.com/photo-1613490493576-7fde63acd811?ixlib=rb-4.0.3&auto=format&fit=crop&w=1471&q=80',
            'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
            'https://images.unsplash.com/photo-1522709592188-3cfe41f51099?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80'
          ]
        },
        {
          id: 3,
          title: 'Beachfront Villa with Pool',
          location: 'Miami, Florida',
          price: 3200000,
          featured: true,
          bedrooms: 6,
          bathrooms: 5,
          area: 420,
          listedDate: '2023-04-10',
          images: [
            'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
          ]
        },
        {
          id: 4,
          title: 'Mountain View Cabin',
          location: 'Aspen, Colorado',
          price: 1950000,
          featured: false,
          bedrooms: 4,
          bathrooms: 3,
          area: 280,
          listedDate: '2023-07-05',
          images: [
            'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
            'https://images.unsplash.com/photo-1613490493576-7fde63acd811?ixlib=rb-4.0.3&auto=format&fit=crop&w=1471&q=80',
            'https://images.unsplash.com/photo-1613977257363-707ba9348227?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80'
          ]
        },
        {
          id: 5,
          title: 'Modern Loft in Arts District',
          location: 'Los Angeles, California',
          price: 1200000,
          featured: true,
          bedrooms: 2,
          bathrooms: 2,
          area: 160,
          listedDate: '2023-06-30',
          images: [
            'https://images.unsplash.com/photo-1613977257363-707ba9348227?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
            'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
            'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80'
          ]
        },
        {
          id: 6,
          title: 'Luxury Penthouse with City View',
          location: 'Chicago, Illinois',
          price: 1850000,
          featured: true,
          bedrooms: 3,
          bathrooms: 3.5,
          area: 240,
          listedDate: '2023-07-12',
          images: [
            'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1453&q=80',
          ]
        },
        {
          id: 7,
          title: 'Cozy Cottage by the Lake',
          location: 'Lake Tahoe, Nevada',
          price: 950000,
          featured: false,
          bedrooms: 3,
          bathrooms: 2,
          area: 180,
          listedDate: '2023-07-18',
          images: [
            'https://images.unsplash.com/photo-1600046050370-4bca97512646?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
            'https://images.unsplash.com/photo-1613490493576-7fde63acd811?ixlib=rb-4.0.3&auto=format&fit=crop&w=1471&q=80',
            'https://images.unsplash.com/photo-1613977257363-707ba9348227?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80'
          ]
        },
        {
          id: 8,
          title: 'Modern Farmhouse Retreat',
          location: 'Austin, Texas',
          price: 1750000,
          featured: true,
          bedrooms: 4,
          bathrooms: 3.5,
          area: 320,
          listedDate: '2023-07-05',
          images: [
            'https://images.unsplash.com/photo-1600585154526-990dced4cf0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80',
            'https://images.unsplash.com/photo-1600607686527-6fb886090705?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
            'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80'
          ]
        },
        {
          id: 9,
          title: 'Luxury Waterfront Mansion',
          location: 'Naples, Florida',
          price: 4850000,
          featured: true,
          bedrooms: 7,
          bathrooms: 6.5,
          area: 580,
          listedDate: '2023-06-25',
          images: [
            'https://images.unsplash.com/photo-1600585154526-990dced4cf0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80',
            'https://images.unsplash.com/photo-1600585154526-990dced4cf0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80',
            'https://images.unsplash.com/photo-1600607686527-6fb886090705?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80'
          ]
        },
        {
          id: 10,
          title: 'Charming Brownstone',
          location: 'Boston, Massachusetts',
          price: 2250000,
          featured: false,
          bedrooms: 3,
          bathrooms: 2.5,
          area: 260,
          listedDate: '2023-07-20',
          images: [
            'https://images.unsplash.com/photo-1600585154526-990dced4cf0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80',
            'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
            'https://images.unsplash.com/photo-1600607686527-6fb886090705?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80'
          ]
        }
      ]
    };
  }
};
</script>

<style scoped>
/* Global styles for the home page can be added here */
</style>
