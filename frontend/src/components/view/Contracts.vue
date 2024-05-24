<template>
    <div class="w-100 background-contrast">
        <Topbar/>
        <div class="container">
            <div class="d-flex info-card">
                <h5>The list with the contracts</h5>
                <button type="button" class="btn btn-warning" @click="openModalForm(addContractModal)"><font-awesome-icon class="icon-mr-7" icon="fa-solid fa-circle-plus" />Add a new contract</button>
            </div>
            <section>
                <div class="mb-15px">
                    <span><b>{{ contractsNumber }} in total</b></span>
                </div>
            <table class="table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" /></th>
                            <th>#</th>
                            <th>No. / Date</th>
                            <th>Expiration date</th>
                            <th>Provider</th>
                            <th>Beneficiary</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <Contract v-for="(contract, k) in contracts" :contract="contract" :key="contract.id" :no="k + 1" />
                    </tbody>
                </table>
            </section>
            <ModalForm :data-source="modalDataSource" @hide-modal="modalDataSource = false"/>
        </div>
    </div>
</template>

<script>
    import Contract from "../Contract.vue"
    import Topbar from "./Topbar.vue"
    import addContract from "../modal/blueprints/addContract.json"
    import ModalForm from "../modal/ModalForm.vue"

    export default {
        components : { Topbar, Contract, ModalForm},
        mounted(){
            fetch("http://localhost:8000/api/getMyContracts/" + this.$store.state.user.id)
            .then(response => {
                return response.json()
            }).then(data => {
                this.contracts = data.myContracts
                this.contractsNumber = data.countMyContracts
            }).catch(e => { console.log(e) })
        },
        data(){
            return {
                contracts : {},
                contractsNumber : 0,
                modalDataSource: false,
            }
        },
        methods: {
            openModalForm(source){
                this.modalDataSource = source;
            }
        },
        computed: {
            addContractModal(){
                return addContract
            }
        }
    }
</script>

<style scoped>
    section table{
        width: 100%;
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
