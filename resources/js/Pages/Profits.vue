<template>
    <navbar/>
    <sidebar />
    <div class="content">

    </div>
</template>
<script setup>
import Navbar from './components/NavBar.vue'
import Sidebar from './components/Sidebar.vue'
defineProps({user:Object})
</script>