<script>
    export default {
        data() {
            return {
                username: null,
                password: null,
            }
        },
        methods: {
            login() {
                this.$router.push("/")
            }
        }
    }
</script>

<template>
    <div class="body-container">
        <div class="container">
            <h2>Login</h2>
            <div>
                <input type="text" name="username" placeholder="Username" v-model="username">
                <input type="password" name="password" placeholder="Password" v-model="password">
                <button type="submit" value="Login" @click="login()">Login</button>
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
    background-color: #f0f0f0;
    }

    .container {
    width: 300px;
    padding: 20px;
    background-color: #fff;
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
