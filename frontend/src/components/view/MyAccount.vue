<script>
    import $ from "jquery"
    import Topbar from "./Topbar.vue"
    import MyAccountGeneral from "../MyAccountGeneral.vue"
    import MyAccountCompanies from "../MyAccountCompanies.vue"
    export default {
        components : { Topbar, MyAccountGeneral, MyAccountCompanies },
        mounted(){
            // var tab = localStorage.getItem("myAccountTab")
            // if(tab == null || typeof tab === 'undefined'){
            //     localStorage.setItem("myAccountTab", 'general-tab')
            //     tab = 'general-tab'
            // }
            // $('.nav-item .nav-link').removeClass('active').attr('aria-selected', 'false')
            // $('.nav-item .nav-link#'+tab).addClass('active').attr('aria-selected', 'true')

            // $('.tab-content .tab-pane').removeClass('active').removeClass('show')
            // $('.tab-content .tab-pane[aria-labelledby="'+tab+'"]').addClass('active').addClass('show')
            // this.onSelectedTab()
        },
        unmounted(){
            // this.offSelectedTab()
        },
        data(){
            return {
            }
        },
        methods: {
            // onSelectedTab() {
            //     $('.nav-item .nav-link').on("click", function(){
            //         localStorage.setItem("myAccountTab", this.id)
            //     })
            // },
            // offSelectedTab() {
            //     $('.nav-item .nav-link').off("click", function(){
            //         localStorage.setItem("myAccountTab", this.id)
            //     })
            // },
        },
    }
</script>

<template>
    <div class="w-100 background-contrast">
        <Topbar/>
        <div class="m-2rem">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="false"><font-awesome-icon class="icon-mr-7" icon="fa-solid fa-id-card" />General</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="companies-tab" data-bs-toggle="tab" data-bs-target="#companies" type="button" role="tab" aria-controls="companies" aria-selected="false"><font-awesome-icon class="icon-mr-7" icon="fa-solid fa-briefcase" />Companies</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade" id="general" role="tabpanel" aria-labelledby="general-tab"><MyAccountGeneral/></div>
                <div class="tab-pane fade" id="companies" role="tabpanel" aria-labelledby="companies-tab"><MyAccountCompanies/></div>
            </div>
        </div>
    </div>
</template>

<style scoped>
</style>
