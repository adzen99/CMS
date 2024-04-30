import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from './router'
import globals from './globals'
import axios from 'axios'

import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import { faCircleUser } from '@fortawesome/free-solid-svg-icons'
import { faCalendarDays } from '@fortawesome/free-solid-svg-icons'
import { faEuroSign } from '@fortawesome/free-solid-svg-icons'
import { faFileInvoice } from '@fortawesome/free-solid-svg-icons'
import { faFileLines } from '@fortawesome/free-solid-svg-icons'
import { faGears } from '@fortawesome/free-solid-svg-icons'

library.add(faCircleUser)
library.add(faCalendarDays)
library.add(faEuroSign)
library.add(faFileInvoice)
library.add(faFileLines)
library.add(faGears)

const app = createApp(App)

app.config.globalProperties.globals = globals
app.config.globalProperties.axios = axios

app.component('font-awesome-icon', FontAwesomeIcon).use(router).mount('#app')