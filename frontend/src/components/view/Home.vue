<script setup>
  import Topbar from "./Topbar.vue"
  import {onMounted} from "vue"
  import axios from 'axios'
  
  onMounted(async () => {
    // const data = axios.get('http://127.0.0.1:8000/api/user')
    // console.log(data)
    // user.value = {id: 1, username: 'alex.dzen', email: 'dzzenalex9@gmail.com', first_name: 'Alex', last_name: 'Dzen', phone: '0751321045'}
    // console.log(user.value)
  })  
</script>

<template>
  <div class="w-100">
    <Topbar/>
  </div>
</template>

<style scoped>
</style>
