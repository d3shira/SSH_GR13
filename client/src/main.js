
import 'primevue/resources/themes/aura-light-green/theme.css';
import 'primeicons/primeicons.css';
import 'primevue/resources/primevue.min.css';
import '/node_modules/primeflex/primeflex.css';



import { createApp } from 'vue';
import App from './App.vue';
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import router from './router';




const app = createApp(App);

app.use(router);
app.use(PrimeVue);
app.use(ToastService)

app.mount('#app');
