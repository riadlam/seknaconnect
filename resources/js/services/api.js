import axios from 'axios';
// Using direct values instead of config import to avoid path issues

// Create axios instance with base URL from config
// Use direct URL since we're having config import issues
const apiClient = axios.create({
  baseURL: 'http://192.168.1.8:8000',
  timeout: 30000, // 30 seconds
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  }
});

// Request interceptor
apiClient.interceptors.request.use(
  (config) => {
    // You can add auth token here if needed
    // const token = localStorage.getItem('token');
    // if (token) {
    //   config.headers.Authorization = `Bearer ${token}`;
    // }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Response interceptor
apiClient.interceptors.response.use(
  (response) => {
    // Handle successful responses
    return response.data;
  },
  (error) => {
    // Handle errors
    if (error.response) {
      // The request was made and the server responded with a status code
      // that falls out of the range of 2xx
      console.error('API Error:', {
        status: error.response.status,
        data: error.response.data,
        headers: error.response.headers,
      });
    } else if (error.request) {
      // The request was made but no response was received
      console.error('API Error: No response received', error.request);
    } else {
      // Something happened in setting up the request that triggered an Error
      console.error('API Error:', error.message);
    }
    
    return Promise.reject(error);
  }
);

const api = {
  // Projects
  getProjects: async (page = 1, perPage = 12) => {
    try {
      const response = await apiClient.get('/api/projects', {
        params: { 
          page, 
          per_page: perPage,
          // Add any additional query parameters your API might need
        }
      });
      
      console.log('📡 API Response:', response);
      
      // Return the data in a consistent format
      return {
        data: response.data.data || response.data, // Handle both paginated and direct array responses
        meta: response.data.meta || {}
      };
    } catch (error) {
      console.error('Error fetching projects:', error);
      // Return a consistent error response
      return {
        data: [],
        error: error.response?.data?.message || 'Failed to fetch projects',
        status: error.response?.status
      };
    }
  },
  
  getFeaturedProjects() {
    return apiClient.get('/api/projects?featured=1');
  },
  
  getProject(id) {
    return apiClient.get(`/api/projects/${id}`);
  },
  
  // Search projects
  searchProjects(query, filters = {}, page = 1, perPage = 12) {
    return apiClient.get('/api/projects', {
      params: {
        search: query,
        page,
        per_page: perPage,
        ...filters
      }
    });
  }
};

export default api;
