<template>
    <nav class="navbar navbar-expand-lg bg-white shadow">
        <div class="container">
            <div class="d-flex">
                <span class="menu-btn d-none"><img src="imgs/menu.svg" alt="" width="30"></span>
                <img src="imgs/logo-80.png" width="45">
                <Link class="navbar-brand" href="/">فاضل فون</Link>
            </div>
            <span class="rounded "><img src="imgs/manage_accounts.svg" alt="" width="45"></span>
        </div>
    </nav>
</template>
<style>
    .navbar{
        height: 60px;
        position: fixed;
        top: 0;
        right: 0;
        width: 100%;
        z-index: 1000;
    }
</style>
<script setup>
import { Link } from "@inertiajs/vue3";
</script>