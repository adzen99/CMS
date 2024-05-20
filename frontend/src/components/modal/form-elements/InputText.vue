<template>
    <div :class="elementClass">
      <label v-if="formElement.label" class="form-label">{{ formElement.label }}</label>
      <input :name="formElement.name" :type="formElement.type" :placeholder="formElement.placeholder" :class="{ 'form-control' : true, 'is-valid' : formElement.isValid, 'is-invalid': formElement.isInvalid }" v-model="value">
      <div v-if="formElement.isValid && formElement.feedback" class="valid-feedback">{{ formElement.feedback }}</div>
      <div v-if="formElement.isInvalid && formElement.feedback" class="invalid-feedback">{{ formElement.feedback }}</div>
    </div>
  </template>
  <script>
  export default {
    emits: ['update:modelValue', 'changed'],
    props: {
        formElement: Object,
        modelValue : {
          default: ""
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
      elementClass() {
        return 'col-12' + ( typeof this.formElement.class == 'string' ? ' ' + this.formElement.class : '' )
      }
    }    
  }
  </script>