export default {
  // API Configuration
  api: {
    baseURL: 'https://sekna.soexplast.com/api',
    timeout: 10000, // 10 seconds
    endpoints: {
      projects: '/projects',
      featuredProjects: '/projects?featured=1',
      projectDetails: (id) => `/projects/${id}`,
    },
  },
  
  // Default image paths
  images: {
    placeholder: 'https://via.placeholder.com/600x400?text=No+Image',
    error: 'https://via.placeholder.com/600x400?text=Image+Not+Available',
  },
  
  // Pagination
  pagination: {
    itemsPerPage: 12,
  },
  
  // Default property filters
  propertyFilters: [
    { id: 'all', label: 'All Properties' },
    { id: 'villa', label: 'Villas' },
    { id: 'apartment', label: 'Apartments' },
    { id: 'house', label: 'Houses' },
    { id: 'land', label: 'Land' },
  ],
};

// Helper function to get full image URL
export const getImageUrl = (path) => {
  if (!path) return '';
  if (path.startsWith('http')) return path;
  return `https://sekna.soexplast.com${path}`;
};
