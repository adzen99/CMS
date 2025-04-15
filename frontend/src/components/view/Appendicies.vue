<template>
    <div class="row m-5">
        <div class="d-flex info-card">
            <h5>The list with the appendicies</h5>
            <button type="button" class="btn btn-warning" @click="openModalForm(addAppendixModal)">Add a new appendix</button>
        </div>
        <section>
            <div class="mb-15px">
                <span><b>{{ appendiciesNumber }} in total</b></span>
            </div>
        <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Series / No.</th>
                        <th>Date</th>
                        <th>Contract</th>
                        <th>Value</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <Appendix v-for="(appendix, k) in appendicies" :appendix="appendix" :key="appendix.id" :no="k + 1" />
                </tbody>
            </table>
        </section>
        <ModalForm :data-source="modalDataSource" @hide-modal="modalDataSource = false"/>
    </div>
</template>

<script>
    import Appendix from "../Appendix.vue"
    import addAppendix from "../modal/blueprints/addAppendix.json"
    import ModalForm from "../modal/ModalForm.vue"

    export default {
        components : {Appendix, ModalForm},
        data(){
            return {
                appendicies : {},
                appendiciesNumber : 0,
                modalDataSource: false,
            }
        },
        mounted(){
            // fetch("http://localhost:8000/api/getMyAppendicies/" + this.$store.state.user.id, {
            //     headers:{
            //         'Authorization': 'Bearer ' + localStorage.getItem('jwt'),
            //     }
            // })
            // .then(response => {
            //     return response.json()
            // }).then(data => {
            //     this.appendicies = data.myAppendicies
            //     this.appendiciesNumber = data.countMyAppendicies
            // }).catch(e => { console.log(e) })
        },
        methods: {
            openModalForm(source){
                this.modalDataSource = source;
            }
        },
        computed: {
            addAppendixModal(){
                return addAppendix
            }
        }
    }
</script>