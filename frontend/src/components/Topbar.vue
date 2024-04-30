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
    <div>
        <div class="topside-bar">
            <div class="container-topbar">
                <div>
                    <a href="/" class="home-title">Invoicing</a>
                </div>
                <div>
                    <ul>
                        <li><a href="#"><font-awesome-icon class="icon" icon="fa-solid fa-euro-sign" />About</a></li>
                        <li><a href="#"><font-awesome-icon class="icon" icon="fa-solid fa-calendar-days" />{{ currentDate }}</a></li>
                        <li><a href="#"><font-awesome-icon class="icon" icon="fa-solid fa-circle-user" />Vasile Parpalac</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .icon{
        margin-right: 7px;
    }
    .container-topbar {
        display: inline-flex;   
        width:100%;
        justify-content: space-between;
    }
    .app-title{
        position: relative;
        z-index: 1;
        color: white;
    }
    .topside-bar {
        background-color: #333;
        color: #fff;
        padding: 10px 0px;
        text-align: center;
        position: fixed;
        top: 0;
        width:100%;
        z-index: 1;
    }

    .home-title{
        font-size: 20px;
    }
    .home-title:hover{
        background-color: #555;
        padding: 5px;
    }
    
    .topside-bar a {
        color: #fff;
        text-decoration: none;
        margin: 0 10px;
    }

    ul {
            list-style: none;
            padding: 0;
            margin: 0;
            text-align: center;
        }
        
        ul li {
            display: inline-block;
            margin-right: 10px;
        }
        
        ul li:last-child {
            margin-right: 0;
        }
        
        ul li a {
            text-decoration: none;
            color: #333;
            padding: 5px 10px;
            border: 1px solid #333;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        
        ul li a:hover {
            background-color: #333;
            color: #fff;
        }

</style>
