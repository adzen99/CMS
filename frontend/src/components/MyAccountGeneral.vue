<script>
    export default {
        mounted(){
            this.setLoggedUser()
        },
        data(){
            return {
                user: {},
            }
        },
        methods: {
            setLoggedUser(){
            },
            async saveData(){
                // var form = document.getElementById('user-info-form')
                // var toSend = {}
                // for ( var i = 0; i < form.elements.length; i++ ) {
                //     if(form.elements[i].name){
                //         toSend[form.elements[i].name] = form.elements[i].value;
                //     }
                // }
                // toSend['id_user'] = this.$store.state.user.id

                // await fetch("http://127.0.0.1:8000/api/setUserInfo", {
                //     method: "PUT",
                //     headers: {
                //         "Content-Type": "application/json",
                //         "Access-Control-Allow-Headers": "Origin, X-Requested-With, Content-Type, Accept",
                //         'Authorization': 'Bearer ' + localStorage.getItem('jwt'),
                //     },
                //     body: JSON.stringify(toSend)
                // }).then(response => {
                // }).catch(e => {
                //     console.log(e);
                // })
            }
        },
    }
</script>

<template>
    <div class="card mt-1rem">
        <div class="card-header">{{ user.first_name + ' ' + user.last_name }}</div>
        <div class="card-body">
            <span class="card-link">{{ user.email }}</span>
            <span class="card-link">{{ user.phone }}</span>
        </div>
    </div>
    <div class="card mt-1rem">
        <div class="card-body">
                <form id="user-info-form">
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="first_name_input" class="form-label">First Name</label>
                            <input name="first_name" type="text" class="form-control" id="first_name_input" v-model="user.first_name">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="last_name_input" class="form-label">Last Name</label>
                            <input name="last_name" type="text" class="form-control" id="last_name_input" v-model="user.last_name">
                        </div>
                        <div class="mb-3 col-4">
                            <label for="username_input" class="form-label">Username</label>
                            <input name="username" type="text" class="form-control" id="username_input" v-model="user.username">
                        </div>
                        <div class="mb-3 col-4">
                            <label for="password_input" class="form-label">Password</label>
                            <input name="password" type="password" class="form-control" id="password_input">
                        </div>
                        <div class="mb-3 col-4">
                            <label for="password_bis_input" class="form-label">Re-enter password</label>
                            <input type="password" class="form-control" id="password_bis_input">
                        </div>
                        <div class="col-6">
                            <label for="e-mail_form" class="form-label">E-mail</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon3"><b>@</b></span>
                                <input name="email" type="email" class="form-control" id="e-mail_form" aria-describedby="basic-addon3" v-model="user.email">
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="phone_form" class="form-label">Phone</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon3"></span>
                                <input name="phone" type="text" class="form-control" id="phone_form" aria-describedby="basic-addon3" v-model="user.phone">
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-center align-content-center">
                            <button type="button" class="btn btn-success" @click="saveData">Save</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</template>

<style scoped>
.d-flex{
    margin-bottom: 0 !important;
}
</style>
