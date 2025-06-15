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
import PropertyDetails from './views/PropertyDetails.vue';
import Auth from './views/Auth.vue';
import AdminLayout from './layouts/AdminLayout.vue';
import ProfessionalDashboard from './views/admin/admin_professionel/ProfessionalDashboard.vue';
import ProjectsList from './views/admin/admin_professionel/ProjectsList.vue';

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
  { 
    path: '/', 
    component: HomePage, 
    name: 'home' 
  },
  { 
    path: '/properties', 
    component: Properties, 
    name: 'properties' 
  },
  { 
    path: '/properties/:id', 
    component: PropertyDetails, 
    name: 'property-details', 
    props: true 
  },
  { 
    path: '/about', 
    component: About, 
    name: 'about' 
  },
  { 
    path: '/contact', 
    component: Contact, 
    name: 'contact' 
  },
  { 
    path: '/auth', 
    component: Auth, 
    name: 'auth' 
  },
  {
    path: '/admin',
    component: AdminLayout,
    meta: { requiresAuth: true },
    redirect: '/admin/dashboard',
    children: [
      { 
        path: '', 
        redirect: 'dashboard' 
      },
      { 
        path: 'dashboard', 
        component: ProfessionalDashboard, 
        name: 'admin.dashboard',
        meta: { title: 'Dashboard' }
      },
      { 
        path: 'projects', 
        component: ProjectsList, 
        name: 'admin.projects',
        meta: { title: 'Projects' }
      },
      { 
        path: 'projects/new', 
        component: ProjectsList, // TODO: Create ProjectForm component
        name: 'admin.projects.create',
        meta: { title: 'New Project' }
      },
      { 
        path: 'projects/:id', 
        component: ProjectsList, // TODO: Create ProjectDetails component
        name: 'admin.projects.show',
        props: true,
      },
      {
        path: 'clients',
        component: ProfessionalDashboard, // TODO: Create ClientsList component
        name: 'admin.clients',
        meta: { title: 'Clients' }
      },
      {
        path: 'properties',
        component: ProfessionalDashboard, // TODO: Create PropertiesList component
        name: 'admin.properties',
        meta: { title: 'Properties' }
      },
      {
        path: 'documents',
        component: ProfessionalDashboard, // TODO: Create DocumentsList component
        name: 'admin.documents',
        meta: { title: 'Documents' }
      },
      {
        path: 'settings',
        component: ProfessionalDashboard, // TODO: Create Settings component
        name: 'admin.settings',
        meta: { title: 'Settings' }
      },
      { 
        path: 'projects/:id/edit', 
        component: ProjectsList, // TODO: Create ProjectForm component
        name: 'admin.projects.edit',
        props: true,
        meta: { title: 'Edit Project' }
      }
    ]
  }
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

// Navigation guard
router.beforeEach((to, from, next) => {
  const isAuthenticated = store.getters['auth/isAuthenticated'];
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
  
  if (requiresAuth && !isAuthenticated) {
    next({ name: 'auth', query: { redirect: to.fullPath } });
  } else {
    // Set page title if available
    if (to.meta.title) {
      document.title = `${to.meta.title} | SeknaConnect Admin`;
    }
    next();
  }
});

// Create Vue application
const app = createApp(App);

// Use plugins
app.use(store);
app.use(router);

// Mount the app
app.mount('#app');
