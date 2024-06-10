<template>
    <ConfirmPopup></ConfirmPopup>
    <tr>
        <td>{{ no }}</td>
        <td>{{ invoice.series + invoice.no }}</td>
        <td>{{ (new Date(invoice.date)).toLocaleDateString() }}</td>
        <td>{{ invoice.value + ' ' + invoice.currency }}</td>
        <td>
            <div class="inline-spacing">
                <button type="button" class="btn btn-secondary"><font-awesome-icon icon="fa-solid fa-file-pdf" /></button>
                <button type="button" class="btn btn-primary" @click="openModalForm(editInvoiceModal)"><font-awesome-icon icon="fa-solid fa-pen-to-square" /></button>
                <button type="button" class="btn btn-danger" @click="confirmDelete($event)"><font-awesome-icon icon="fa-solid fa-trash-can" /></button>
            </div>
        </td>
    </tr>
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
                modalDataSource: false,
                deleteEndpoint: 'http://localhost:8000/api/deleteInvoice'
            }
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
        },
        computed: {
            editInvoiceModal(){
                return editInvoice
            }
        }
    }
</script>
