import { createRouter, createWebHistory } from 'vue-router';
import Login from '../pages/Login.vue';
import Register from '../pages/Register.vue';
import Vacancies from '../pages/Vacancies.vue';
import CreateVacancy from '../pages/CreateVacancy.vue';
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
    },
    {
        path: '/register',
        name: 'Register',
        component: Register
    },
    {
        path: '/vacancies',
        name: 'Vacancies',
        component: Vacancies
    },
    {
        path: '/create_vacancy',
        name: 'CreateVacancy',
        component: CreateVacancy
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;