<template>
    <navbar />
    <sidebar />
    <div class="content d-flex justify-content-center align-items-center">
        <img class="home-logo" src="/imgs/home-logo.jpg" alt="">
    </div>
</template>
<style>
.content{
    height: 90vh;
}
.home-logo{
    min-width:300px;
    max-width:700px;
    border-radius: 50px;
    box-shadow: var(--box-shadow);
}
</style>
<script setup>
import Navbar from './components/Navbar.vue';
import Sidebar from './components/Sidebar.vue';
</script>