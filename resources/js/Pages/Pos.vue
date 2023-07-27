<template>
    <navbar />
    <sidebar />
    <div class="content flex justify-between">
        <div class="data">
            <div class="filter flex gap-2">
                <select data-te-select-init class="input input-indigo">
                    <option value="">الأقسام</option>
                    <option v-for="cat in categories" :value="cat.id">{{ cat.name }}</option>
                </select>
                <select data-te-select-init class="input input-indigo">
                    <option value="">الشركات</option>
                    <option v-for="company in companies" :value="company.id">{{ company.name }}</option>
                </select>
            </div>
        </div>
        <div class="cart"></div>
    </div>
</template>
<script setup>
defineProps({ items: Object, categories: Object, companies: Object })
import { Select, initTE } from "tw-elements";
initTE({ Select });
import Navbar from './components/NavBar.vue'
import Sidebar from './components/Sidebar.vue'
// Initialization for ES Users
</script>