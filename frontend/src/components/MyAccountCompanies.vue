<script>
    import Company from "./Company.vue"

    export default {
        components : { Company },
        data(){
            return {
                companies: {},
                companiesNumber: 0,
            }
        }
    }
</script>

<template>
    <div class="container">
            <div class="d-flex info-card">
                <h5>The list with all your companies</h5>
                <button type="button" class="btn btn-warning"><font-awesome-icon class="icon-mr-7" icon="fa-solid fa-circle-plus" />Add a new company</button>
            </div>
            <section>
                <div class="mb-15px">
                    <span><b>{{ companiesNumber }} in total</b></span>
                </div>
            <table class="table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" /></th>
                            <th>No.</th>
                            <th>Date</th>
                            <th>Contract</th>
                            <th>Value</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <Company v-for="company in companies" :invoice="company" :key="company.id" />
                    </tbody>
                </table>
            </section>
        </div>
</template>

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
