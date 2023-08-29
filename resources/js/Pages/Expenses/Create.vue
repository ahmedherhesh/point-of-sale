<template>
    <Navbar :setting="setting" />
    <Sidebar />
    <div class="content">
        <form @submit.prevent="addExpense" class="ctm-form mt-3">
            <h4 class="text-center mb-3">إضافة مصروف</h4>
            <div class="mb-3">
                <label for="title" class="form-label">عنوان المصروف</label>
                <input type="text" class="form-control" id="title" v-model="expenseForm.title">
                <span v-if="errors.title" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.title }}</span>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">المبلغ</label>
                <input type="number" min="0" class="form-control" id="amount" v-model="expenseForm.amount">
                <span v-if="errors.amount" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.amount }}</span>
            </div>
            <button class="btn ctm-btn">إضافة</button>
        </form>
    </div>
</template>
<script setup>
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';
import { router } from '@inertiajs/vue3';

defineProps({errors: Object,setting:Object})

let expenseForm = {
    title: '',
    amount: '',
}
const addExpense = () => {
    router.post('/expenses', expenseForm)
    expenseForm.title = ''
    expenseForm.amount = ''
}

</script>
