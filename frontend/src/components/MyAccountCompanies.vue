<template>
    <div class="container">
            <div class="d-flex info-card">
                <h5>The list with all your companies</h5>
                <button type="button" class="btn btn-warning" @click="openModalForm(addCompanyModal)"><font-awesome-icon class="icon-mr-7" icon="fa-solid fa-circle-plus" />Add a new company</button>
            </div>
            <section>
                <div class="mb-15px">
                    <span><b>{{ companiesNumber }} in total</b></span>
                </div>
            <table class="table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" /></th>
                            <th>#</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Bank</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <Company v-for="(company, k) in companies" :company="company" :key="company.key" :no="k + 1" />
                    </tbody>
                </table>
            </section>
            <ModalForm :data-source="modalDataSource" @hide-modal="modalDataSource = false"/>

            <!-- <AddCompanyModal :data="addCompanyModalOpen" @hidden-modal="addCompanyModalOpen=false"/> -->
        </div>
</template>

<script>
    import Company from "./Company.vue"
    import addCompany from "./modal/blueprints/addCompany.json"
    import ModalForm from "./modal/ModalForm.vue";
    export default {
        components : { Company, ModalForm },
        async mounted() {
            fetch("http://localhost:8000/api/getMyCompanies/" + this.$store.state.user.id)
            .then(response => {
                return response.json()
            }).then(data => {
                this.companiesNumber = data.countMyCompanies
                this.companies = data.myCompanies
            }).catch(e => { console.log(e) })
        },
        data(){
            return {
                companies: {},
                companiesNumber: 0,
                modalDataSource: false,
            }
        },
        methods: {
            openModalForm(source){
                this.modalDataSource = source;
            }
        },
        computed: {
            addCompanyModal(){
                return addCompany
            }
        }
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
