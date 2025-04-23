import { createApp } from 'vue'
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';
import './style.css'
import 'primeicons/primeicons.css';
import router from './router'
import App from './App.vue'
import Aura from '@primevue/themes/aura';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import axios from 'axios';
// import { config } from './config'

const app = createApp(App)

app.use(router)
app.use(PrimeVue, {
    theme: {
        preset: Aura
    }
})
app.use(ToastService)
app.use(ConfirmationService)

app.config.globalProperties.$axios = axios;
app.config.globalProperties.$apiUrl = 'http://localhost:8000/api';
// app.config.globalProperties.$apiUrl = config.apiUrl;
// app.config.globalProperties.$baseUrl = config.baseUrl;

app.mount('#app')