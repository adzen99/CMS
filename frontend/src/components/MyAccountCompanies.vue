<template>
    <div class="row m-5">
            <div class="d-flex info-card">
                <h5>The list with all your companies</h5>
                <button type="button" class="btn btn-warning" @click="openModalForm(addCompanyModal)">Add a new company</button>
            </div>
            <section>
                <div class="mb-15px">
                    <span><b>{{ companiesNumber }} in total</b></span>
                </div>
            <table class="table table-hover">
                    <thead>
                        <tr>
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
        </div>
</template>

<script>
    import Company from "./Company.vue"
    import addCompany from "./modal/blueprints/addCompany.json"
    import ModalForm from "./modal/ModalForm.vue";
    export default {
        components : { Company, ModalForm },
        async mounted() {
            // fetch("http://localhost:8000/get_my_companies/" + this.$store.state.user.id,{
            //     method: "GET"
            //     // headers:{
            //     //     'Authorization': 'Bearer ' + localStorage.getItem('jwt'),
            //     // }
            // })
            // .then(response => {
            //     return response.json()
            // }).then(data => {
            //     this.companies = data
            //     this.companiesNumber = this.companies.length
            // }).catch(e => { console.log(e) })
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