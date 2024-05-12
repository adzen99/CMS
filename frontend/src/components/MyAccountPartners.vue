<template>
    <div class="container">
            <div class="d-flex info-card">
                <h5>The list with all your partners</h5>
                <button type="button" class="btn btn-warning" @click="openModal()"><font-awesome-icon class="icon-mr-7" icon="fa-solid fa-circle-plus" />Add a new partner</button>
            </div>
            <section>
                <div class="mb-15px">
                    <span><b>{{ partnersNumber }} in total</b></span>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" /></th>
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
            <AddPartnerModal :data="addPartnerModalOpen" @hidden-modal="addPartnerModalOpen=false"/>
        </div>
</template>

<script>
    import Partner from "./Partner.vue"
    import AddPartnerModal from "./modals/AddPartnerModal.vue"
    export default {
        components : { Partner, AddPartnerModal },
       async mounted() {
            fetch("http://localhost:8000/api/getMyPartners/" + this.$store.state.user.id)
            .then(response => {
                return response.json()
            }).then(data => {
                console.log(data)
                this.partnersNumber = data.countMyPartners
                this.partners = data.myPartners
            }).catch(e => { console.log(e) })
        },
        data(){
            return {
                partners: {},
                partnersNumber: 0,
                addPartnerModalOpen: false,
            }
        },
        methods: {
            openModal(){
                if(this.addPartnerModalOpen===false) this.addPartnerModalOpen = true;
            }
        },
    }
</script>

<style scoped>
    .container{
        margin-top: 2rem;
    }
    h5{
        margin-bottom: 0 !important;
    }
    .info-card {
        padding: 12px;
        border-radius: 15px;
    }
</style>
