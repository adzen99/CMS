<template>
    <div class="row m-5">
        <div class="d-flex info-card">
            <h5>{{ props.presentationText ? props.presentationText : '' }}</h5>
            <button type="button" class="btn btn-success" @click="add(modalBlueprint)"><i class="pi pi-plus-circle"></i>{{ props.addButton.text ? props.addButton.text : ''
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
        <ModalForm :data-source="modalDataSource" @hide-modal="modalDataSource = false"/>
    </div>
</template>

<script>
import ModalForm from "./modal/ModalForm.vue";
export default {
    components : {ModalForm},
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
        if(this.props.modalBlueprint){
            try{
                const module = await import(`${this.props.modalBlueprint}`);
                this.modalBlueprint = module.default;
            }catch(e){
                console.error("Failed to load modal blueprint JSON:", e);
            }
        }
    },
    data() {
        return {
            modalBlueprint: null,
            modalDataSource: false,
        }
    },
    methods: {
        add(source){
            this.modalDataSource = source;
        }
    },
    computed: {
    }
}
</script>