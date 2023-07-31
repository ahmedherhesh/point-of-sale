<template>
    <navbar/>
    <sidebar />
    <div class="content">
        <div class="container">
            <div class="d-flex justify-content-center align-items-center mt-5">
                <h1>فاضل فون</h1>
            </div>
        </div>
    </div>
</template>
<script setup>
import Navbar from './components/NavBar.vue'
import Sidebar from './components/Sidebar.vue'
defineProps({user:Object})
</script>