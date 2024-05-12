<script>
    import Invoice from "../Invoice.vue"
    import Topbar from "./Topbar.vue"
    export default {
        components : { Topbar, Invoice},
        mounted(){
        },
        data(){
            return {
                invoices : [
                    {id:1, no: 1323, date: '2024-01-01', contract: '1 of 2024-01-01', value: '2234.24 RON'},
                    {id:2, no: 22, date: '2024-01-01', contract: '1 of 2024-01-01', value: '9551.24 RON'}
                ],
                invoicesNumber : 2,
            }
        }
    }
</script>

<template>
    <div class="w-100 background-contrast">
        <Topbar/>
        <div class="container">
            <div class="d-flex info-card">
                <h5>The list with the invoices</h5>
                <button type="button" class="btn btn-warning"><font-awesome-icon class="icon-mr-7" icon="fa-solid fa-circle-plus" />Add a new invoice</button>
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
        </div>
    </div>
</template>

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
