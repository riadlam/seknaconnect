import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import App from './App.vue';

// Import components
import HomePage from './views/HomePage.vue';

// Define routes
const routes = [
    { path: '/', component: HomePage },
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
