// import Vue from 'vue'
import Vuex from 'vuex'

// Vue.use(Vuex)
const store = new Vuex.createStore({
    state: {
        user: {id: 1, username: 'alex.dzen', email: 'dzenalex9@gmail.com', first_name: 'Alex', last_name: 'Dzen', phone: '0751321045'}
    }
})
export default store