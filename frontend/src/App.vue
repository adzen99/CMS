<script>
    import Sidebar from "./components/view/Sidebar.vue"

    export default {
    components: { Sidebar },
    name: 'App',
    watch: {
        $route: {
            immediate: true,
            handler(to, from) {
                document.title = 'CMS | ' + to.name || 'CMS'
            }
        },
    }
};
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

    table th, table td {
        vertical-align: middle;
    }

    .nav-link{ color: unset !important; }

</style>
