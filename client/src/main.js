import 'primevue/resources/themes/aura-light-green/theme.css';
import 'primeicons/primeicons.css';
import 'primevue/resources/primevue.min.css';
import '/node_modules/primeflex/primeflex.css';

import { createApp } from 'vue';
import App from './App.vue';
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import router from './router'; // Correct import for router

import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import 'primevue/resources/themes/aura-light-green/theme.css';
import 'primeicons/primeicons.css';
import 'primevue/resources/primevue.min.css';
import '/node_modules/primeflex/primeflex.css';
import Dropdown from 'primevue/dropdown';
import Menubar from 'primevue/menubar';

const app = createApp(App);

app.use(router);
app.use(PrimeVue);
app.use(ToastService);

app.component('InputText', InputText);
app.component('Button', Button);
app.component('Dropdown', Dropdown);
app.component('Menubar', Menubar);


app.mount('#app');
