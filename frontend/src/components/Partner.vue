<template>
    <ConfirmPopup></ConfirmPopup>
    <tr>
        <td>{{ no }}</td>
        <td><b>{{ partner.name }}</b><br/><small>{{ 'CUI: ' + partner.cui }}</small><br/><small>{{ 'Nr. reg. ' + partner.nr_reg }}</small></td>
        <td>{{ partner.locality + ', ' + partner.county }}<br/><small>{{ partner.address }}</small></td>
        <td>
            <div class="inline-spacing">
                <button type="button" class="btn btn-primary" @click="openModalForm(editPartnerModal)"></button>
                <button type="button" class="btn btn-danger" @click="confirmDelete($event)"></button>
            </div>
        </td>
    </tr>
    <ModalForm :data-source="modalDataSource" :object="partner" @hide-modal="modalDataSource = false"/>
</template>

<script>
    import editPartner from "./modal/blueprints/editPartner.json"
    import ModalForm from "./modal/ModalForm.vue"
    import ConfirmPopup from 'primevue/confirmpopup'

    export default {
        components : { ModalForm, ConfirmPopup },
        props: {
            partner: Object,
            no: Number,
        },
        data(){
            return {
                modalDataSource: false,
                deleteEndpoint: 'http://localhost:8000/api/deletePartner'
            }
        },
        methods : {
            openModalForm(source){
                this.modalDataSource = source;
            },
            confirmDelete(event) {
                this.$confirm.require({
                    target: event.currentTarget,
                    icon: 'pi pi-exclamation-triangle',
                    message: 'Do you want to delete this partner?',
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
                            body: JSON.stringify({'id': this.partner.id})
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
            editPartnerModal(){
                return editPartner
            }
        },
    }
</script>
