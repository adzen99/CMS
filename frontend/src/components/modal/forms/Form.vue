<template>
    <form :action="form.action" :method="form.method" @submit.prevent="formSubmitted" class="row g-3" ref="form">
        <component v-for="formElement in formElements" :is="compAssoc[formElement.type]" :form-element="formElement" :key="formElement.name" v-model="formElement.value" @changed="checkChanged"></component>
    </form>   
</template>

<script>
import * as FormComponents from '../form-elements'
export default {
    expose: [ 'formSubmitted'],
    emits : ['submitted', 'triggerAlertDanger'],
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
        removeIsInvalid(name){
            this.removeIsInvalid(name)
        },
        checkRequired(){
            var result = false
            for(const key in this.formData){
                if(!this.formData[key]){
                    this.setIsInvalid(key)
                    if(!result){ result = true }
                }
            }
            if(result){
                this.$emit('triggerAlertDanger', 'Please fill the highlighted fields.')
            }
            return result
        },
        checkChanged(name){
            this.removeIsInvalid(name)
            this.$emit('triggerAlertDanger', '')
            this.checkDependencies(name)
            return
        },
        setOptions(name, options) {
            this.formElements.forEach(e => {
                if (e.name!=name) return
                e.options = options
            })
        },
        setIsInvalid(name) {
            this.formElements.forEach(e => {
                if (e.name!=name) return
                e.isInvalid = true
            })
        },
        setErrors(name, errorMessage){
            this.formElements.forEach(e => {
                if (e.name!=name) return
                e.isInvalid = true
                e.feedback = errorMessage
            })
        },
        removeIsInvalid(name) {
            this.formElements.forEach(e => {
                if (e.name!=name) return
                e.isInvalid = false
                e.feedback = ''
            })
        },
        async formSubmitted() {
            if (this.isWorking) return
            if(!this.checkRequired()){
                this.isWorking = true
                await fetch(this.form.action, {
                    method: this.form.method,
                    headers: {
                        "Content-Type": "application/json",
                        "Access-Control-Allow-Headers": "Origin, X-Requested-With, Content-Type, Accept",
                    },
                    body: JSON.stringify(this.formData)
                }).then(response => {
                    this.isWorking = false
                    return response.json()
                }).then(data =>{
                    if(data.ok){
                        this.$emit('submitted')
                    }else{
                        data.errors.forEach((e) => {
                            this.setErrors(e.name, e.errorMessage)
                        })
                    }
                }).catch(e => { console.log(e); })
            }
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
            this.formElements.forEach((e) => {
                if(e.name == 'id_user' && e.type == 'hidden'){ d[e.name] = this.$store.state.user.id }else
                if('value' in e){ d[e.name] = e.value }
            })
            return d
        },
    }
}
</script>