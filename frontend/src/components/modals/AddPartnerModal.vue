<template>
    <Teleport to="body">
        <div v-if="form.loaded" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" ref="modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Add a partner</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="add-partner-form">
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label for="name_input" class="form-label">Name</label>
                                    <input name="name" type="text" class="form-control" id="name_input">
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="address_input" class="form-label">Address</label>
                                    <input name="address" type="text" class="form-control" id="address_input">
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="county_input" class="form-label">County</label>
                                    <select name="id_county" class="form-select" aria-label="Default select example">
                                        <option value="0" selected>Select a county</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="locality_input" class="form-label">Locality</label>
                                    <select name="id_locality" class="form-select" aria-label="Default select example">
                                        <option value="0" selected>Select a locality</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="cui_input" class="form-label">CUI</label>
                                    <input name="cui" type="text" class="form-control" id="cui_input">
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="nr_reg_input" class="form-label">Nr. reg</label>
                                    <input name="nr_reg" type="text" class="form-control" id="nr_reg_input">
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
                var form = document.getElementById('add-partner-form')
                var toSend = {}
                for ( var i = 0; i < form.elements.length; i++ ) {
                    toSend[form.elements[i].name] = form.elements[i].value;
                }
                toSend['id_user'] = this.$store.state.user.id

                console.log(form.elements)
                console.log(toSend)

                // validations

                await fetch("http://127.0.0.1:8000/api/addPartner", {
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