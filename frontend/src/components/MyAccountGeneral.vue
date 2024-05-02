<script>
    export default {
        components : {},
        data(){
            return {
                
            }
        }
    }
</script>

<template>
    <div class="card mt-1rem">
        <div class="card-header"><font-awesome-icon class="icon-mr-7" icon="fa-solid fa-user" />Vasile Parpalac</div>
        <div class="card-body">
            <span class="card-link"><font-awesome-icon class="icon-mr-7" icon="fa-solid fa-envelope" />vasileparpalac@gmail.com</span>
            <span class="card-link"><font-awesome-icon class="icon-mr-7" icon="fa-solid fa-square-phone" />0751321045</span>
        </div>
    </div>
    <div class="card mt-1rem">
        <div class="card-body">
            <div class="row">
                <div class="mb-3 col-6">
                    <label for="first_name_input" class="form-label">First Name</label>
                    <input type="email" class="form-control" id="first_name_input">
                </div>
                <div class="mb-3 col-6">
                    <label for="last_name_input" class="form-label">Last Name</label>
                    <input type="email" class="form-control" id="last_name_input">
                </div>
                <div class="mb-3 col-4">
                    <label for="username_input" class="form-label">Username</label>
                    <input type="email" class="form-control" id="username_input">
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
                        <input type="text" class="form-control" id="e-mail_form" aria-describedby="basic-addon3">
                    </div>
                </div>
                <div class="col-6">
                    <label for="phone_form" class="form-label">Phone</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon3"><font-awesome-icon icon="fa-solid fa-phone" /></span>
                        <input type="text" class="form-control" id="phone_form" aria-describedby="basic-addon3">
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
