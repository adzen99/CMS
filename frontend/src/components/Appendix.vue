<template>
    <tr>
        <td><input type="checkbox" /></td>
        <td>{{ no }}</td>
        <td>{{ appendix.series + appendix.no }}</td>
        <td>{{ appendix.date }}</td>
        <td>{{ appendix.no_contract + ' from ' + appendix.contract_date }}</td>
        <td>{{ appendix.value + ' ' + appendix.currency }}</td>
        <td>
            <div class="inline-spacing">
                <button type="button" class="btn btn-secondary"><font-awesome-icon icon="fa-solid fa-file-pdf" /></button>
                <button type="button" class="btn btn-info" @click="openModal()"><font-awesome-icon icon="fa-solid fa-table-list" /></button>
                <button type="button" class="btn btn-primary"><font-awesome-icon icon="fa-solid fa-pen-to-square" /></button>
                <button type="button" class="btn btn-danger"><font-awesome-icon icon="fa-solid fa-trash-can" /></button>
            </div>
        </td>
    </tr>
    <AddAppendixItemModal :appendix="appendix" :data="addAppendixItemModalOpen" @hidden-modal="addAppendixItemModalOpen=false"/>
</template>

<script>
    import AddAppendixItemModal from "./modals/AddAppendixItemModal.vue"

    export default {
        components : {AddAppendixItemModal},
        props: {
            appendix: Object,
            no: Number,
        },
        data() {
            return {
                addAppendixItemModalOpen: false,
            }
        },
        mounted(){
            var date = new Date(this.appendix.date)
            this.appendix.date = date.toLocaleDateString()

            date = new Date(this.appendix.contract_date)
            this.appendix.contract_date = date.toLocaleDateString()
        },
        methods: {
            openModal(){
                this.addAppendixItemModalOpen = true
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
