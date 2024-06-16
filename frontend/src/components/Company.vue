<template>
    <ConfirmPopup></ConfirmPopup>
    <tr>
        <td>{{ no }}</td>
        <td><b>{{ company.name }}</b><br/><small>{{ 'CUI: ' + company.cui }}</small><br/><small>{{ 'Nr. reg. ' + company.nr_reg }}</small></td>
        <td>{{ company.locality + ', ' + company.county }}<br/><small>{{ company.address }}</small></td>
        <td>{{ company.bank }}<br/><small>{{ 'IBAN: ' + company.iban }}</small></td>
        <td>
            <div class="inline-spacing">
                <button type="button" class="btn btn-primary" @click="openModalForm(editCompanyModal)"><font-awesome-icon icon="fa-solid fa-pen-to-square" /></button>
                <button type="button" class="btn btn-danger" @click="confirmDelete($event)"><font-awesome-icon icon="fa-solid fa-trash-can" /></button>
            </div>
        </td>
    </tr>
    <ModalForm :data-source="modalDataSource" :object="company" @hide-modal="modalDataSource = false"/>
</template>
<script>
    import editCompany from "./modal/blueprints/editCompany.json"
    import ModalForm from "./modal/ModalForm.vue"
    import ConfirmPopup from 'primevue/confirmpopup'

    export default {
        components : { ModalForm, ConfirmPopup },
        props: {
            company: Object,
            no: Number,
        },
        data(){
            return {
                modalDataSource: false,
                deleteEndpoint: 'http://localhost:8000/api/deleteCompany'
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
                    message: 'Do you want to delete this company?',
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
                            body: JSON.stringify({'id': this.company.id})
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
            editCompanyModal(){
                return editCompany
            }
        },
    }
</script>
