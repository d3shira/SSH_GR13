

import {createRouter, createWebHistory} from 'vue-router';
import Register from './views/Register.vue';
import Login from './views/Login.vue';
import Careers from './views/Careers.vue';
import Home from './views/Home.vue';

const routes = [
    { path: '/', component: Home },
    { path: '/login', component: Login },
    { path: '/careers', component: Careers },
];


const router = createRouter({
    history: createWebHistory(),
    routes,
  });
  
  export default router;