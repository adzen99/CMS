<template>
    <div class="row m-5">
        <div class="d-flex info-card">
            <h5>The list with the invoices</h5>
            <button type="button" class="btn btn-warning" @click="openModalForm(addInvoiceModal)"><font-awesome-icon class="icon-mr-7" icon="fa-solid fa-circle-plus" />Add a new invoice</button>
        </div>
        <section>
            <div class="mb-15px">
                <span><b>{{ invoicesNumber }} in total</b></span>
            </div>
        <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Series / No.</th>
                        <th>Date</th>
                        <th>Value</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <Invoice v-for="(invoice, k) in invoices" :invoice="invoice" :key="invoice.id" :no="k + 1" />
                </tbody>
            </table>
        </section>
        <ModalForm :data-source="modalDataSource" @hide-modal="modalDataSource = false"/>
    </div>
</template>

<script>
    import Invoice from "../Invoice.vue"
    import addInvoice from "../modal/blueprints/addInvoice.json"
    import ModalForm from "../modal/ModalForm.vue"

    export default {
        components : {Invoice, ModalForm},
        mounted(){
        },
        data(){
            return {
                invoices : {},
                invoicesNumber : 0,
                modalDataSource: false,
            }
        },
        mounted(){
            fetch("http://localhost:8000/api/getMyInvoices/" + this.$store.state.user.id)
            .then(response => {
                return response.json()
            }).then(data => {
                this.invoices = data.myInvoices
                this.invoicesNumber = data.countMyInvoices
            }).catch(e => { console.log(e) })
        },
        methods: {
            openModalForm(source){
                this.modalDataSource = source;
            }
        },
        computed: {
            addInvoiceModal(){
                return addInvoice
            }
        }
    }
</script>