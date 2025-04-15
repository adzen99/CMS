<template>
    <div class="row m-5">
            <div class="d-flex info-card">
                <h5>The list with all your partners</h5>
                <button type="button" class="btn btn-warning" @click="openModalForm(addPartnerModal)">Add a new partner</button>
            </div>
            <section>
                <div class="mb-15px">
                    <span><b>{{ partnersNumber }} in total</b></span>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <Partner v-for="(partner, k) in partners" :partner="partner" :key="partner.key" :no="k + 1" />
                    </tbody>
                </table>
            </section>
            <ModalForm :data-source="modalDataSource" @hide-modal="modalDataSource = false"/>
        </div>
</template>

<script>
    import Partner from "./Partner.vue"
    import addPartner from "./modal/blueprints/addPartner.json"
    import ModalForm from "./modal/ModalForm.vue";
    export default {
        components : { Partner, ModalForm },
       async mounted() {
            // fetch("http://localhost:8000/api/getMyPartners/" + this.$store.state.user.id, {
            //     headers:{
            //         'Authorization': 'Bearer ' + localStorage.getItem('jwt'),
            //     }
            // })
            // .then(response => {
            //     return response.json()
            // }).then(data => {
            //     this.partnersNumber = data.countMyPartners
            //     this.partners = data.myPartners
            // }).catch(e => { console.log(e) })
        },
        data(){
            return {
                partners: {},
                partnersNumber: 0,
                modalDataSource: false,
            }
        },
        methods: {
            openModalForm(source){
                this.modalDataSource = source;
            }
        },
        computed: {
            addPartnerModal(){
                return addPartner
            }
        }
    }
</script>
