<template>
    <form :action="`${this.$apiUrl}${this.form.endpoint}`" :method="form.method" @submit.prevent="formSubmitted" class="row g-3" ref="form">
        <template v-if="!form.getItemsAction">
            <component 
                v-for="formElement in formElements" 
                :is="compAssoc[formElement.type]" 
                :form-element="formElement" 
                :options-action-params-values="optionsActionParamsValues[formElement.name]" 
                @fill-other-fields="fillOtherFields"
                :key="formElement.name" 
                v-model="formElement.value" 
                @changed="checkChanged"
            />
        </template>
        <template v-else="form.getItemsAction && form.itemTemplate && this.form.elements">
            <div class="col-12 d-flex flex-row-reverse mb-0">
                <button type="button" class="btn btn-warning" @click="addItemTemplate()"></button>
            </div>
            <div v-for="(elements, idx) in this.form.elements" class="card">
                <div class="card-header d-flex justify-content-between">
                    No. {{ idx + 1 }}
                    <button type="button" class="btn btn-danger" @click="removeItem(idx)"></button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <component 
                            v-for="elem in elements" 
                            :is="compAssoc[elem.type]" 
                            :form-element="elem" 
                            :options-action-params-values="optionsActionParamsValues[elem.name]" 
                            @fill-other-fields="fillOtherFields"
                            :key="elem.name" 
                            v-model="elem.value" 
                            @changed="checkChanged"
                        />
                    </div>
                </div>
            </div>
        </template>
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
            isWorking : false,
        }
    },
    created() {
        this.compAssoc = {
            text: FormComponents.InputText,
            number: FormComponents.InputText,
            date: FormComponents.InputText,
            select: FormComponents.SelectInput,
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
                if(this.form.getItemsAction && this.form.itemTemplate){
                    var params = []
                    if(this.form.getItemsAction.paramsValues){
                        this.form.getItemsAction.paramsValues.forEach(e => {
                            if(this.object[e]){
                                params.push(this.object[e])
                            }
                        })
                    }
                    params = params.join('/')
                    fetch("http://localhost:8000/api/getAppendixItems/" + params, {
                        headers:{
                            'Authorization': 'Bearer ' + localStorage.getItem('jwt'),
                        }
                    })
                    .then(response => {
                        return response.json()
                    }).then(data => {
                        if(data.ok){
                            var elements = []
                            for(let index in data.items){
                                let copyTemplate = JSON.parse(JSON.stringify(this.form.itemTemplate))
                                copyTemplate.forEach(item => {
                                    item.value = data.items[index][item.name]
                                    item.name = item.name + '-' + index
                                })
                                elements.push(copyTemplate)
                            }
                            if(elements){
                                this.form.elements = elements
                            }
                        }
                    }).catch(e => { console.log(e) })
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
                                    fetch(action, {
                                        headers:{
                                            'Authorization': 'Bearer ' + localStorage.getItem('jwt'),
                                        }
                                    })
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
                if(this.formData[key] === ''){
                    this.setIsInvalid(key)
                    if(!result){ result = true }
                }
            }
            if(result){
                this.$emit('triggerAlertDanger', 'Completati campurile evidentiate.')
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
        checkFillOtherFields(name) {
            this.formElements.forEach(element => {
                if(element.name != name) return
                if(element.fillOtherFields){
                    if(element.fillOtherFields[element.value]){
                        for(const key in element.fillOtherFields[element.value]){
                            this.setValue(key, element.value ? element.fillOtherFields[element.value][key] : 0)
                        }
                    }
                }
            })
        },
        fillOtherFields(params, name){
            this.setfillOtherFields(name, params)
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
            this.checkFillOtherFields(name)
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
        setfillOtherFields(name, value){
            this.formElements.forEach(e => {
                if (e.name!=name) return
                e['fillOtherFields'] = value
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
                await fetch(`${this.$apiUrl}${this.form.endpoint}`, {
                    method: this.form.method,
                    headers: {
                        "Content-Type": "application/json",
                        "Access-Control-Allow-Headers": "Origin, X-Requested-With, Content-Type, Accept",
                        'Authorization': 'Bearer ' + localStorage.getItem('jwt'),
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
        },
        addItemTemplate(){
            var toAdd = JSON.parse(JSON.stringify(this.form.itemTemplate))
            toAdd.forEach(elem => {
                elem.name += '-' + this.form.elements.length
            })
            this.form.elements.push(toAdd)
        },
        removeItem(index){
            this.form.elements.splice(index, 1)
        }
    },
    computed: {
        formElements() {
            if(this.object){
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
            if(this.form.getItemsAction && this.form.itemTemplate){
                this.formElements.forEach(e => {
                    e.forEach(elem =>{
                        if('value' in elem){ d[elem.name] = elem.value }
                    })
                })
                if(this.object){
                    d['id'] = this.object.id
                }
            }else{
                this.formElements.forEach(e => {
                    // if(e.name == 'id_user' && e.type == 'hidden'){ d[e.name] = this.$store.state.user.id }else
                    if('value' in e){ d[e.name] = e.value }
                })
            }
            return d
        },
    }
}
</script>