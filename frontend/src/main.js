import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import PrimeVue from "primevue/config"
import ConfirmationService from 'primevue/confirmationservice'
import ToastService from 'primevue/toastservice'
import Ripple from 'primevue/ripple';

import 'primevue/resources/themes/lara-dark-blue/theme.css'; // dark theme

import router from './router'
import globals from './globals'
import store from './store/store'
import 'primevue/resources/primevue.min.css';
import 'primeicons/primeicons.css'; // This one is crucial for icons


const app = createApp(App)

app.config.globalProperties.globals = globals

app.use(router).use(store).use(PrimeVue, { ripple: true }).use(ConfirmationService).use(ToastService)
app.directive('ripple', Ripple);

app.mount('#app')