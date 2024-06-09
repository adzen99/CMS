<template>
    <nav class="sidebar bg-body-tertiary">
        <div class="sidebar-content">
            <div class="sidebar-logo">
                <router-link to="/">CMS</router-link>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-header">
                    Documente
                </li>
                <li class="sidebar-item">
                    <router-link to="/appendicies" class="sidebar-link">
                        <span class="icon"><font-awesome-icon icon="fa-solid fa-file-lines"/></span>
                        <span class="text">Anexe</span>
                    </router-link>
                </li>
                <li class="sidebar-item">
                    <router-link to="/invoices" class="sidebar-link">
                        <span class="icon"><font-awesome-icon icon="fa-solid fa-file-invoice"/></span>
                        <span class="text">Facturi</span>
                    </router-link>
                </li>
                <li class="sidebar-item">
                    <router-link to="/contracts" class="sidebar-link">
                        <span class="icon"><font-awesome-icon icon="fa-solid fa-file-contract"/></span>
                        <span class="text">Contracte</span>
                    </router-link>
                </li>
                <li class="sidebar-header">
                    Setari
                </li>
                <li class="sidebar-item">
                    <router-link to="/myaccount" class="sidebar-link">
                        <span class="icon"><font-awesome-icon icon="fa-solid fa-gears"/></span>
                        <span class="text">Contul meu</span>
                    </router-link>
                </li>
                <!-- <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#pages"
                        aria-expanded="false" aria-controls="pages">
                        <i class="fa-regular fa-file-lines pe-2"></i>
                        Pages
                    </a>
                    <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Analytics</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Ecommerce</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Crypto</a>
                        </li>
                    </ul>
                </li> -->
            </ul>
        </div>
    </nav>
</template>
<script setup>
</script>
<style scoped>
    .sidebar{
        direction: ltr;
        max-width: 260px;
        min-width: 260px;
        transition: margin-left .35s ease-in-out, left .35s ease-in-out, margin-right .35s ease-in-out, right .35s ease-in-out;
    }
    .sidebar-content{
        height: 100vh;
        left: 0;
        position: sticky;
        top: 0;
    }
    a{
        text-decoration: none;
    }
    .sidebar-logo {
        padding: 1.15rem 1.5rem;
    }
    .sidebar-logo a {
        color: #e9ecef;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .sidebar-nav {
        padding: 0;
    }

    .sidebar-header {
        color: #e9ecef;
        font-size: .75rem;
        padding: 1.5rem 1.5rem .375rem;
    }

    a.sidebar-link {
        padding: .625rem 1.625rem;
        color: #e9ecef;
        position: relative;
        display: block;
        font-size: 1rem;
    }

    a.sidebar-link > .icon{
        margin-right: 0.5rem;
    }

    .sidebar-item .router-link-active{
        background-color: #222529;
        border-top: 1px solid var(--bs-gray);
        border-bottom: 1px solid var(--bs-gray);
    }

    .sidebar-link[data-bs-toggle="collapse"]::after {
        border: solid;
        border-width: 0 .075rem .075rem 0;
        content: "";
        display: inline-block;
        padding: 2px;
        position: absolute;
        right: 1.5rem;
        top: 1.4rem;
        transform: rotate(-135deg);
        transition: all .2s ease-out;
    }

    .sidebar-link[data-bs-toggle="collapse"].collapsed::after {
        transform: rotate(45deg);
        transition: all .2s ease-out;
    }
</style>
