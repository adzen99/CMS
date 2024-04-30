<script>
    export default {
    }
</script>

<template>
    <div class="sidebar">
        <ul>
            <li><a href="#"><font-awesome-icon class="icon" icon="fa-solid fa-file-invoice" />Invoices</a></li>
            <li><a href="#"><font-awesome-icon class="icon" icon="fa-solid fa-file-lines" />Annexes</a></li>
            <li><a href="#"><font-awesome-icon class="icon" icon="fa-solid fa-gears" />My account</a></li>
        </ul>
    </div>
</template>

<style scoped>
    .icon{
        margin-right: 7px;
    }
    .sidebar {
        height: 100%;
        width: 200px;
        position: fixed;
        top: 0;
        left: 0;
        background-color: #333;
        overflow-x: hidden;
        padding-top: 20px;
    }

    .sidebar ul {
        list-style-type: none;
        padding: 0;
        margin-top:20vh;
    }

    .sidebar ul li {
        padding: 10px;
    }

    .sidebar ul li a {
        display: block;
        color: white;
        text-decoration: none;
    }

    .sidebar ul li a:hover {
        background-color: #555;
    }

    .content {
        margin-left: 200px;
        padding: 20px;
    }

</style>
