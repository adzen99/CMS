<template>
    <ConfirmPopup></ConfirmPopup>
    <tr>
        <td>{{ no }}</td>
        <td>{{ invoice.series + invoice.no }}</td>
        <td>{{ (new Date(invoice.date)).toLocaleDateString() }}</td>
        <td>{{ invoice.value + ' ' + invoice.currency }}</td>
        <td>
            <div class="inline-spacing">
                <button type="button" class="btn btn-secondary" @click="generatePDF()"></button>
                <button type="button" class="btn btn-primary" @click="openModalForm(editInvoiceModal)"></button>
                <button type="button" class="btn btn-danger" @click="confirmDelete($event)"></button>
            </div>
        </td>
    </tr>
    <div v-show="false" ref="pdfContent">
        <div class="pdf-content">
            <div class="wrapper">
                <div class="provider">
                    <ul>
                        <li>FURNIZOR</li>
                        <li><b>{{ invoice.provider }}</b></li>
                        <li>{{ invoice.provider_address }}</li>
                        <li>{{ invoice.provider_locality + ', ' + invoice.provider_county }}</li>
                        <li class="mt-1">CUI: {{ invoice.provider_cui }}</li>
                        <li>{{ invoice.provider_nr_reg }}</li>
                        <li>{{ invoice.provider_bank }}</li>
                        <li>{{ invoice.iban }}</li>
                    </ul>
                </div>
                <div class="beneficiary">
                    <ul>
                        <li>BENEFICIAR</li>
                        <li><b>{{ invoice.beneficiary }}</b></li>
                        <li>{{ invoice.beneficiary_address }}</li>
                        <li>{{ invoice.beneficiary_locality + ', ' + invoice.beneficiary_county }}</li>
                        <li class="mt-1">CUI: {{ invoice.beneficiary_cui }}</li>
                        <li></li>
                        <li>{{ invoice.beneficiary_nr_reg }}</li>
                    </ul>
                </div>
            </div>
            <div class="invoice-info-wrapper mt-3">
                <div class="invoice-info">
                    <ul>
                        <li class="invoice-highlight">FACTURA</li>
                        <li class="invoice-date"><b>DATA : {{ invoice.date.split('-').reverse().join('.') }}</b></li>
                        <!-- <li>LA CONTRACTUL NR. {{ invoice.no_contract }} DIN {{ invoice.contract_date.split('-').reverse().join('.') }}</li> -->
                    </ul>
                </div>
                <div class="invoice-code">
                    <ul>
                        <li>{{ invoice.series + invoice.no }}</li>
                    </ul>
                </div>
            </div>
            <div class="mt-3 invoice-items-wrapper">
                <table class="invoice-items-table">
                    <tr v-for="item in items">
                        <td><b>{{ item.description }}</b></td>
                        <td></td>
                        <td><b>{{ parseFloat(item.value * exchangeRateToRON).toFixed(2) + ' ' + invoice.currency }}</b></td>
                    </tr>
                    <tr>
                        <td><b>TOTAL FARA TVA</b></td>
                        <td></td>
                        <td><b>{{ invoice.value + ' ' + invoice.currency }}</b></td>
                    </tr>
                    <tr>
                        <td>TVA</td>
                        <td>0 %</td>
                        <td>0.00 RON</td>
                    </tr>
                    <tr>
                        <td><b>TOTAL</b></td>
                        <td></td>
                        <td><b>{{ invoice.value + ' ' + invoice.currency }}</b></td>
                    </tr>
                </table>
                <p class="mt-2 exchange-rate-line" v-if="exchangeRateToRON !== null && invoice.currency !== 'RON'">CURS VALUTAR 1 {{ invoice.currency }} = {{ exchangeRateToRON }} RON</p>
            </div>
            <div class="wrapper footer-pdf">
                <div class="provider">
                    <ul>
                        <li><b>FURNIZOR</b></li>
                        <li><b>{{ invoice.provider }}</b></li>
                        <li class="mt-2">{{ 'vas' }}</li>
                    </ul>
                </div>
                <div class="beneficiary">
                    <ul>
                        <li><b>BENEFICIAR</b></li>
                        <li><b>{{ invoice.beneficiary }}</b></li>
                        <li class="mt-2"></li>
                    </ul>
                </div>
            </div>
            <div class="page-no mt-5" style=""><p>Pagina 1/1</p></div>
        </div>
    </div>
    <ModalForm :data-source="modalDataSource" :object="invoice" @hide-modal="modalDataSource = false"/>
</template>

<script>
    import ModalForm from "./modal/ModalForm.vue"
    import editInvoice from "./modal/blueprints/editInvoice.json"
    import ConfirmPopup from 'primevue/confirmpopup'

    export default {
        components : {ModalForm, ConfirmPopup},
        props: {
            invoice: Object,
            no: Number,
        },
        data() {
            return {
                items: null,
                items: null,
                modalDataSource: false,
                exchangeRateToRON: null,
                deleteEndpoint: 'http://localhost:8000/api/deleteInvoice'
            }
        },
        async mounted(){
            await fetch("http://localhost:8000/api/getInvoiceItems/" + this.invoice.id,{
                headers:{
                    'Authorization': 'Bearer ' + localStorage.getItem('jwt'),
                }
            })
                .then(response => {
                    return response.json()
                }).then(data => {
                    if(data.ok){
                        this.items = data.items
                        this.exchangeRateToRON = data.exchangeRateToRON
                    }
            }).catch(e => { console.log(e) })
        },
        methods: {
            openModalForm(source){
                this.modalDataSource = source;
            },
            confirmDelete(event) {
                this.$confirm.require({
                    target: event.currentTarget,
                    icon: 'pi pi-exclamation-triangle',
                    message: 'Do you want to delete this invoice?',
                    rejectClass: 'btn btn-secondary',
                    acceptClass: 'btn btn-danger',
                    rejectLabel: 'Cancel',
                    acceptLabel: 'Delete',
                    accept: () => {
                        fetch(this.deleteEndpoint, {
                            method: 'DELETE',
                            headers: {
                                "Content-Type": "application/json",
                                "Access-Control-Allow-Headers": "Origin, X-Requested-With, Content-Type, Accept",
                                'Authorization': 'Bearer ' + localStorage.getItem('jwt'),
                            },
                            body: JSON.stringify({'id': this.invoice.id})
                        }).then(response => {
                            return response.json()
                        }).then(data =>{
                            if(data.ok){
                                this.$toast.add({ severity: 'success', summary: 'Succes!', detail: data.message, life: 5000, closable: true });
                            }else{
                                this.$toast.add({ severity: 'error', summary: 'Attention!', detail: data.toastErrorMessage, life: 5000, closable: true });
                            }
                        }).catch(e => { console.log(e); })
                    }
                });
            },
            generatePDF(){ 
            }
        },
        computed: {
            editInvoiceModal(){
                return editInvoice
            }
        }
    }
</script>

<style scoped>
    .pdf-content {
        color:black !important;
        font-size: 0.7rem;
        margin-left:5%;
        /* display: inline-flex; */
    }
    .pdf-content ul{
        list-style: none;
    }
    .company-partner-info{
        width: 100%;
    }
    .company-partner-info tr td:first-child{
        text-align: left;
    }
    .company-partner-info tr td:last-child{
        text-align: right;
    }
    .provider{
        width:50%;
        float: left;
    }
    .beneficiary{
        width:45%;
        float: right;
        text-align: right;
    }
    .wrapper, .invoice-info-wrapper{
        display: flex;
    }

    .invoice-info{
        width:50%;
        float: left;
    }
    .invoice-highlight{
        font-family: "Times New Roman", Times, serif;
        font-size: 2rem;
        color: #dd3d24;
    }
    .invoice-code li{
        font-family: "Times New Roman", Times, serif;
        font-size: 2rem;
    }
    .invoice-date{
        font-size: 0.75rem;
        font-family: "Times New Roman", Times, serif;
    }
    .invoice-code{
        width:45%;
        float: right;
        text-align: right;
    }
    .invoice-items-wrapper{
        margin-left:5%;
    }
    .invoice-items-table{
        width: 95%;
    }
    .invoice-items-table td{
        text-align: unset !important;
        padding: 5px;
    }
    .invoice-items-table tr{
        border-bottom: 1px solid #c7c7c7 !important;
    }
    .invoice-items-table tr:first-child{
        border-top: 1px solid #c7c7c7 !important;
    }
    .exchange-rate-line{
        font-size: 0.5rem;
    }
    .footer-pdf{
        position: relative;
        width: 100%;
        bottom: 0;
        height: 2.5rem;
        margin-top:20rem;
    }
    .page-no{
        width:95%;
        text-align:right;
    }
</style>
