<template>
    <div class="row m-5">
        <div class="d-flex info-card">
            <h5>{{ props.presentationText ? props.presentationText : '' }}</h5>
            <button type="button" class="btn btn-success"><i class="pi pi-plus-circle"></i>{{ props.addButton.text ? props.addButton.text : ''
                }}</button>
        </div>
        <section>
            <div class="mb-15px">
                <span><b>{{ 0 }} in total</b></span>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th v-for="col in props.columns">{{ col }}</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </section>
    </div>
</template>

<script>

export default {
    props: {
        props: Object,
    },
    async mounted() {
        await this.$axios.get(`${this.$apiUrl}${this.props.endpoint}`, {
            headers: {
                'Content-Type': 'application/json',
            },
            params: {
                model: this.props.model,
            },
        });
    },
    data() {
        return {
        }
    },
    methods: {
    },
    computed: {
    }
}
</script>