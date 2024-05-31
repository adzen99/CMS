<template>
    <tr>
        <td><input type="checkbox" /></td>
        <td>{{ no }}</td>
        <td>{{ contract.no + ' / '+ contract.date }}</td>
        <td>{{ contract.expiration_date }}</td>
        <td>{{ contract.provider }}</td>
        <td>{{ contract.beneficiary }}</td>
        <td>
            <div class="inline-spacing">
                <button type="button" class="btn btn-primary" @click="openModalForm(editContractModal)"><font-awesome-icon icon="fa-solid fa-pen-to-square" /></button>
                <button type="button" class="btn btn-danger"><font-awesome-icon icon="fa-solid fa-trash-can" /></button>
            </div>
        </td>
    </tr>
    <ModalForm :data-source="modalDataSource" :object="contract" @hide-modal="modalDataSource = false"/>
</template>
<script>
    import ModalForm from "./modal/ModalForm.vue"
    import editContract from "./modal/blueprints/editContract.json"

    export default {
        components : { ModalForm },
        props: {
            contract: Object,
            no: Number
        },
        mounted(){
        },
        data(){
            return {
                modalDataSource: false,
            }
        },
        methods: {
            openModalForm(source){
                this.modalDataSource = source;
            }
        },
        computed: {
            editContractModal(){
                return editContract
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
