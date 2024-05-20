import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from './router'
import globals from './globals'
import store from './store/store'

import 'bootstrap'
import "bootstrap/dist/css/bootstrap.min.css"
import 'bootstrap/dist/js/bootstrap.js'

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
import { faIdCard } from '@fortawesome/free-solid-svg-icons'
import { faBriefcase } from '@fortawesome/free-solid-svg-icons'
import { faUser } from '@fortawesome/free-solid-svg-icons'
import { faSquarePhone } from '@fortawesome/free-solid-svg-icons'
import { faEnvelope } from '@fortawesome/free-solid-svg-icons'
import { faPhone } from '@fortawesome/free-solid-svg-icons'
import { faFloppyDisk } from '@fortawesome/free-solid-svg-icons'
import { faRightToBracket } from '@fortawesome/free-solid-svg-icons'
import { faHandshake } from '@fortawesome/free-solid-svg-icons'
import { faFileContract } from '@fortawesome/free-solid-svg-icons'
import { faTableList } from '@fortawesome/free-solid-svg-icons'

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
library.add(faIdCard)
library.add(faBriefcase)
library.add(faUser)
library.add(faSquarePhone)
library.add(faEnvelope)
library.add(faPhone)
library.add(faFloppyDisk);
library.add(faRightToBracket);
library.add(faHandshake);
library.add(faFileContract);
library.add(faTableList);

const app = createApp(App)

app.config.globalProperties.globals = globals

app.component('font-awesome-icon', FontAwesomeIcon)

app.use(router).use(store)

app.mount('#app')