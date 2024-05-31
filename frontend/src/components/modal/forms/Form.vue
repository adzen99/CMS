<template>
    <form :action="form.action" :method="form.method" @submit.prevent="formSubmitted" class="row g-3" ref="form">
        <component v-for="formElement in formElements" :is="compAssoc[formElement.type]" :form-element="formElement" :options-action-params-values="optionsActionParamsValues[formElement.name]" :key="formElement.name" v-model="formElement.value" @changed="checkChanged"></component>
    </form>   
</template>

<script>
import * as FormComponents from '../form-elements'
export default {
    expose: [ 'formSubmitted'],
    emits : ['submitted', 'triggerAlertDanger'],
    props: {
        dataSource : [String, Object, Boolean],
        object: Object,
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
                    if(affected){
                        affected.forEach(aff => {
                            if(aff.action){
                                let action = aff.action
                                if(aff.actionParams){
                                    let params = this.buildParamsFromNonEmptyKeys(aff.actionParams)
                                    if(params.length){
                                        action += '/' + params.join('/')
                                    }else{
                                        action = null
                                    }
                                }else{
                                    action += '/' + this.formData[name]
                                }
                                if(action){
                                    fetch(action)
                                    .then(response => {
                                        return response.json()
                                    }).then(data => {
                                    if(data.ok){
                                        this.setOptions(aff.name, data.options)
                                    }
                                    }).catch(e => { console.log(e) })
                                }
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
        checkConstraints(name) {
            this.constraints.forEach(constraint => {
                for (let constr in constraint) {
                    if (constr != name) return
                    constraint[constr].forEach(con => {
                        if(con.no_future_date){
                            const currentDate = new Date()
                            const checkDate = new Date(this.formData[constr])
                            if(checkDate > currentDate){
                                this.setErrors(constr, con.feedback)
                            }
                        }
                    })                    
                }
            })
        },
        buildParamsFromNonEmptyKeys(keys){
            var result = []
            keys.forEach(k => {
                result.push(this.formData[k] ? this.formData[k] : 0)
            })
            return result.includes(0) ? [] : result
        },
        checkChanged(name){
            this.removeIsInvalid(name)
            this.$emit('triggerAlertDanger', '')
            this.checkConstraints(name)
            this.checkDependencies(name)
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
        setValue(name, value){
            this.formElements.forEach(e => {
                if (e.name!=name) return
                e.value = value
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
                        if(data.errors){
                            data.errors.forEach((e) => {
                                this.setErrors(e.name, e.errorMessage)
                            })
                        }
                        if(data.generalError){
                            this.$emit('triggerAlertDanger', data.generalError.alertDanger)
                            if(data.generalError.names){
                                data.generalError.names.forEach(name => {
                                    this.setIsInvalid(name)
                                })
                            }
                        }
                    }
                }).catch(e => { console.log(e); })
            }
        }
    },
    computed: {
        formElements() {
            if(this.object){
                console.log(this.object)
                this.form.elements.forEach(element => {
                    if(this.object[element.name]){
                        element.value = this.object[element.name]
                    }
                })
            }
            return this.form?.elements || [] 
        },
        dependencies() {
            return this.form?.dependencies || []
        },
        constraints () {
            return this.form?.constraints || []
        },
        optionsActionParamsValues(){
            var result = {}
            var aux = null
            this.formElements.forEach(e => {
                if(e.optionsActionParams){
                    aux = []
                    e.optionsActionParams.forEach(o => {
                        aux.push(this.formData[o])
                    })
                    result[e.name] = aux
                }
            })
            return result
        },
        formData() {
            let d = {}
            this.formElements.forEach(e => {
                if(e.name == 'id_user' && e.type == 'hidden'){ d[e.name] = this.$store.state.user.id }else
                if('value' in e){ d[e.name] = e.value }
            })
            return d
        },
    }
}
</script>