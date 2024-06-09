<script>
    export default {
        data(){
            return {
                currentDate: this.getCurrentDate()
            }
        },
        methods: {
            getCurrentDate(){
                const date = new Date()
                return this.globals.weekDays[date.getDay()] + ', ' + date.toLocaleDateString()
            }
        },
        computed:{
            loggedUser(){
                return this.$store.state.user
            }
        },
    }
</script>

<template> 
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav gap-3 me-5">
                <li class="nav-item">
                    <span class="nav-link"><font-awesome-icon class="icon-mr-7" icon="fa-solid fa-euro-sign" />4.97 RON</span>
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
                            <router-link to="/" class="dropdown-item">
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
<style scoped>
    span.icon{
        margin-right: 0.5rem;
    }
</style>