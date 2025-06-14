import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import { createStore } from 'vuex';
import axios from 'axios';
import App from './App.vue';
import auth from './store/modules/auth';
import './bootstrap';
import HomePage from './views/HomePage.vue';
import Contact from './views/Contact.vue';
import About from './views/About.vue';
import Properties from './views/Properties.vue';
import Auth from './views/Auth.vue';

// Set base URL for API requests
axios.defaults.baseURL = 'http://192.168.1.8:8000';

// Add a request interceptor to include the token in all requests
axios.interceptors.request.use(
  config => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  error => {
    return Promise.reject(error);
  }
);

// Define routes
const routes = [
  { path: '/', component: HomePage, name: 'home' },
  { path: '/properties', component: Properties, name: 'properties' },
  { path: '/about', component: About, name: 'about' },
  { path: '/contact', component: Contact, name: 'contact' },
  { path: '/auth', component: Auth, name: 'auth' },
];

// Create router instance
const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Create store
const store = createStore({
  modules: {
    auth: auth
  },
  state: {},
  mutations: {},
  actions: {},
  getters: {}
});

// Initialize store
store.dispatch('auth/initialize');

// Create Vue application
const app = createApp(App);

// Use plugins
app.use(store);
app.use(router);

// Mount the app
app.mount('#app');
