<template>
    <div class="w-100 background-contrast">
        <Topbar/>
        <div class="container">
            <div class="d-flex info-card">
                <h5>The list with the appendicies</h5>
                <button type="button" class="btn btn-warning" @click="openModal()"><font-awesome-icon class="icon-mr-7" icon="fa-solid fa-circle-plus" />Add a new appendix</button>
            </div>
            <section>
                <div class="mb-15px">
                    <span><b>{{ appendiciesNumber }} in total</b></span>
                </div>
            <table class="table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" /></th>
                            <th>No.</th>
                            <th>Date</th>
                            <th>Contract</th>
                            <th>Value</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <Appendix v-for="appendix in appendicies" :appendix="appendix" :key="appendix.id" />
                    </tbody>
                </table>
            </section>
            <AddAppendixModal :data="addAppendixModalOpen" @hidden-modal="addAppendixModalOpen=false"/>
        </div>
    </div>
</template>

<script>
    import Appendix from "../Appendix.vue"
    import Topbar from "./Topbar.vue"
    import AddAppendixModal from "../modals/AddAppendixModal.vue"

    export default {
        components : { Topbar, Appendix, AddAppendixModal},
        data(){
            return {
                appendicies : {},
                appendiciesNumber : 0,
                addAppendixModalOpen: false,
            }
        },
        methods: {
            openModal(){
                if(this.addAppendixModalOpen===false) this.addAppendixModalOpen = true;
            }
        },
    }
</script>

<style scoped>
    section table{
        width: 100%;
    }
    .mb-15px{
        margin-bottom: 15px;
    }
    .d-flex {
        justify-content: space-between;
        align-items: center;
        margin-bottom:15px;
    }
    .container{
        margin-top: 2rem;
    }
    h5{
        margin-bottom: 0 !important;
    }
    .info-card {
        padding: 12px;
        border-radius: 15px;
    }
</style>
