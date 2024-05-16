<template>
    <Teleport to="body">
        <div v-if="form.loaded" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" ref="modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Add a contract</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="add-contract-form">
                            <div class="row">
                                <div class="mb-3 col-4">
                                    <label for="no_input" class="form-label">No.</label>
                                    <input name="no" id="no_input" type="text" class="form-control" :class="{'is-invalid': invalidFlags.no}" @input="removeInvalid('no')">
                                    <div v-if="invalidFlags.no" class="invalid-feedback"> Please choose a number.</div>
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="date_input" class="form-label">Date</label>
                                    <input name="date" type="date" class="form-control" :class="{'is-invalid': invalidFlags.date || datesFlag}" @input="removeInvalid('date')">
                                    <div v-if="invalidFlags.date" class="invalid-feedback"> Please choose a date.</div>
                                    <div v-if="datesFlag" class="invalid-feedback"> The date must be less than the expiration date.</div>
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="expiration_date_input" class="form-label">Expiration date</label>
                                    <input name="expiration_date" type="date" class="form-control" :class="{'is-invalid': invalidFlags.expiration_date || datesFlag}" @input="removeInvalid('expiration_date')">
                                    <div v-if="invalidFlags.expiration_date" class="invalid-feedback"> Please choose an expiration date.</div>
                                    <div v-if="datesFlag" class="invalid-feedback"> The expiration date must be greater than the date.</div>
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="provider_input" class="form-label">Provider</label>
                                    <select name="id_provider" class="form-select" :class="{'is-invalid': invalidFlags.id_provider}" @input="removeInvalid('id_provider')">
                                        <option value="0" selected>Select a provider</option>
                                        <option v-for="opt in optionsProvider" :value="opt.id">{{ opt.name }}</option>
                                    </select>
                                    <div v-if="invalidFlags.id_provider" class="invalid-feedback"> Please choose a provider.</div>
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="beneficiary_input" class="form-label">Beneficiary</label>
                                    <select name="id_beneficiary" class="form-select" :class="{'is-invalid': invalidFlags.id_beneficiary}" @input="removeInvalid('id_beneficiary')">
                                        <option value="0" selected>Select a beneficiary</option>
                                        <option v-for="opt in optionsBeneficiary" :value="opt.id">{{ opt.name }}</option>
                                    </select>
                                    <div v-if="invalidFlags.id_beneficiary" class="invalid-feedback"> Please choose a beneficiary.</div>
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
    import { nextTick } from 'vue'
    import { Modal } from 'bootstrap'

    export default {
        emits : ['hiddenModal'],
        props: {
            data: [String, Boolean] 
        },
        data() {
            return {
                form : { loaded: false },
                invalidFlags: {no: false, date: false, expiration_date: false, id_provider: false, id_beneficiary: false},
                datesFlag: false,
                optionsProvider: null,
                optionsBeneficiary: null
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
            removeInvalid(key){
                if(key){
                    this.invalidFlags[key] = false
                    if(['date', 'expiration_date'].includes(key)){
                        this.datesFlag = false
                    }
                }
            },
            async modalSubmit(e) {
                var form = document.getElementById('add-contract-form')
                var toSend = {}
                for ( var i = 0; i < form.elements.length; i++ ) {
                    toSend[form.elements[i].name] = form.elements[i].value;
                }

                // validations
                var flagInvalidGeneral = false
                var fields = Object.keys(toSend)
                for(var k in fields){
                    if(toSend[fields[k]] == '' || toSend[fields[k]] == 0){
                        this.invalidFlags[fields[k]] = true
                        flagInvalidGeneral = true
                    }

                    if(toSend['date'] && toSend['expiration_date']){
                        var date = new Date(toSend['date'])
                        var exp_date = new Date(toSend['expiration_date'])
                        if(exp_date.getTime() < date.getTime()){
                            this.datesFlag = true
                            flagInvalidGeneral = true
                        }
                    }
                }

                if(!flagInvalidGeneral){
                    await fetch("http://127.0.0.1:8000/api/addContract", {
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
            }
        }, 
    }
</script>