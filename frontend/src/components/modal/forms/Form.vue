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
            text: FormComponents.InputText,
            number: FormComponents.InputText,
            date: FormComponents.InputText,
            select: FormComponents.SelectInput,
            // submit: FormComponents.SubmitButton
        };
    },
    watch: {
        dataSource: {
            handler(value) {
                if (typeof value == 'object') {
                    this.form = value
                    this.formLoaded = true
                } else {
                    this.form = {}
                    this.formLoaded = false
                }
            },
            immediate : true
        },
    },
    methods: {
         checkDependencies(name) {
            this.dependencies.forEach( dependency => {
                for (let dep in dependency) {
                    if (dep != name) return
                    let affected = dependency[dep]?.affected
                    if (!affected || typeof affected == undefined) return
                    if(affected){
                        affected.forEach(aff => {
                            if(aff.action){
                                let action = aff.action + '/' + this.formData[name]
                                fetch(action)
                                .then(response => {
                                    return response.json()
                                }).then(data => {
                                if(data.ok){
                                    this.setOptions(aff.name, data.options)
                                }
                                }).catch(e => { console.log(e) })
                            }
                        })
                    }                    
                }
            })
        },
        checkChanged(name){
            this.checkDependencies(name)
            return
        },
        setOptions(name, options) {
            this.formElements.forEach(e => {
                console.log(e)
                if (e.name!=name) return
                e.options = options
            })
        },
        formSubmitted() {
            if (this.isWorking) return
            console.log(this.formData)
            this.$emit('submitted')
            // this.isWorking = true
            // postJson( this.form.action, this.formData ).then((response) => {
            //     this.isWorking = false
            //     if(response.error == 0){
            //         this.$emit('submitted', { status: true, message: response.message })
            //     }else{
            //         response.errorElements.forEach((e) => {
            //             this.setErrors(e.name, e.errorMessage)
            //         })
            //     }
            // }).catch((err) => {
            //     this.isWorking = false
            //     this.$emit('submitted', { status: false, response: { errorMessage: err.message } })
            // })    
        }
    },
    computed: {
        formElements() {
            return this.form?.elements || [] 
        },
        dependencies () {
            return this.form?.dependencies || []
        },
        formData() {
            let d = {}
            this.formElements.forEach((e) => { if('value' in e) d[e.name] = e.value })
            return d
        },
    }
}
</script>