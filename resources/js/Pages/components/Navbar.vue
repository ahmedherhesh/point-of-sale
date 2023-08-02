<template>
    <nav class="navbar navbar-expand-lg bg-white shadow">
        <div class="container">
            <div class="d-flex justify-content-between w-100">
                <div>
                    <span class="menu-btn m-3"><img src="/imgs/menu.svg" alt="" width="30"></span>
                    <!-- <img src="/imgs/logo-80.png" width="45"> -->
                    <Link class="navbar-brand" href="/">فاضل فون</Link>
                </div>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <span class="rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><img src="/imgs/library_add.svg" alt="" width="45"></span>
                        <ul class="dropdown-menu">
                            <li><Link href="/users/create" class="dropdown-item text-center ">اضافة مستخدم</Link></li>
                            <li><Link href="/categories/create" class="dropdown-item text-center">اضافة قسم</Link></li>
                            <li><Link href="/companies/create" class="dropdown-item text-center">اضافة شركة</Link></li>
                            <li><Link href="/items/create" class="dropdown-item text-center">اضافة منتج</Link></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <span class="rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><img src="/imgs/manage_accounts.svg" alt="" width="45"></span>
                        <ul class="dropdown-menu">
                            <li><Link href="" class="dropdown-item text-center ">تغيير كلمة السر</Link></li>
                            <li><Link href="/logout" class="dropdown-item text-center ">تسجيل خروج</Link></li>
                        </ul>
                    </div>
                </div>
            </div>
            
        </div>
    </nav>
</template>
<style>
.navbar {
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