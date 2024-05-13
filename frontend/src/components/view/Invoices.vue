<template>
    <div class="w-100 background-contrast">
        <Topbar/>
        <div class="container">
            <div class="d-flex info-card">
                <h5>The list with the invoices</h5>
                <button type="button" class="btn btn-warning" @click="openModal()"><font-awesome-icon class="icon-mr-7" icon="fa-solid fa-circle-plus" />Add a new invoice</button>
            </div>
            <section>
                <div class="mb-15px">
                    <span><b>{{ invoicesNumber }} in total</b></span>
                </div>
            <table class="table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" /></th>
                            <th>#</th>
                            <th>Date</th>
                            <th>Contract</th>
                            <th>Value</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <Invoice v-for="invoice in invoices" :invoice="invoice" :key="invoice.id" />
                    </tbody>
                </table>
            </section>
            <AddInvoiceModal :data="addInvoiceModalOpen" @hidden-modal="addInvoiceModalOpen=false"/>
        </div>
    </div>
</template>

<script>
    import Invoice from "../Invoice.vue"
    import Topbar from "./Topbar.vue"
    import AddInvoiceModal from "../modals/AddInvoiceModal.vue"

    export default {
        components : { Topbar, Invoice, AddInvoiceModal},
        mounted(){
        },
        data(){
            return {
                invoices : {},
                invoicesNumber : 0,
                addInvoiceModalOpen: false,
            }
        },
        mounted(){
            // fetch("http://localhost:8000/api/getMyInvoices/" + this.$store.state.user.id)
            // .then(response => {
            //     return response.json()
            // }).then(data => {
            //     this.invoices = data.myInvoices
            //     this.invoicesNumber = data.countMyInvoices
            // }).catch(e => { console.log(e) })
        },
        methods: {
            openModal(){
                if(this.addInvoiceModalOpen===false) this.addInvoiceModalOpen = true;
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
