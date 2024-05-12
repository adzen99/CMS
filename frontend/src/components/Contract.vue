<script>
    export default {
        mounted(){
            var date = new Date(this.contract.date)
            this.contract.date = date.toLocaleDateString()

            date = new Date(this.contract.expiration_date)
            this.contract.expiration_date = date.toLocaleDateString()
        },
        props: {
            contract: Object,
            no: Number
        },
    }
</script>

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
                <button type="button" class="btn btn-primary"><font-awesome-icon icon="fa-solid fa-pen-to-square" /></button>
                <button type="button" class="btn btn-danger"><font-awesome-icon icon="fa-solid fa-trash-can" /></button>
            </div>
        </td>
    </tr>
</template>

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
