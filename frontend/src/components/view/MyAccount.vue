<script>
    import MyAccountGeneral from "../MyAccountGeneral.vue"
    import MyAccountCompanies from "../MyAccountCompanies.vue"
    import MyAccountPartners from "../MyAccountPartners.vue"

    export default {
        components : { MyAccountGeneral, MyAccountCompanies, MyAccountPartners },
        data(){
            return {
            }
        },
        methods: {
        },
    }
</script>

<template>
    <div class="m-2rem">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="false">General</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="companies-tab" data-bs-toggle="tab" data-bs-target="#companies" type="button" role="tab" aria-controls="companies" aria-selected="false">Companies</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="partners-tab" data-bs-toggle="tab" data-bs-target="#partners" type="button" role="tab" aria-controls="partners" aria-selected="false">Partners</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab"><MyAccountGeneral/></div>
            <div class="tab-pane fade" id="companies" role="tabpanel" aria-labelledby="companies-tab"><MyAccountCompanies/></div>
            <div class="tab-pane fade" id="partners" role="tabpanel" aria-labelledby="partners-tab"><MyAccountPartners/></div>
        </div>
    </div>
</template>

<style scoped>
</style>
