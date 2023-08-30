<template>
    <Navbar :setting="setting" />
    <Sidebar />
    <div class="content">
        <form @submit.prevent="editDamageItem" class="ctm-form mt-3">
            <h4 class="text-center mb-3">تعديل منتج تالف</h4>
            <div class="mb-3">
                <label for="code" class="form-label">كود المنتج</label>
                <input type="number" class="form-control" min="0" id="code" v-model="damageForm.code">
                <span v-if="errors.code" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.code }}</span>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">الكمية</label>
                <input type="number" class="form-control" min="0" id="stock" v-model="damageForm.stock">
                <span v-if="errors.stock" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.stock }}</span>
            </div>
            <button class="btn ctm-btn">حفظ</button>
        </form>
    </div>
</template>
<script setup>
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';
import { router,usePage } from '@inertiajs/vue3';
defineProps({ errors: Object, setting: Object });
let props = usePage().props;
let damageForm = {
    code: props.damageItem.code,
    stock: props.damageItem.stock
}
const editDamageItem = e => router.put(`/damages/${props.damageItem.id}`, damageForm);
</script>