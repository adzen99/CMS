import { createRouter, createWebHistory } from 'vue-router'

import Home from '../components/view/Home.vue'
import Login from '../components/view/Login.vue'
import Invoices from '../components/view/Invoices.vue'
import Appendicies from '../components/view/Appendicies.vue'
import MyAccount from '../components/view/MyAccount.vue'
import Contracts from '../components/view/Contracts.vue'

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/invoices',
        name: 'Invoices',
        component: Invoices
    },
    {
        path: '/appendicies',
        name: 'Appendicies',
        component: Appendicies
    },
    {
        path: '/myaccount',
        name: 'MyAccount',
        component: MyAccount
    },
    {
        path: '/contracts',
        name: 'Contracts',
        component: Contracts
    }
]

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})

export default router