<script>
    import Sidebar from "./components/view/Sidebar.vue"
    import TopBar from "./components/view/Topbar.vue"
    import Toast from 'primevue/toast'

    export default {
    components: { Sidebar, TopBar, Toast },
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
    <Toast />

    <div class="wrapper">
        <Sidebar v-if="$route.path != '/login'"/>
        <div class="main">
            <TopBar v-if="$route.path != '/login'"/>
            <main class="content">
                <router-view/>
            </main>
        </div>
    </div>

</template>

<style lang="scss">
</style>
