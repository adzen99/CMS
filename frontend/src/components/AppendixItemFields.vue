<template>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            Appendix item no. {{ no }}
            <button type="button" class="btn btn-danger" @click="removeItem()"><font-awesome-icon icon="fa-solid fa-trash-can" /></button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="mb-3 col-5">
                    <label for="description_input" class="form-label">Description</label>
                    <input :name="'description-' + no" :value="this.item.description" type="text" class="form-control">
                </div>
                <div class="mb-3 col-1">
                    <label for="vat_percentage_input" class="form-label">VAT %</label>
                    <input :name="'vat_percentage-' + no" :value="this.item.vat_percentage" type="number" min="0" max="100" value="0" class="form-control">
                </div>
                <div class="mb-3 col-2">
                    <label for="uom_input" class="form-label">Unit of measurement</label>
                    <select :name="'uom-' + no" :value="this.item.uom" class="form-select">
                        <option value="h" selected>h</option>
                        <option value="pcs">pcs.</option>
                    </select>
                </div>
                <div class="mb-3 col-2">
                    <label for="quantity_input" class="form-label">Quantity</label>
                    <input :name="'quantity-' + no" type="number" :value="this.item.quantity" min="0" class="form-control">
                </div>
                <div class="mb-3 col-2">
                    <label for="unit_price_input" class="form-label">Unit price</label>
                    <input :name="'unit_price-' + no" type="number" :value="this.item.unit_price" min="0" class="form-control">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        emits: ['removeItem'],
        props: {
            item: Object,
            no: Number,
        },
        data() {
            return {
            }
        },
        methods: {
            removeItem() {
                this.$emit('removeItem')
            }
        }
    }
</script>

<style scoped>
    .card {
        margin-top: 1rem;
    }
</style>
