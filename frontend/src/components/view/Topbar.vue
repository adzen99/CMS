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
        mounted(){
            // $('.dropdown-toggle').dropdown()
            // this.axios.get('https://www.bnr.ro/nbrfxrates.xml', {
            //     headers: {
            //         "Access-Control-Allow-Origin": "*",
            //         'Accept': 'application/xml',
            //         'Content-Type': 'application/xml'
            //     }
            // })
            // .then(function (response) {
            //     console.log(response);
            // })
        }
    }
</script>

<template> 
    <nav class="navbar navbar-expand-lg">
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <span class="nav-link"><font-awesome-icon class="icon-mr-7" icon="fa-solid fa-euro-sign" />4.97 RON</span>
                </li>
                <li class="nav-item">
                    <span class="nav-link"><font-awesome-icon class="icon-mr-7" icon="fa-solid fa-calendar-days" />{{ currentDate }}</span>
                </li>
                <li class="nav-item">
                    <div class="btn-group">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <font-awesome-icon class="icon-mr-7" icon="fa-solid fa-circle-user" />{{ loggedUser.first_name + ' ' + loggedUser.last_name }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" type="button">Action</button>
                        <button class="dropdown-item" type="button">Another action</button>
                        <button class="dropdown-item" type="button">Something else here</button>
                    </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav> 
</template>

<style scoped>
    nav{
        width: 100%;
        height: 60px;
        background-color: var(--dark);
    }
    .nav-item{
        padding: 10px;
    }
    .nav-item .nav-link {
        color: var(--light) !important;
    }
</style>
