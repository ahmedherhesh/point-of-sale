<template>
    <navbar />
    <sidebar />
    <div class="content p-0 rounded-0 d-flex justify-content-center align-items-center">
        <img class="home-logo" src="/imgs/home-logo.jpg" alt="">
    </div>
</template>
<style>

.home-logo {
    height: 100vh;
    object-fit: cover;
    border-radius: 0;
    position: fixed;
    top: 60px;
}
.bg-black{
    background-color: #000;
}
</style>
<script setup>
import Navbar from './components/Navbar.vue';
import Sidebar from './components/Sidebar.vue';
</script>