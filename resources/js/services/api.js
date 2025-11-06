import axios from 'axios';
// Using direct values instead of config import to avoid path issues

// Create axios instance with base URL from config
// Use direct URL since we're having config import issues
const apiClient = axios.create({
  baseURL: 'http://sekna.soexplast.com',
  timeout: 30000, // 30 seconds
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  }
});

// Request interceptor
apiClient.interceptors.request.use(
  (config) => {
    // Add auth token to every request
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
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
  async (error) => {
    const originalRequest = error.config;
    
    // Handle 401 Unauthorized errors
    if (error.response?.status === 401 && !originalRequest._retry) {
      // If this is a login request, just reject it
      if (originalRequest.url.includes('/login') || originalRequest.url.includes('/refresh')) {
        return Promise.reject(error);
      }
      
      // Try to refresh the token
      originalRequest._retry = true;
      try {
        // You can implement token refresh logic here if needed
        // For now, we'll just redirect to login
        if (window.location.pathname !== '/login') {
          window.location.href = '/login';
        }
      } catch (refreshError) {
        console.error('Token refresh failed:', refreshError);
        if (window.location.pathname !== '/login') {
          window.location.href = '/login';
        }
      }
    }
    
    // Log other errors
    if (error.response) {
      console.error('API Error:', {
        status: error.response.status,
        data: error.response.data,
        url: error.config.url,
        method: error.config.method,
      });
      
      // Handle specific error cases
      if (error.response.status === 403) {
        console.error('Access forbidden - you may not have permission to access this resource');
      } else if (error.response.status === 404) {
        console.error('The requested resource was not found');
      } else if (error.response.status >= 500) {
        console.error('Server error - please try again later');
      }
    } else if (error.request) {
      console.error('No response received from server. Please check your connection.');
    } else {
      console.error('Request setup error:', error.message);
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
