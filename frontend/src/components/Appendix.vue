<template>
    <ConfirmPopup></ConfirmPopup>
    <tr ref="content">
        <td>{{ no }}</td>
        <td>{{ appendix.series + appendix.no }}</td>
        <td>{{ (new Date(appendix.date)).toLocaleDateString() }}</td>
        <td>{{ appendix.no_contract + ' from ' + (new Date(appendix.contract_date)).toLocaleDateString() }}</td>
        <td>{{ appendix.value + ' ' + appendix.currency }}</td>
        <td>
            <div class="inline-spacing">
                <button type="button" class="btn btn-secondary" @click="generatePDF()"><font-awesome-icon icon="fa-solid fa-file-pdf" /></button>
                <button type="button" class="btn btn-info" @click="openModalForm(addAppendixItemModal)"><font-awesome-icon icon="fa-solid fa-table-list" /></button>
                <button type="button" class="btn btn-primary" @click="openModalForm(editAppendixModal)"><font-awesome-icon icon="fa-solid fa-pen-to-square" /></button>
                <button type="button" class="btn btn-danger" @click="confirmDelete($event)"><font-awesome-icon icon="fa-solid fa-trash-can" /></button>
            </div>
        </td>
    </tr>
    <div v-show="false" ref="pdfContent">
        <div class="pdf-content">
            <div class="wrapper">
                <div class="provider">
                    <ul>
                        <li>FURNIZOR</li>
                        <li><b>{{ appendix.provider }}</b></li>
                        <li>{{ appendix.provider_address }}</li>
                        <li>{{ appendix.provider_locality + ', ' + appendix.provider_county }}</li>
                        <li class="mt-1">CUI: {{ appendix.provider_cui }}</li>
                        <li>{{ appendix.provider_nr_reg }}</li>
                        <li>{{ appendix.provider_bank }}</li>
                        <li>{{ appendix.iban }}</li>
                    </ul>
                </div>
                <div class="beneficiary">
                    <ul>
                        <li>BENEFICIAR</li>
                        <li><b>{{ appendix.beneficiary }}</b></li>
                        <li>{{ appendix.beneficiary_address }}</li>
                        <li>{{ appendix.beneficiary_locality + ', ' + appendix.beneficiary_county }}</li>
                        <li class="mt-1">CUI: {{ appendix.beneficiary_cui }}</li>
                        <li></li>
                        <li>{{ appendix.beneficiary_nr_reg }}</li>
                    </ul>
                </div>
            </div>
            <div class="appendix-info-wrapper mt-3">
                <div class="appendix-info">
                    <ul>
                        <li class="appendix-highlight">ANEXA</li>
                        <li class="appendix-date"><b>DATA : {{ appendix.date.split('-').reverse().join('.') }}</b></li>
                        <li>LA CONTRACTUL NR. {{ appendix.no_contract }} DIN {{ appendix.contract_date.split('-').reverse().join('.') }}</li>
                    </ul>
                </div>
                <div class="appendix-code">
                    <ul>
                        <li>{{ appendix.series + appendix.no }}</li>
                    </ul>
                </div>
            </div>
            <div class="mt-3 appendix-items-wrapper">
                <table class="appendix-items-table">
                    <tr v-for="item in items">
                        <td><b>{{ item.description }}</b></td>
                        <td>{{ item.quantity + ' ' +  mapUOM[item.uom] }} X {{ item.unit_price + ' ' + appendix.currency }}</td>
                        <td><b>{{ parseFloat(item.quantity * item.unit_price).toFixed(2) + ' ' + appendix.currency }}</b></td>
                    </tr>
                    <tr>
                        <td><b>TOTAL FARA TVA</b></td>
                        <td></td>
                        <td><b>{{ appendix.value + ' ' + appendix.currency }}</b></td>
                    </tr>
                    <tr>
                        <td>TVA</td>
                        <td>0 %</td>
                        <td>0.00 EUR</td>
                    </tr>
                    <tr>
                        <td><b>TOTAL</b></td>
                        <td></td>
                        <td><b>{{ appendix.value + ' ' + appendix.currency }}</b></td>
                    </tr>
                </table>
                <p class="mt-2 exchange-rate-line">CURS VALUTAR 1 {{ appendix.currency }} = {{ exchangeRateToRON }} RON</p>
            </div>
            <div class="wrapper footer-pdf">
                <div class="provider">
                    <ul>
                        <li><b>FURNIZOR</b></li>
                        <li><b>{{ appendix.provider }}</b></li>
                        <li class="mt-2">{{ this.$store.state.user.first_name + ' ' + this.$store.state.user.last_name }}</li>
                    </ul>
                </div>
                <div class="beneficiary">
                    <ul>
                        <li><b>BENEFICIAR</b></li>
                        <li><b>{{ appendix.beneficiary }}</b></li>
                        <li class="mt-2"></li>
                    </ul>
                </div>
            </div>
            <div class="page-no mt-5" style=""><p>Pagina 1/1</p></div>
        </div>
    </div>
    <ModalForm :data-source="modalDataSource" :object="appendix" @hide-modal="modalDataSource = false"/>
</template>

<script>
    import editAppendix from "./modal/blueprints/editAppendix.json"
    import addAppendixItem from "./modal/blueprints/addAppendixItem.json"
    import ModalForm from "./modal/ModalForm.vue"
    import ConfirmPopup from 'primevue/confirmpopup'

    import jsPDF from 'jspdf'

    export default {
        components : {ModalForm, ConfirmPopup},
        props: {
            appendix: Object,
            no: Number,
        },
        data() {
            return {
                items: null,
                mapUOM: {'h': 'ORE'},
                exchangeRateToRON: null,
                modalDataSource: false,
                deleteEndpoint: 'http://localhost:8000/api/deleteAppendix'
            }
        },
        computed: {
            editAppendixModal(){
                return editAppendix
            },
            addAppendixItemModal(){
                return addAppendixItem
            }
        },
        async mounted(){
            await fetch("http://localhost:8000/api/getAppendixItems/" + this.appendix.id)
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
            openModal(){
                this.addAppendixItemModalOpen = true
            },
            confirmDelete(event) {
                this.$confirm.require({
                    target: event.currentTarget,
                    icon: 'pi pi-exclamation-triangle',
                    message: 'Do you want to delete this appendix?',
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
                            },
                            body: JSON.stringify({'id': this.appendix.id})
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
                const doc = new jsPDF()
                const html = this.$refs.pdfContent.innerHTML
                var pdfTitle = this.appendix.series + this.appendix.no + ' - ' + this.appendix.beneficiary
                doc.html(html, {
                    callback: function(doc){
                        // doc.output('dataurlnewwindow', {filename: pdfTitle})
                        doc.save(pdfTitle + '.pdf')
                    },
                    y: 10,
                    width: 200,
                    windowWidth: 650
                })    
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
    .wrapper, .appendix-info-wrapper{
        display: flex;
    }

    .appendix-info{
        width:50%;
        float: left;
    }
    .appendix-highlight{
        font-family: "Times New Roman", Times, serif;
        font-size: 2rem;
        color: #dd3d24;
    }
    .appendix-code li{
        font-family: "Times New Roman", Times, serif;
        font-size: 2rem;
    }
    .appendix-date{
        font-size: 0.75rem;
        font-family: "Times New Roman", Times, serif;
    }
    .appendix-code{
        width:45%;
        float: right;
        text-align: right;
    }
    .appendix-items-wrapper{
        margin-left:5%;
    }
    .appendix-items-table{
        width: 95%;
    }
    .appendix-items-table td{
        text-align: unset !important;
        padding: 5px;
    }
    .appendix-items-table tr{
        border-bottom: 1px solid #c7c7c7 !important;
    }
    .appendix-items-table tr:first-child{
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
