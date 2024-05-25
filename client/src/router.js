

import {createRouter, createWebHistory} from 'vue-router';
import Register from './views/Register.vue';
import Login from './views/Login.vue';
import Careers from './views/Careers.vue';
import Home from './views/Home.vue';
import Agents from './views/Agents.vue'; 
import Properties from './views/Properties.vue';
import Contact from './views/Contact.vue';
import AboutUs from './views/AboutUs.vue';
import Dashboard from './views/staffViews/Dashboard.vue';
import adminDashboard from './views/adminViews/adminDashboard.vue';
import manageClients from './views/adminViews/manageClients.vue';
import addClient from './views/adminViews/addClient.vue';
import editClient from './views/adminViews/editClient.vue';


const routes = [
    { path: '/', component: Home },

    { path: '/register',component:Register},
    { path: '/login', component: Login },
    { path: '/careers', component: Careers },
    { path: '/agents', component: Agents },
    { path: '/properties', component: Properties },
    { path: '/contact', component: Contact },
    { path: '/aboutus', component: AboutUs},
    {path: '/staffDashboard', component: Dashboard},
    {path:'/adminDashboard',component:adminDashboard},
    {path: '/manageClients', component:manageClients},
    {path: '/addClient', component:addClient},
    {path: '/editClient', component: editClient} 

];

const router = createRouter({
    history: createWebHistory(),
    routes,
  });
  
  export default router;