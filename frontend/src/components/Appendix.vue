<template>
    <ConfirmPopup></ConfirmPopup>
    <tr>
        <td><input type="checkbox" /></td>
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
    <AddAppendixItemModal :appendix="appendix" :data="addAppendixItemModalOpen" @hidden-modal="addAppendixItemModalOpen=false"/>
    <ModalForm :data-source="modalDataSource" :object="appendix" @hide-modal="modalDataSource = false"/>

</template>

<script>
    import AddAppendixItemModal from "./modals/AddAppendixItemModal.vue"
    import editAppendix from "./modal/blueprints/editAppendix.json"
    import addAppendixItem from "./modal/blueprints/addAppendixItem.json"
    import ModalForm from "./modal/ModalForm.vue"
    import ConfirmPopup from 'primevue/confirmpopup'

    import jsPDF from 'jspdf'

    export default {
        components : {AddAppendixItemModal, ModalForm, ConfirmPopup},
        props: {
            appendix: Object,
            no: Number,
            pdfFlag: false,
        },
        data() {
            return {
                addAppendixItemModalOpen: false,
                items: null,
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
                                this.$toast.add({ severity: 'success', summary: 'Succes!', detail: data.message, life: 10000, closable: true });
                            }else{
                                this.$toast.add({ severity: 'error', summary: 'Attention!', detail: data.toastErrorMessage, life: 10000, closable: true });
                            }
                        }).catch(e => { console.log(e); })
                    }
                });
            },
            async generatePDF(){
                fetch("http://localhost:8000/api/getAppendixItems/" + this.appendix.id)
                .then(response => {
                    return response.json()
                }).then(data => {
                    var items = data.items
                    var pdf = new jsPDF({
                        format: "a4"
                    });
                    var width = pdf.internal.pageSize.getWidth()

                    var lineSpacing = 5
                    var x = 10
                    var y = 10
                    pdf.setFontSize(10);
                    pdf.text('Furnizor', x, y)
                    y += lineSpacing
                    pdf.setFontSize(12); pdf.setFont(undefined, 'bold');
                    pdf.text(this.appendix.provider, x, y)
                    pdf.setFont(undefined, 'normal');
                    y += lineSpacing
                    pdf.setFontSize(10);
                    pdf.text(this.appendix.provider_address, x, y)
                    y += lineSpacing
                    pdf.text(this.appendix.provider_locality + ', ' + this.appendix.provider_county, x, y)
                    y += lineSpacing + 3
                    pdf.text('CUI: ' + this.appendix.provider_cui, x, y)
                    y += lineSpacing
                    pdf.text(this.appendix.provider_nr_reg, x, y)
                    y += lineSpacing
                    pdf.text(this.appendix.provider_bank, x, y)
                    y += lineSpacing
                    pdf.text(this.appendix.iban, x, y)

                    var maxY = y

                    x = width / 2 + 20
                    y = 10
                    pdf.text('Beneficiar', x, y)
                    y += lineSpacing
                    pdf.setFontSize(12); pdf.setFont(undefined, 'bold');
                    pdf.text(this.appendix.beneficiary, x, y)
                    pdf.setFont(undefined, 'normal');
                    y += lineSpacing
                    pdf.setFontSize(10);
                    pdf.text(this.appendix.beneficiary_address, x, y)
                    y += lineSpacing
                    pdf.text(this.appendix.beneficiary_locality + ', ' + this.appendix.beneficiary_county, x, y)
                    y += lineSpacing + 3
                    pdf.text('CUI: ' + this.appendix.beneficiary_cui, x, y)
                    y += lineSpacing
                    pdf.text(this.appendix.beneficiary_nr_reg, x, y)

                    pdf.setFontSize(30);
                    y = maxY
                    x = 10
                    y += 30
                    pdf.setTextColor(221,61,36);
                    pdf.text('ANEXA', x, y)
                    pdf.setTextColor(0,0,0);
                    pdf.text(this.appendix.series + this.appendix.no, width / 2 + 80, y)


                    pdf.setFontSize(12);
                    y += lineSpacing
                    pdf.text('DATA: ' + this.appendix.date, x, y)
                    pdf.setFontSize(10);
                    y += lineSpacing
                    pdf.text('LA CONTRACTUL NR. ' + this.appendix.no_contract + ' DIN ' + this.appendix.contract_date, x, y)

                    y += 15
                    var mapUOM = {'h': 'ORE'}
                    var total = 0
                    pdf.setDrawColor(161,161,161);
                    items.forEach(item => {
                        y += 5
                        pdf.line(x, y, width - 10, y)
                        y += 5
                        pdf.setFont(undefined, 'bold')
                        pdf.text(item.description, x, y)
                        pdf.setFont(undefined, 'normal')
                        x = width / 2
                        pdf.text(item.quantity + ' ' + mapUOM[item.uom] + ' X ' + item.unit_price + ' ' + this.appendix.currency, x, y)

                        pdf.setFont(undefined, 'bold')
                        x = width / 2 + 75
                        pdf.text(parseFloat(item.quantity * item.unit_price).toFixed(2) + ' ' + this.appendix.currency, x, y)
                        total += (item.quantity * item.unit_price)
                        pdf.setFont(undefined, 'normal')
                        x = 10
                    })

                    console.log(total)

                    pdf.setFont(undefined, 'bold')
                    y += 5
                    pdf.line(x, y, width - 10, y)
                    y += 5
                    pdf.text('TOTAL FARA TVA', x, y)
                    x = width / 2 + 75
                    pdf.text(parseFloat(total).toFixed(2) + ' ' + this.appendix.currency, x, y)

                    x = 10
                    pdf.setFont(undefined, 'normal')
                    y += 5
                    pdf.line(x, y, width - 10, y)
                    y += 5
                    pdf.text('TVA', x, y)
                    x = width / 2
                    pdf.text(this.appendix.vat_percentage + '%', x, y)
                    x = width / 2 + 75
                    pdf.text(this.appendix.vat + ' ' + this.appendix.currency, x, y)

                    x=10
                    pdf.setFont(undefined, 'bold')
                    y += 5
                    pdf.line(x, y, width - 10, y)
                    y += 5
                    pdf.text('TOTAL', x, y)
                    x = width / 2 + 75
                    pdf.text(parseFloat(this.appendix.value + this.appendix.vat).toFixed(2) + ' ' + this.appendix.currency, x, y)

                    x = 10
                    y += 100

                    pdf.text('Furnizor', x, y); pdf.text('Beneficiar', width/2 + 20, y); 
                    y += lineSpacing
                    pdf.text(this.appendix.provider, x, y); pdf.text(this.appendix.beneficiary, width/2 + 20, y);
                    y += lineSpacing + 3

                    pdf.setFont(undefined, 'normal')
                    x = 10
                    pdf.text(this.appendix.user_first_name + ' ' + this.appendix.user_last_name, x, y); pdf.text('---', width/2 + 20, y);

                    pdf.output('dataurlnewwindow', {filename: 'test'})
                }).catch(e => { console.log(e) })
            }
        }
    }
</script>

<style scoped>
    .inline-spacing {
        display: flex;
        gap:5px;
        justify-content: center;
    }
    td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    @media screen and (max-width: 600px) {
        tr {
            border-bottom: 2px solid #ddd;
            display: block;
            margin-bottom: 10px;
        }

        td {
            border-bottom: none;
            display: block;
            text-align: right;
        }

        td:before {
            content: attr(data-label);
            float: left;
            font-weight: bold;
        }
    }
</style>
