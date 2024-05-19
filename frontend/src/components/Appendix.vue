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
                <button type="button" class="btn btn-secondary" @click="generatePDF()"><font-awesome-icon icon="fa-solid fa-file-pdf" /></button>
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
    import jsPDF from 'jspdf'

    export default {
        components : {AddAppendixItemModal},
        props: {
            appendix: Object,
            no: Number,
            pdfFlag: false,
        },
        data() {
            return {
                addAppendixItemModalOpen: false,
                items: null,
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
            },
            async generatePDF(){
                fetch("http://localhost:8000/api/getAppendixItems/" + this.appendix.id)
                .then(response => {
                    return response.json()
                }).then(data => {
                    var items = data.items
                    console.log(items)
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
