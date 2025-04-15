<template>
    <div class="body-container">
        <div class="container">
            <h2></h2>
            <div>
                <div class="col-12 mb-3">
                    <label class="form-label">Username</label>
                    <div class="input-group">
                        <input type="text" :class="{ 'form-control' : true, 'is-invalid': invalid }" v-model.trim="username">
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" :class="{ 'form-control' : true, 'is-invalid': invalid }" v-model.trim="password">
                    </div>
                </div>

                <div class="col-12 d-flex justify-content-center align-content-center mt-3">
                    <button type="button" class="btn btn-success" @click="handleLogin()">Log In</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                username: null,
                password: null,
                invalid: false,
            }
        },
        methods: {
            async handleLogin() {       
                // this.invalid = false 
                // await fetch("http://127.0.0.1:8000/api/login", {
                //     method: "POST",
                //     headers: {
                //         'Content-Type': 'application/json',
                //         "Access-Control-Allow-Credentials": true,
                //     },
                //     credentials: 'include',
                //     body: JSON.stringify({'username': this.username, 'password': this.password})
                // }).then(response => {
                //     if(response.status == 401){
                //         this.invalid = true
                //         this.$toast.add({ severity: 'error', summary: 'Failed!', detail: 'Invalid credentials!', life: 5000, closable: true })
                //     }else if(response.status == 200){
                //         this.$router.push("/")
                //         this.$toast.add({ severity: 'success', summary: 'Succes!', detail: 'Login cu succes!', life: 5000, closable: true })
                //         return response.json();
                //     }
                // }).then(data => {
                //     if(data.token){
                //         localStorage.setItem('jwt', data.token)
                //         fetch("http://localhost:8000/api/authUser/",
                //             {
                //                 method: 'GET', 
                //                 headers: {
                //                     'Accept': 'application/json',
                //                     'Content-Type': 'application/json',
                //                     "Access-Control-Allow-Credentials": true,
                //                     'Authorization': 'Bearer ' + data.token,
                //                 },
                //         }).then(response => {
                //             return response.json()
                //         }).then(data => {
                //             console.log(data)
                //             this.$store.state.user = data

                //         }).catch(e => { console.log(e) })
                //     }
                // }).catch(e => { console.log(e) })
            },
        },
    }
</script>

<style scoped>
    .body-container {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    /* background-color: #f0f0f0; */
    width:100%;
    }

    .container {
    width: 300px;
    padding: 20px;
    /* background-color: #fff; */
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
    text-align: center;
    }

    button[type="submit"] {
    background-color: #4caf50;
    color: #fff;
    cursor: pointer;
    }

    button[type="submit"]:hover {
    background-color: #45a049;
    }

    @media screen and (max-width: 400px) {
    .container {
        width: 90%;
    }
    }
</style>
