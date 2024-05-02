<script setup>
    import Sidebar from "./components/Sidebar.vue"
    import Topbar from "./components/Topbar.vue"
</script>

<template>
    <div class="app">
        <Sidebar/>
        <!-- <Topbar/> -->
        <router-view/>
    </div>
    
</template>

<style lang="scss">
    :root {
        --primary: #4ade80;
        --primary-alt: #22c55e;
        --grey: #64748b;
        --dark: #1e293b;
        --dark-alt: #334155;
        --light: #f1f5f9;
        --sidebar-width: 300px;
    }
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Fira sans', sans-serif;
    }
    #app{
        background: var(--dark-alt);
        color: var(--light); 
    }
    body {
        background: var(--light);
    }
    button {
        cursor: pointer;
        appearance: none;
        border: none;
        outline: none;
        background: none;
    }
    .app {
        display: flex;

        main {
            flex: 1 1 0;
            padding: 2rem;

            @media (max-width: 1024px) {
                padding-left: 6rem;
            }
        }
    }

    .background-contrast .info-card{
        background: radial-gradient(var(--dark), var(--dark-alt));
    }

    table thead th{
        background-color: var(--dark) !important;
        color: var(--light) !important;
    }

    table tbody td{
        color: var(--light) !important;
    }
    table tbody tr:nth-child(even) td{
        background-color: var(--grey) !important;
    }

    table tbody tr:nth-child(odd) td{
        background-color: var(--dark-alt) !important;
    }

  
   
</style>
