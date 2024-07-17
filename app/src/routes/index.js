import { createRouter, createWebHistory } from 'vue-router';
import Login from '../pages/Login.vue';
import Home from '../pages/Home.vue';

const routes = [
    {
        path: '/home',
        name: 'Home',
        component: Home
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;