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
                this.user = this.$store.state.user
            }
        },
    }
</script>

<template>
    <div class="card mt-1rem">
        <div class="card-header"><font-awesome-icon class="icon-mr-7" icon="fa-solid fa-user" />{{ user.first_name + ' ' + user.last_name }}</div>
        <div class="card-body">
            <span class="card-link"><font-awesome-icon class="icon-mr-7" icon="fa-solid fa-envelope" />{{ user.email }}</span>
            <span class="card-link"><font-awesome-icon class="icon-mr-7" icon="fa-solid fa-square-phone" />{{ user.phone }}</span>
        </div>
    </div>
    <div class="card mt-1rem">
        <div class="card-body">
            <div class="row">
                <div class="mb-3 col-6">
                    <label for="first_name_input" class="form-label">First Name</label>
                    <input type="email" class="form-control" id="first_name_input" v-model="user.first_name">
                </div>
                <div class="mb-3 col-6">
                    <label for="last_name_input" class="form-label">Last Name</label>
                    <input type="email" class="form-control" id="last_name_input" v-model="user.last_name">
                </div>
                <div class="mb-3 col-4">
                    <label for="username_input" class="form-label">Username</label>
                    <input type="email" class="form-control" id="username_input" v-model="user.username">
                </div>
                <div class="mb-3 col-4">
                    <label for="password_input" class="form-label">Password</label>
                    <input type="email" class="form-control" id="password_input">
                </div>
                <div class="mb-3 col-4">
                    <label for="password_bis_input" class="form-label">Re-enter password</label>
                    <input type="email" class="form-control" id="password_bis_input">
                </div>
                <div class="col-6">
                    <label for="e-mail_form" class="form-label">E-mail</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon3"><b>@</b></span>
                        <input type="text" class="form-control" id="e-mail_form" aria-describedby="basic-addon3" v-model="user.email">
                    </div>
                </div>
                <div class="col-6">
                    <label for="phone_form" class="form-label">Phone</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon3"><font-awesome-icon icon="fa-solid fa-phone" /></span>
                        <input type="text" class="form-control" id="phone_form" aria-describedby="basic-addon3" v-model="user.phone">
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-center align-content-center">
                    <button type="button" class="btn btn-success"><font-awesome-icon class="icon-mr-7" icon="fa-solid fa-floppy-disk" />Save</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.d-flex{
    margin-bottom: 0 !important;
}
</style>
