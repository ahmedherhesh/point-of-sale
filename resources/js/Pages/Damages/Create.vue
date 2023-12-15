<template>
    <Navbar :setting="setting" />
    <Sidebar />
    <div class="content">
        <form @submit.prevent="addDamageItem" class="ctm-form mt-3">
            <h4 class="text-center mb-3">اضافة منتج تالف</h4>
            <div class="mb-3">
                <label for="code" class="form-label">كود المنتج</label>
                <input type="number" class="form-control" min="0" id="code" v-model="damageForm.code" @input="getTitle">
                <span v-if="itemTitle" class="text-success text-direction-rtl mt-1 mb-1">{{ itemTitle }}</span>
                <span v-if="errors.code" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.code }}</span>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">الكمية</label>
                <input type="number" class="form-control" min="0" id="stock" v-model="damageForm.stock">
                <span v-if="errors.stock" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.stock }}</span>
            </div>
            <button class="btn ctm-btn">إضافة</button>
        </form>
    </div>
</template>
<script setup>
import axios from 'axios';
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
defineProps({ errors: Object, setting: Object });
let damageForm = {
    code: null,
    stock: null
}
let itemTitle = ref('');

const getTitle = () => {
    if (damageForm.code)
        axios.get(`/item/${damageForm.code}`).then(res => {
            itemTitle.value = res.data.title;
        })
}
const addDamageItem = () => {
    router.post('/damages', damageForm)
    for (let key in damageForm)
        damageForm[key] = null
}
</script>