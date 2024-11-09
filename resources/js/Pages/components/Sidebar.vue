<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { onMounted } from "vue";
import WidgetsIcon from '../Icons/WidgetsIcon.vue';
import LibraryAddIcon from '../Icons/LibraryAddIcon.vue';
import BarcodeIcon from '../Icons/BarcodeIcon.vue';
import RemoveDoneIcon from '../Icons/RemoveDoneIcon.vue';
import CategoryIcon from '../Icons/CategoryIcon.vue';
import ApartmentIcon from '../Icons/ApartmentIcon.vue';
import UsersIcon from '../Icons/UsersIcon.vue';
import DamageItemIcon from "../Icons/DamageItemIcon.vue";
import ContractIcon from '../Icons/ContractIcon.vue';
import DebitIcon from '../Icons/DebitIcon.vue';

let props = usePage().props;
let { userSession } = props;
let { flash } = props;
let moveActiveBtn = btn => {
    btn.parentElement.classList.add('border-0')
    btn.classList.add('ctm-btn')
}

onMounted(() => {
    let navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        let href = link.getAttribute('href');
        let pathname = window.location.pathname.trim();
        if (pathname.includes(href) && href != '/') {
            moveActiveBtn(link)
        } else if (pathname == href) {
            moveActiveBtn(document.querySelector('.nav-link'))
        }
    })
})
</script>

<template>
    <div class="sidebar d-flex flex-column flex-shrink-0 bg-light shadow" style="width: 255px">
        <ul class="nav nav-pills flex-column mb-auto">
            <!-- <li>
                <Link href="/" class="nav-link link-dark ">
                <img src="/imgs/store.svg" alt="">
                الصفحة الرئيسية
                </Link>
            </li> -->
            <li v-if="$page.props.permissions.includes('اضافة المبيعات')">
                <Link href="/" class="nav-link link-dark ">
                <LibraryAddIcon />
                نقطة بيع
                </Link>
            </li>
            <li v-if="$page.props.permissions.includes('المنتجات')">
                <Link href="/items" class="nav-link link-dark">
                <WidgetsIcon />
                المنتجات
                </Link>
            </li>
            <li v-if="$page.props.permissions.includes('المنتجات التالفة')">
                <Link href="/damages" class="nav-link link-dark">
                <DamageItemIcon />
                المنتجات التالفة
                </Link>
            </li>
            <li v-if="$page.props.permissions.includes('الباركود')">
                <Link href="/barcode" class="nav-link link-dark">
                <BarcodeIcon />
                الباركود
                </Link>
            </li>
            <li v-if="$page.props.permissions.includes('المنتجات')">
                <Link href="/not-in-stock" class="nav-link link-dark">
                <RemoveDoneIcon />
                النواقص
                </Link>
            </li>
            <li v-if="$page.props.permissions.includes('الأقسام')">
                <Link href="/categories" class="nav-link link-dark">
                <CategoryIcon />
                الأقسام
                </Link>
            </li>
            <li v-if="$page.props.permissions.includes('الشركات')">
                <Link href="/companies" class="nav-link link-dark">
                <ApartmentIcon />
                الشركات
                </Link>
            </li>
            <li v-if="$page.props.permissions.includes('المستخدمين')">
                <Link href="/users" class="nav-link link-dark">
                <UsersIcon />
                المستخدمين
                </Link>
            </li>
            <li v-if="$page.props.permissions.includes('العملاء')">
                <Link href="/clients" class="nav-link link-dark">
                <UsersIcon />
                العملاء
                </Link>
            </li>
            <li v-if="$page.props.permissions.includes('المبيعات')">
                <Link href="/sales" class="nav-link link-dark">
                <ContractIcon />
                المبيعات
                </Link>
            </li>
            <li v-if="$page.props.permissions.includes('المصروفات')">
                <Link href="/expenses" class="nav-link link-dark">
                <ContractIcon />
                المصروفات
                </Link>
            </li>
            <li v-if="$page.props.permissions.includes('الأرباح الإضافية')">
                <Link href="/extra-profits" class="nav-link link-dark">
                <ContractIcon />
                الأرباح الإضافية
                </Link>
            </li>
            <li v-if="$page.props.permissions.includes('الديون')">
                <Link href="/debits" class="nav-link link-dark">
                <DebitIcon />
                الديون
                </Link>
            </li>
            <li v-if="$page.props.permissions.includes('إجمالي الأرباح')">
                <Link href="/profits" class="nav-link link-dark">
                <ContractIcon />
                إجمالي الأرباح
                </Link>
            </li>
        </ul>
    </div>
    <!-- <div class="messages">
        <div v-if="flash.success" class="alert alert-success">
            {{ flash.success }}
        </div>
        <div v-if="flash.failed" class="alert alert-danger">
            {{ flash.failed }}
        </div>
    </div> -->
</template>
<style>
.sidebar {
    height: 100vh;
    position: fixed;
    padding: 10px;
    padding-top: 65px;
    top: 0;
    right: 0;
    transition: right .5s;
    z-index: 999;
    overflow-x: hidden;
    overflow-y: scroll;
}

.sidebar li {
    border-top: 1px solid #ccc;
    border-bottom: 1px solid #ccc;
    margin: 5px 0;
}

.messages {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 3000;
}
</style>
