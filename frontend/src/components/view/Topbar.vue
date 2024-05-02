<script>
    export default {
        data(){
            return {
                fullName: null,
                currentDate: this.getCurrentDate()
            }
        },
        methods: {
            getCurrentDate(){
                const date = new Date()
                return this.globals.weekDays[date.getDay()] + ', ' + date.toLocaleDateString()
            }
        },
        mounted(){
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
                    <span class="nav-link"><font-awesome-icon class="icon-mr-7" icon="fa-solid fa-circle-user" />Vasile Parpalac</span>
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
