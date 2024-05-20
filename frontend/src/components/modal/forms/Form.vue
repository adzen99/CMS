<template>
    <form :action="form.action" :method="form.method" @submit.prevent="formSubmitted" class="row g-3" ref="form">
        <component v-for="formElement in formElements" :is="compAssoc[formElement.type]" :form-element="formElement" :key="formElement.name" v-model="formElement.value" @changed="checkChanged"></component>
    </form>   
</template>

<script>
import * as FormComponents from '../form-elements'
export default {
    expose: [ 'formSubmitted' ],
    emits : ['submitted'],
    props: {
        dataSource : [String, Object, Boolean]
    },
    data(){
        return {
            form : {},
            isWorking : false
        }
    },
    created() {
        this.compAssoc = {
            // section: FormComponents.Section,
            text: FormComponents.InputText,
            // number: FormComponents.InputText,
            // date: FormComponents.InputText,
            // select: FormComponents.SelectElement,
            // hidden: FormComponents.InputHidden,
            // checkbox: FormComponents.InputCheckbox,
            // radio: FormComponents.InputRadio,
            // textarea: FormComponents.TextArea,
            // submit: FormComponents.SubmitButton
        };
    },
}
</script>