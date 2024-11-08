<script setup>
import { Link } from "@inertiajs/vue3";
import MenuIcon from '../Icons/MenuIcon.vue';
import LibraryAddIcon from "../Icons/LibraryAddIcon.vue";
import ManageAccountsIcon from "../Icons/ManageAccountsIcon.vue";
</script>
<template>
    <nav class="navbar navbar-expand-lg bg-light ">
        <div class="container">
            <div class="d-flex justify-content-between w-100">
                <div class="d-flex align-items-center">
                    <!-- <img src="/imgs/logo-80.png" width="45"> -->
                    <span class="menu-btn m-3">
                        <MenuIcon />
                    </span>
                </div>
                <Link class="navbar-brand" href="/">{{ $page.props.setting.title || 'POS' }}</Link>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <span class="rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <LibraryAddIcon width="45" />
                        </span>
                        <ul class="dropdown-menu">
                            <li v-if="$page.props.permissions.includes('اضافة المستخدمين')">
                                <Link href="/users/create" class="dropdown-item text-center ">اضافة مستخدم</Link>
                            </li>
                            <li v-if="$page.props.permissions.includes('اضافة الأقسام')">
                                <Link href="/categories/create" class="dropdown-item text-center">اضافة قسم</Link>
                            </li>
                            <li v-if="$page.props.permissions.includes('اضافة الشركات')">
                                <Link href="/companies/create" class="dropdown-item text-center">اضافة شركة</Link>
                            </li>
                            <li v-if="$page.props.permissions.includes('اضافة المنتجات')">
                                <Link href="/items/create" class="dropdown-item text-center">اضافة منتج</Link>
                            </li>
                            <li v-if="$page.props.permissions.includes('اضافة المنتجات التالفة')">
                                <Link href="/damages/create" class="dropdown-item text-center">اضافة منتج تالف</Link>
                            </li>
                            <li v-if="$page.props.permissions.includes('اضافة المصروفات')">
                                <Link href="/expenses/create" class="dropdown-item text-center">اضافة مصروف</Link>
                            </li>
                            <li v-if="$page.props.permissions.includes('اضافة الأرباح الإضافية')">
                                <Link href="/extra-profits/create" class="dropdown-item text-center">اضافة ربح اضافي
                                </Link>
                            </li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <span class="rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <ManageAccountsIcon width="45" />
                        </span>
                        <ul class="dropdown-menu">
                            <li v-if="$page.props.permissions.includes('إعدادات التطبيق')">
                                <Link href="/settings" class="dropdown-item text-center ">الإعدادات</Link>
                            </li>
                            <li>
                                <Link href="/change-password" class="dropdown-item text-center ">تغيير كلمة السر</Link>
                            </li>
                            <li>
                                <Link href="/logout" class="dropdown-item text-center ">تسجيل خروج</Link>
                            </li>
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

.navbar-brand {
    font-size: 1.75rem;
}

.navbar-brand:hover {
    color: var(--main-color)
}

.menu-btn {
    cursor: pointer;
}
</style>
