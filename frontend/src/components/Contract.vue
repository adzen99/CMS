<template>
    <ConfirmPopup></ConfirmPopup>
    <tr>
        <td>{{ no }}</td>
        <td>{{ contract.no + ' / '+ contract.date }}</td>
        <td>{{ contract.expiration_date }}</td>
        <td>{{ contract.provider }}</td>
        <td>{{ contract.beneficiary }}</td>
        <td>
            <div class="inline-spacing">
                <button type="button" class="btn btn-primary" @click="openModalForm(editContractModal)"></button>
                <button type="button" class="btn btn-danger" @click="confirmDelete($event)"></button>
            </div>
        </td>
    </tr>
    <ModalForm :data-source="modalDataSource" :object="contract" @hide-modal="modalDataSource = false"/>
</template>
<script>
    import ModalForm from "./modal/ModalForm.vue"
    import editContract from "./modal/blueprints/editContract.json"
    import ConfirmPopup from 'primevue/confirmpopup'

    export default {
        components : { ModalForm, ConfirmPopup },
        props: {
            contract: Object,
            no: Number
        },
        mounted(){
        },
        data(){
            return {
                modalDataSource: false,
                deleteEndpoint: 'http://localhost:8000/api/deleteContract'
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
                    message: 'Do you want to delete this contract?',
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
                            body: JSON.stringify({'id': this.contract.id})
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
            editContractModal(){
                return editContract
            }
        }
    }
</script>
