<template>
    <div :class="elementClass">
          <label v-if="formElement.label" class="form-label">{{ formElement.label }}</label>
          <div class="input-group">
            <select :class="{ 'form-select' : true, 'is-valid' : formElement.isValid, 'is-invalid': formElement.isInvalid }" :name="formElement.name" v-model="value">
                <option v-for="(opt, index) in options" :value="opt.value" :selected="opt.selected" :key="opt.value">{{ opt.text }}</option>
            </select>
            <div v-if="formElement.isValid && formElement.feedback" class="valid-feedback">{{ formElement.feedback }}</div>
            <div v-if="formElement.isInvalid && formElement.feedback" class="invalid-feedback">{{ formElement.feedback }}</div>        
          </div>
    </div>
</template>
<script>
  export default {
    emits: ['update:modelValue', 'changed'],
    props: {
      formElement: Object,
      optionsActionParamsValues: Object,
      modelValue : {
        default: ""
      }         
    },
    async mounted(){
      if(this.formElement.optionsAction){
        var params = this?.optionsActionParamsValues || []
        params = params.join('/')
        await fetch(this.formElement.optionsAction + params)
        .then(response => {
            return response.json()
        }).then(data => {
          if(data.ok){
            this.formElement.options = data.options
          }
        }).catch(e => { console.log(e) })
      }
    },
    computed: {
      value: {
        get() {
          return this.modelValue
        },
        set(value) {
          this.$emit('update:modelValue', value)
          this.$emit('changed', this.formElement.name)
        }
      },
      options(){ return this.formElement?.options || [] },
      elementClass() {
        return 'col-12' + ( typeof this.formElement.class == 'string' ? ' ' + this.formElement.class : '' )
      },
    }       
  }
</script>