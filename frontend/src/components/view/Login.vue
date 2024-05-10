<script>

    export default {
        data() {
            return {
                username: null,
                password: null,
            }
        },
        methods: {
            async handleLogin() {
                // await this.axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie').then(() =>{
                //     this.axios.post('http://127.0.0.1:8000/login',{
                //             username: this.username,
                //             password: this.password,
                //         })
                //         .then((response) => {
                //             console.log(response);
                //         })
                //         .catch((err) => {
                //             console.log(err.response.data);
                //         })
                // })
                this.$router.push("/")
            },
            async handleLogout() {
                await this.axios.post('http://127.0.0.1:8000/logout',{
                    username: this.username,
                    password: this.password,
                })
                .then((response) => {
                    console.log(response);
                })
                .catch((err) => {
                    console.log(err.response.data);
                })

                // this.$router.push("/")
            }
        },
    }
</script>

<template>
    <div class="body-container">
        <div class="container">
            <h2><font-awesome-icon icon="fa-solid fa-right-to-bracket" /></h2>
            <div>
                <div class="mb-3 col-12">
                    <label for="username_input" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username_input" v-model.trim="username">
                </div>
                <div class="mb-3 col-12">
                    <label for="password_input" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password_input" v-model.trim="password">
                </div>
                <div class="col-12 d-flex justify-content-center align-content-center">
                    <button type="button" class="btn btn-success"  @click="handleLogin()">Log In</button>
                    <button type="button" class="btn btn-warning"  @click="handleLogout()">Log out</button>

                </div>
            </div>
        </div>
    </div>
</template>

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

    input[type="text"],
    input[type="password"],
    button[type="submit"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
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
