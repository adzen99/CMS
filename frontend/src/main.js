import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from './router'
import globals from './globals'
import axios from 'axios'
import 'bootstrap/dist/css/bootstrap.css'
import bootstrap from 'bootstrap/dist/js/bootstrap.js'

import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import { faCircleUser } from '@fortawesome/free-solid-svg-icons'
import { faCalendarDays } from '@fortawesome/free-solid-svg-icons'
import { faEuroSign } from '@fortawesome/free-solid-svg-icons'
import { faFileInvoice } from '@fortawesome/free-solid-svg-icons'
import { faFileLines } from '@fortawesome/free-solid-svg-icons'
import { faGears } from '@fortawesome/free-solid-svg-icons'
import { faAnglesRight } from '@fortawesome/free-solid-svg-icons'
import { faHouse } from '@fortawesome/free-solid-svg-icons'
import { faFilePdf } from '@fortawesome/free-solid-svg-icons'
import { faPenToSquare } from '@fortawesome/free-solid-svg-icons'
import { faTrashCan } from '@fortawesome/free-solid-svg-icons'
import { faCirclePlus } from '@fortawesome/free-solid-svg-icons'

library.add(faCircleUser)
library.add(faCalendarDays)
library.add(faEuroSign)
library.add(faFileInvoice)
library.add(faFileLines)
library.add(faGears)
library.add(faAnglesRight)
library.add(faHouse)
library.add(faFilePdf)
library.add(faPenToSquare)
library.add(faTrashCan)
library.add(faCirclePlus)

const app = createApp(App)

app.config.globalProperties.globals = globals
app.config.globalProperties.axios = axios

app.component('font-awesome-icon', FontAwesomeIcon)

app.use(router)
app.use(bootstrap)

app.mount('#app')