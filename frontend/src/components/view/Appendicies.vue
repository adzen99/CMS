<template>
    <div class="w-100 background-contrast">
        <Topbar/>
        <div class="container">
            <div class="d-flex info-card">
                <h5>The list with the appendicies</h5>
                <button type="button" class="btn btn-warning" @click="openModalForm(addAppendixModal)"><font-awesome-icon class="icon-mr-7" icon="fa-solid fa-circle-plus" />Add a new appendix</button>
            </div>
            <section>
                <div class="mb-15px">
                    <span><b>{{ appendiciesNumber }} in total</b></span>
                </div>
            <table class="table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" /></th>
                            <th>#</th>
                            <th>Series / No.</th>
                            <th>Date</th>
                            <th>Contract</th>
                            <th>Value</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <Appendix v-for="(appendix, k) in appendicies" :appendix="appendix" :key="appendix.id" :no="k + 1" />
                    </tbody>
                </table>
            </section>
            <ModalForm :data-source="modalDataSource" @hide-modal="modalDataSource = false"/>
        </div>
    </div>
</template>

<script>
    import Appendix from "../Appendix.vue"
    import Topbar from "./Topbar.vue"
    import addAppendix from "../modal/blueprints/addAppendix.json"
    import ModalForm from "../modal/ModalForm.vue"

    export default {
        components : {Topbar, Appendix, ModalForm},
        data(){
            return {
                appendicies : {},
                appendiciesNumber : 0,
                modalDataSource: false,
            }
        },
        mounted(){
            fetch("http://localhost:8000/api/getMyAppendicies/" + this.$store.state.user.id)
            .then(response => {
                return response.json()
            }).then(data => {
                console.log(data)
                this.appendicies = data.myAppendicies
                this.appendiciesNumber = data.countMyAppendicies
            }).catch(e => { console.log(e) })
        },
        methods: {
            openModalForm(source){
                this.modalDataSource = source;
            }
        },
        computed: {
            addAppendixModal(){
                return addAppendix
            }
        }
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
