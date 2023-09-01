<template>
    <Navbar />
    <Sidebar />
    <div class="content">
        <form @submit.prevent="updateExtraProfit" class="ctm-form mt-3">
            <h4 class="text-center mb-3">إضافة ربح إضافي</h4>
            <div class="mb-3">
                <label for="title" class="form-label">عنوان العمليه</label>
                <input type="text" class="form-control" id="title" v-model="extraProfitForm.title">
                <span v-if="errors.title" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.title }}</span>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">المبلغ</label>
                <input type="number" min="0" class="form-control" id="amount" v-model="extraProfitForm.amount">
                <span v-if="errors.amount" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.amount }}</span>
            </div>
            <button class="btn ctm-btn">إضافة</button>
        </form>
    </div>
</template>
<script setup>
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';

import { router, usePage } from '@inertiajs/vue3';
let props = usePage().props;
defineProps({ extraProfit: Object, errors: Object})

let extraProfitForm = {
    title: props.extraProfit.title,
    amount: props.extraProfit.amount,
}
const updateExtraProfit = () => {
    router.put(`/extra-profits/${props.extraProfit.id}`, extraProfitForm)
}
</script>
