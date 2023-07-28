<template>
    <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-light shadow h-full" style="width: 255px">
        <ul class="nav nav-pills flex-column mb-auto">
            <li >
                <Link href="#" class="nav-link ctm-btn" aria-current="page">
                    الصفحة الرئيسية
                </Link>
            </li>
            <li>
                <Link href="pos" class="nav-link link-dark ">
                    نقطة بيع
                </Link>
            </li>
            <li>
                <Link href="#" class="nav-link link-dark">
                    المنتجات
                </Link>
            </li>
        </ul>
    </div>
</template>
<style>
    .sidebar{
        height: 100vh;
        position: fixed;
        top:60px;
        right:0;
        transition: right .5s;
        z-index: 1000;
    }
</style>
<script setup>
import { Link } from "@inertiajs/vue3";
</script>
