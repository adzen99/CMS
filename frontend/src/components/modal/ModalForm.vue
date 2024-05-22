<template>
    <Teleport to="body">
        <div v-if="formLoaded" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" ref="modal">
            <div class="modal-dialog" :class="modalSize">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">{{ form?.title }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body"> 
                        <div v-if="form.alertDanger" class="alert alert-danger" role="alert">
                            <font-awesome-icon class="icon-mr-7" icon="fa-solid fa-circle-exclamation" />
                            {{ form?.alertDanger }}
                        </div>
                        <Form :data-source="form" @submitted="submitted" @trigger-alert-danger="triggerAlertDanger" ref="form"/>                       
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ form?.buttons?.close || 'Close' }}</button>
                        <button type="button" class="btn btn-primary" @click="this.$refs.form.formSubmitted">{{ form?.buttons?.submit || 'Save' }}</button>
                    </div>
                </div>
            </div>
        </div>
    </Teleport>
</template>
<script>
    import Form from './forms/Form.vue'
    import { nextTick } from 'vue'
    import { Modal } from 'bootstrap'

    export default {
        components: { Form },
        emits : ['hideModal'],
        props: {
            dataSource: [String, Object, Boolean] 
        }, 
        data() {
            return {
                formLoaded : false,
                form : {},
                modalIsVisible : false
            }
        },
        watch: {
            dataSource: {
                handler(value){
                    if(typeof value == 'object'){
                        this.form = value
                        this.formLoaded = true
                        this.showModal()
                    }
                    // }else{
                    //     this.form = {}
                    //     this.formLoaded = false
                    // }
                },
                immediate: true
            }
        },
        methods: {
            async showModal() {
                if (this.modalIsVisible) return
                await nextTick( () => {
                    this.bsModal = new Modal(this.$refs.modal)
                    this.bsModal.show();
                    this.$refs.modal.addEventListener('hidden.bs.modal', this.hideModal)
                    this.modalIsVisible = true
                } );                     
            },
            hideModal() {
                if (!this.modalIsVisible) return
                this.bsModal.dispose()
                this.modalIsVisible = false
                this.form = {}
                this.formLoaded = false                
                this.$emit('hideModal')
            },
            submitted(e) {
                this.hideModal()
                // if (e.status) {
                //     // this.$swal('Success', e.message ? e.message : 'Forma trimisa cu succces!', 'success')
                // } else {
                //     // this.$notify({ title: 'Error', text: 'Eroare la comunicarea cu serverul!', type: 'error' })
                // }
            }, 
            triggerAlertDanger(message){
                this.form.alertDanger = message
            }
        },
        computed: {
            modalSize(){
                return typeof this.form.modalSize =='string' && this.form.modalSize ? 'modal-' + this.form.modalSize : ''
            }
        }
    }
</script>