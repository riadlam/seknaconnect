import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import App from './App.vue';

// Import components
import HomePage from './views/HomePage.vue';
import Contact from './views/Contact.vue';
import About from './views/About.vue';
import Properties from './views/Properties.vue';
import Auth from './views/Auth.vue';

// Define routes
const routes = [
    { path: '/', component: HomePage },
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

// Create and mount the app
const app = createApp(App);
app.use(router);
app.mount('#app');
