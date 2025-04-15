<template>
    <div class="row m-5">
        <div class="d-flex info-card">
            <h5>{{ props.presentationText ? props.presentationText : '' }}</h5>
            <button type="button" class="btn btn-warning">{{ props.addButton.text ? props.addButton.text : ''
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
    mounted() {
        console.log(this.props)
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