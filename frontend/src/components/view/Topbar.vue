<template> 
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav gap-3 me-5">
                <li class="nav-item dropdown">
                    <button class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        1 EUR = {{ exchangeRates.EUR }} RON
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item">1 CHF = {{ exchangeRates.CHF }} CHF</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item">1 GBP = {{ exchangeRates.GBP }} GBP</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item">1 HUF = {{ exchangeRates.HUF }} HUF</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item">1 USD = {{ exchangeRates.USD }} USD</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <span class="nav-link"><font-awesome-icon class="icon-mr-7" icon="fa-solid fa-calendar-days" />{{ currentDate }}</span>
                </li>
                <li class="nav-item dropdown">
                    <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <font-awesome-icon class="icon-mr-7" icon="fa-solid fa-circle-user" />{{ loggedUser.first_name + ' ' + loggedUser.last_name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li>
                            <router-link to="/myaccount" class="dropdown-item">
                                <span class="icon"><font-awesome-icon icon="fa-solid fa-gears"/></span>
                                <span class="text">Contul meu</span>
                            </router-link>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <router-link to="/login" class="dropdown-item" @click="handleLogout()">
                                <span class="icon"><font-awesome-icon icon="fa-solid fa-right-from-bracket" /></span>
                                <span class="text">Log out</span>
                            </router-link>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav> 
</template>
<script>
    export default {
        data(){
            return {
                exchangeRates: []
            }
        },
        created(){
            fetch("http://localhost:8000/api/getExchangeRatesOfToday/",{
                headers:{
                    'Authorization': 'Bearer ' + localStorage.getItem('jwt'),
                }
            })
                .then(response => {
                    return response.json()
                }).then(data => {
                    if(data.ok){
                        this.exchangeRates = data.exchangeRates
                    }
                }).catch(e => { console.log(e) })
        },
        computed:{
            loggedUser(){
                return this.$store.state.user
            },
            currentDate(){
                const date = new Date()
                return this.globals.weekDays[date.getDay()] + ', ' + date.toISOString().slice(0,10).split('-').reverse().join('.')
            }
        },
        methods: {
            handleLogout(){
                fetch("http://127.0.0.1:8000/api/logout", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        "Access-Control-Allow-Credentials": true,
                        'Authorization': 'Bearer ' + localStorage.getItem('jwt'),
                    },
                    credentials: 'include',
                }).then(() => {
                    this.$router.push("/login")
                    localStorage.removeItem('jwt')
                }).catch(e => { console.log(e) })
                this.$toast.add({ severity: 'info', summary: 'Info!', detail: 'Logout cu succes!', life: 5000, closable: true });
            }
        }
    }
</script>
<style scoped>
    span.icon{
        margin-right: 0.5rem;
    }
</style>