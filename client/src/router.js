

import {createRouter, createWebHistory} from 'vue-router';
import Register from './views/Register.vue';
import Login from './views/Login.vue';
import Careers from './views/Careers.vue';
import Properties from './views/Properties.vue';

const routes = [
    { path: '/', component: Properties },
];


const router = createRouter({
    history: createWebHistory(),
    routes,
  });
  
  export default router;