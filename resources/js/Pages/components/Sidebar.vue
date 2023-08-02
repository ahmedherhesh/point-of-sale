<template>
    <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-light shadow h-full" style="width: 255px">
        <ul class="nav nav-pills flex-column mb-auto">
            <li>
                <Link href="/" class="nav-link link-dark ">
                <img src="/imgs/store.svg" alt="">
                الصفحة الرئيسية
                </Link>
            </li>
            <li>
                <Link href="/pos" class="nav-link link-dark ">
                <img src="/imgs/library_add.svg" alt="">
                نقطة بيع
                </Link>
            </li>
            <li v-if="adminRoles.includes(userSession.role)">
                <Link href="/items" class="nav-link link-dark">
                <img src="/imgs/widgets.svg" alt="">
                المنتجات
                </Link>
            </li>
            <li v-if="adminRoles.includes(userSession.role)">
                <Link href="/categories" class="nav-link link-dark">
                <img src="/imgs/category.svg" alt="">
                الأقسام
                </Link>
            </li>
            <li v-if="adminRoles.includes(userSession.role)">
                <Link href="/companies" class="nav-link link-dark">
                <img src="/imgs/apartment.svg" alt="">
                الشركات
                </Link>
            </li>
            <li v-if="adminRoles.includes(userSession.role)">
                <Link href="/users" class="nav-link link-dark">
                <img src="/imgs/users.svg" alt="">
                المستخدمين
                </Link>
            </li>
            <li v-if="adminRoles.includes(userSession.role)">
                <Link href="/sales" class="nav-link link-dark">
                <img src="/imgs/handshake.svg" alt="">
                المبيعات
                </Link>
            </li>
            <li v-if="adminRoles.includes(userSession.role)">
                <Link href="/returned-items" class="nav-link link-dark">
                <img src="/imgs/assignment_return.svg" alt="">
                المرتجعات
                </Link>
            </li>
            <li v-if="adminRoles.includes(userSession.role)">
                <Link href="/not-in-stock" class="nav-link link-dark">
                <img src="/imgs/remove_done.svg" alt="">
                النواقص
                </Link>
            </li>
            <li v-if="adminRoles.includes(userSession.role)">
                <Link href="/reports" class="nav-link link-dark">
                <img src="/imgs/contract.svg" alt="">
                التقارير
                </Link>
            </li>
        </ul>
    </div>
</template>
<style>
.sidebar {
    height: 100vh;
    position: fixed;
    top: 60px;
    right: 0;
    transition: right .5s;
    z-index: 1000;
}

.sidebar  li {
    border-top: 1px solid #ccc;
    border-bottom: 1px solid #ccc;
    margin: 5px 0;
}
</style>
<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { onMounted } from "vue";
let adminRoles = ['super-admin', 'admin'];
let userSession = usePage().props.userSession;
onMounted(() => {
    document.querySelectorAll('.nav-link').forEach(link => {
        if (window.location.pathname.includes(link.getAttribute('href'))) {
            link.parentElement.classList.add('border-0')
            link.classList.add('ctm-btn')
            document.title =  'فاضل فون | ' + link.innerText 
        }
    })
})
</script>
