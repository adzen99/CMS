<template>
    <Teleport to="body">
        <div v-if="form.loaded" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" ref="modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Add an invoice</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="add-contract-form">
                            <div class="row">
                                <div class="mb-3 col-4">
                                    <label for="no_input" class="form-label">Series</label>
                                    <input name="series" type="text" class="form-control">
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="no_input" class="form-label">No.</label>
                                    <input name="no" type="text" class="form-control">
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="currency_input" class="form-label">Currency</label>
                                    <select name="currency" class="form-select">
                                        <option value="EUR">EUR</option>
                                        <option value="RON" selected>RON</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="date_input" class="form-label">Date</label>
                                    <input name="date" type="date" value="" class="form-control">
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="due_date_input" class="form-label">Due date</label>
                                    <input name="due_date" type="date" value="" class="form-control">
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="appendix_input" class="form-label">Appendix</label>
                                    <select name="id_appendix" class="form-select">
                                        <option value="0" selected>Select an appendix</option>
                                        <option v-for="opt in optionsAppendix" :value="opt.id">{{ opt.series + opt.no + ' from ' + opt.date }}</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="provider_input" class="form-label">Provider</label>
                                    <select name="id_provider" class="form-select">
                                        <option value="0" selected>Select a provider</option>
                                        <option v-for="opt in optionsProvider" :value="opt.id">{{ opt.name }}</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="beneficiary_input" class="form-label">Beneficiary</label>
                                    <select name="id_beneficiary" class="form-select">
                                        <option value="0" selected>Select a beneficiary</option>
                                        <option v-for="opt in optionsBeneficiary" :value="opt.id">{{ opt.name }}</option>
                                    </select>
                                </div>                               
                            </div>
                        </form>               
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="modalSubmit">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script>
    import { nextTick } from 'vue';
    import { Modal } from 'bootstrap';

    export default {
        emits : ['hiddenModal'],
        props: {
            data: [String, Boolean] 
        },
        data() {
            return {
                form : { loaded: false },
                optionsProvider: null,
                optionsBeneficiary: null,
                optionsAppendix: null,
            }
        },
        watch: {
            data(oldValue, newValue) {
                if(oldValue && !newValue){
                    this.getData()
                }
            }
        },
        methods: {
            onChangeAppendix(event){
                console.log(event.target.value)
            },
            async getData() {
                this.form.loaded = true

                fetch("http://localhost:8000/api/getMyCompaniesForProviders/" + this.$store.state.user.id)
                .then(response => {
                    return response.json()
                }).then(data => {
                    this.optionsProvider = data.providers
                }).catch(e => { console.log(e) })

                fetch("http://localhost:8000/api/getMyPartnersForBeneficiaries/" + this.$store.state.user.id)
                .then(response => {
                    return response.json()
                }).then(data => {
                    this.optionsBeneficiary = data.beneficiaries
                }).catch(e => { console.log(e) })

                fetch("http://localhost:8000/api/getAppendiciesForInvoices/" + this.$store.state.user.id)
                .then(response => {
                    return response.json()
                }).then(data => {
                    console.log(data)
                    this.optionsAppendix = data.appendicies
                }).catch(e => { console.log(e) })

                await nextTick( () => {
                    this.bsModal = new Modal(this.$refs.modal)
                    this.bsModal.show()
                    this.$refs.modal.addEventListener('hidden.bs.modal', this.hideModal)
                })    
            },
            hideModal() {
                this.bsModal.dispose();
                this.form = { loaded: false }
                this.$emit('hiddenModal');
            },
            async modalSubmit(e) {
                var form = document.getElementById('add-contract-form')
                var toSend = {}
                for ( var i = 0; i < form.elements.length; i++ ) {
                    toSend[form.elements[i].name] = form.elements[i].value;
                }
                console.log(form.elements)
                console.log(toSend)

                // validations

                await fetch("http://127.0.0.1:8000/api/addInvoice", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Access-Control-Allow-Headers": "Origin, X-Requested-With, Content-Type, Accept",
                    },
                    body: JSON.stringify(toSend)
                }).then(response => {
                    console.log(response)
                }).catch(e => {
                    console.log(e);
                })

                e.preventDefault();
                this.bsModal.dispose();
                this.form = { loaded: false }
                this.$emit('hiddenModal');                
            }
        }, 
    }
</script>