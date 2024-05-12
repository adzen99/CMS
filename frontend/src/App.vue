<script setup>
    import Sidebar from "./components/view/Sidebar.vue"
</script>

<template>
    <Sidebar v-if="$route.path != '/login'"/>
    <router-view/>
</template>

<style lang="scss">
    :root {
        --primary: #4ade80;
        --primary-alt: #22c55e;
        --grey: #64748b;
        --dark: #1e293b;
        --dark-alt: #334155;
        --dark-alt-lighter: #303d50;
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
    #app {
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

    table tbody td, label, .nav-item .nav-link, .modal-title, .btn-close{
        color: var(--light) !important;
    }
    table tbody tr:nth-child(even) td{
        background-color: var(--dark-alt-lighter) !important;
    }

    table tbody tr:nth-child(odd) td{
        background-color: var(--dark-alt) !important;
    }

    table th, table td {
        vertical-align: middle;
    }
    
    .nav-tabs {
        border-bottom: var(--bs-nav-tabs-border-width) solid var(--grey)  !important;
    }
    .nav-item .nav-link.active {
        background: var(--dark) !important;
        font-weight: bold;
        border-color: var(--grey) !important;
    }
    
    .card {
        border: var(--bs-card-border-width) solid var(--grey) !important;
        color: var(--light) !important;
    }
    .card-header{
        background: var(--dark) !important;
    }
    .card-body{
        background: var(--dark-alt-lighter) !important;
    }
    input.form-control, select.form-select {
        background: var(--dark) !important;
        color: var(--light) !important;
        border: var(--bs-border-width) solid var(--grey) !important;
    }
    .input-group .input-group-text {
        color: var(--light) !important;
        background: var(--dark-alt) !important;
        border: var(--bs-border-width) solid var(--grey) !important;
    }

    .modal-content{
        background: var(--dark) !important;
    }

</style>
