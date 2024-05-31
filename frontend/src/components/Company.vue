<template>
    <!-- <Toast /> -->
    <ConfirmPopup></ConfirmPopup>
    <tr>
        <td><input type="checkbox" /></td>
        <td>{{ no }}</td>
        <td><b>{{ company.name }}</b><br/><small>{{ 'CUI: ' + company.cui }}</small><br/><small>{{ 'Nr. reg. ' + company.nr_reg }}</small></td>
        <td>{{ company.locality + ', ' + company.county }}<br/><small>{{ company.address }}</small></td>
        <td>{{ company.bank }}<br/><small>{{ 'IBAN: ' + company.iban }}</small></td>
        <td>
            <div class="inline-spacing">
                <button type="button" class="btn btn-primary" @click="openModalForm(editCompanyModal)"><font-awesome-icon icon="fa-solid fa-pen-to-square" /></button>
                <button type="button" @click="confirmDelete($event)" class="btn btn-danger"><font-awesome-icon icon="fa-solid fa-trash-can" /></button>
            </div>
        </td>
    </tr>
    <ModalForm :data-source="modalDataSource" :object="company" @hide-modal="modalDataSource = false"/>
</template>
<script>
    import editCompany from "./modal/blueprints/editCompany.json"
    import ModalForm from "./modal/ModalForm.vue"
    import ConfirmPopup from 'primevue/confirmpopup'
    import Toast from 'primevue/toast'

    export default {
        components : { ModalForm, Toast, ConfirmPopup },
        props: {
            company: Object,
            no: Number,
        },
        data(){
            return {
                modalDataSource: false,
            }
        },
        methods: {
            openModalForm(source){
                this.modalDataSource = source;
            },
            confirmDelete(event) {
                console.log(event.currentTarget)
                this.$confirm.require({
                    target: event.currentTarget,
                    icon: 'pi pi-exclamation-triangle',
                    message: 'Do you want to delete this company?',
                    rejectClass: 'btn btn-info',
                    acceptClass: 'btn btn-danger',
                    rejectLabel: 'Cancel',
                    acceptLabel: 'Delete',
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
