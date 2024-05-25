

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
import ManageJobApplications from './views/staffViews/ManageJobApplications.vue';
import AddProperty from './views/staffViews/AddProperty.vue';
import registerStaff from './views/adminViews/registerStaff.vue';
import updateStaff from './views/adminViews/updateStaff.vue';
import deleteStaff from './views/adminViews/deleteStaff.vue';



const routes = [
    { path: '/', component: Home },

    { path: '/register',component:Register},
    { path: '/login', component: Login },
    { path: '/careers', component: Careers },
    { path: '/agents', component: Agents },
    { path: '/properties', component: Properties },
    { path: '/contact', component: Contact },
    { path: '/aboutus', component: AboutUs},
    { path: '/adminDashboard',component:adminDashboard},
    {path: '/job-applications', component: ManageJobApplications},
    { path: '/staffDashboard', component: Dashboard},
    { path: '/add-property', component: AddProperty},
    { path: '/registerStaff',component:registerStaff},
    { path: '/updateStaff', component:updateStaff},
    { path: '/deleteStaff', component:deleteStaff}
];

const router = createRouter({
    history: createWebHistory(),
    routes,
  });
  
  export default router;