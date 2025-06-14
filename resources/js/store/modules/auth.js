import axios from 'axios';

const state = () => ({
  user: JSON.parse(localStorage.getItem('user')) || null,
  token: localStorage.getItem('token') || null,
  status: '',
  error: null
});

const getters = {
  isAuthenticated: state => !!state.token,
  authStatus: state => state.status,
  currentUser: state => state.user,
  authError: state => state.error,
  userInitial: state => {
    if (!state.user) return '';
    return state.user.name ? state.user.name.charAt(0).toUpperCase() : state.user.email.charAt(0).toUpperCase();
  }
};

const actions = {
  initialize({ commit }) {
    const token = localStorage.getItem('token') || sessionStorage.getItem('token');
    const user = JSON.parse(localStorage.getItem('user') || sessionStorage.getItem('user') || 'null');
    
    if (token && user) {
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
      commit('authSuccess', { user, token });
    }
  },
  
  async register({ commit }, userData) {
    commit('authRequest');
    try {
      console.log('Attempting registration with:', userData);
      
      const response = await axios.post('/api/register', {
        name: userData.name,
        email: userData.email,
        phone: userData.phone,
        password: userData.password,
        password_confirmation: userData.password_confirmation,
        role: userData.isSeller ? 'professional' : 'public'
      }, {
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        }
      });
      
      console.log('Registration response:', response.data);
      
      if (response.data && response.data.token) {
        const { user, token } = response.data;
        
        // Store token and user in localStorage by default
        localStorage.setItem('token', token);
        localStorage.setItem('user', JSON.stringify(user));
        
        // Set auth header
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        
        commit('authSuccess', { user, token });
        console.log('Registration successful, user:', user);
        return { success: true };
      } else {
        const errorMsg = response.data?.message || 'Invalid response from server';
        console.error('Registration failed:', errorMsg);
        commit('authError', errorMsg);
        return { success: false, error: errorMsg };
      }
    } catch (error) {
      let errorMessage = 'Registration failed. Please try again.';
      
      if (error.response) {
        // Handle validation errors
        if (error.response.data && error.response.data.errors) {
          const errors = Object.values(error.response.data.errors).flat();
          errorMessage = errors.join(' ');
        } else if (error.response.data && error.response.data.message) {
          errorMessage = error.response.data.message;
        } else if (error.response.status === 422) {
          errorMessage = 'Validation error. Please check your input.';
        } else if (error.response.status >= 500) {
          errorMessage = 'Server error. Please try again later.';
        }
      } else if (error.request) {
        errorMessage = 'No response from server. Please check your connection.';
      } else {
        errorMessage = error.message || 'An error occurred during registration';
      }
      
      console.error('Registration error:', error);
      commit('authError', errorMessage);
      return { success: false, error: errorMessage };
    }
  },

  async login({ commit, dispatch }, credentials) {
    commit('authRequest');
    try {
      console.log('Attempting login with:', credentials);
      const response = await axios.post('/api/login', {
        email: credentials.email,
        password: credentials.password
      }, {
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        }
      });
      
      console.log('Login response:', response.data);
      
      if (response.data && response.data.token) {
        const { user, token } = response.data;
        
        // Store token and user in localStorage
        if (credentials.remember) {
          localStorage.setItem('token', token);
          localStorage.setItem('user', JSON.stringify(user));
        } else {
          sessionStorage.setItem('token', token);
          sessionStorage.setItem('user', JSON.stringify(user));
        }
        
        // Set auth header
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        
        commit('authSuccess', { user, token });
        console.log('Login successful, user:', user);
        return true; // Return true for success
      } else {
        const errorMsg = response.data?.message || 'Invalid response from server';
        console.error('Login failed:', errorMsg);
        commit('authError', errorMsg);
        return false; // Return false for failure
      }
    } catch (error) {
      let errorMessage = 'Login failed. Please check your credentials.';
      
      if (error.response) {
        // The request was made and the server responded with a status code
        // that falls out of the range of 2xx
        if (error.response.data && error.response.data.message) {
          errorMessage = error.response.data.message;
        } else if (error.response.status === 422) {
          // Handle Laravel validation errors
          const errors = error.response.data.errors;
          errorMessage = Object.values(errors).flat().join(' ');
        } else if (error.response.status === 401) {
          errorMessage = 'Invalid email or password';
        } else if (error.response.status >= 500) {
          errorMessage = 'Server error. Please try again later.';
        }
      } else if (error.request) {
        // The request was made but no response was received
        errorMessage = 'No response from server. Please check your connection.';
      } else {
        // Something happened in setting up the request
        errorMessage = error.message || 'An error occurred during login';
      }
      
      commit('authError', errorMessage);
      return false; // Return false for failure
    }
  },

  logout({ commit }) {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    delete axios.defaults.headers.common['Authorization'];
    commit('logout');
  },

  clearError({ commit }) {
    commit('clearError');
  }
};

const mutations = {
  authRequest(state) {
    state.status = 'loading';
    state.error = null;
  },
  authSuccess(state, { user, token }) {
    state.status = 'success';
    state.user = user;
    state.token = token;
    state.error = null;
    
    // Ensure user data is properly set
    if (user) {
      state.user = {
        id: user.id,
        name: user.name,
        email: user.email,
        role: user.role || 'user',
        phone: user.phone,
        email_verified_at: user.email_verified_at
      };
    }
    
    console.log('Auth success - state updated:', state);
  },
  authError(state, error) {
    state.status = 'error';
    state.error = error;
    console.error('Auth error:', error);
  },
  logout(state) {
    state.status = '';
    state.user = null;
    state.token = null;
    state.error = null;
    
    // Clear all auth data from storage
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    sessionStorage.removeItem('token');
    sessionStorage.removeItem('user');
    
    // Remove auth header
    delete axios.defaults.headers.common['Authorization'];
    
    console.log('User logged out, state cleared');
  },
  clearError(state) {
    state.error = null;
  }
};

export default {
  namespaced: true,
  state: state(),
  getters,
  actions,
  mutations
};
