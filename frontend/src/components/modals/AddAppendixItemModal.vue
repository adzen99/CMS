<template>
    <Teleport to="body">
        <div v-if="form.loaded" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" ref="modal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Appendix items: <b>{{ appendix.series + appendix.no + ' from ' + appendix.date }}</b></h1>                        
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 d-flex flex-row-reverse mb-0">
                            <button type="button" class="btn btn-warning" @click="countItems++"><font-awesome-icon class="icon-mr-7" icon="fa-solid fa-circle-plus" />Add appendix item</button>
                        </div>
                        <form id="add-appendix-item-form">                            
                            <AppendixItemFields v-for="index in countItems" :key="index" :appendixItem="{}" :no="index" @remove-item="countItems--"></AppendixItemFields>
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
    import AppendixItemFields from "../AppendixItemFields.vue"

    export default {
        components : {AppendixItemFields},
        emits : ['hiddenModal'],
        props: {
            appendix: Object,
            data: Boolean 
        },
        data() {
            return {
                form : { loaded: false },
                countItems: 0,
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
                var form = document.getElementById('add-appendix-item-form')
                var toSend = []
                for ( var i = 0; i < form.elements.length; i++ ) {
                    if(form.elements[i].attributes.no){
                        console.log(form.elements[i].attributes.no.value)
                        // toSend[form.elements[i].attributes.no.value][form.elements[i].name] = form.elements[i].value;
                    }
                }
                console.log(form.elements)
                console.log(toSend)

                // validations

                // await fetch("http://127.0.0.1:8000/api/addAppendix", {
                //     method: "POST",
                //     headers: {
                //         "Content-Type": "application/json",
                //         "Access-Control-Allow-Headers": "Origin, X-Requested-With, Content-Type, Accept",
                //     },
                //     body: JSON.stringify(toSend)
                // }).then(response => {
                //     console.log(response)
                // }).catch(e => {
                //     console.log(e);
                // })

                e.preventDefault();
                this.bsModal.dispose();
                this.form = { loaded: false }
                this.$emit('hiddenModal');                
            }
        }, 
    }
</script>