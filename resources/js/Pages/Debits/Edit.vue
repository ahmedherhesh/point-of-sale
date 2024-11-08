<template>
    <Navbar />
    <Sidebar />
    <div class="content">
        <form @submit.prevent="submit" class="ctm-form mt-3">
            <h4 class="text-center mb-3">تعديل دين</h4>
            <div class="mb-3">
                <label for="name" class="form-label">اسم الشخص</label>
                <input type="text" class="form-control" id="name" v-model="form.name">
                <span v-if="errors.name" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.name }}</span>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">رقم المحمول</label>
                <input type="text" class="form-control" id="phone" v-model="form.phone">
                <span v-if="errors.phone" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.phone }}</span>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">نوع الدين</label>
                <select name="type" class="form-control" id="type" v-model="form.type">
                    <option value="debit">دين</option>
                    <option value="credit">مدين</option>
                </select>
                <span v-if="errors.type" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.type }}</span>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">المبلغ</label>
                <input type="number" min="0" class="form-control" id="amount" v-model="form.amount">
                <span v-if="errors.amount" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.amount }}</span>
            </div>
            <div class="mb-3">
                <label for="notes" class="form-label">ملاحظات</label>
                <textarea class="form-control" id="notes" v-model="form.notes"></textarea>
                <span v-if="errors.notes" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.notes }}</span>
            </div>
            <button class="btn ctm-btn">
                <span>حفظ</span>
                <Loading v-if="form.processing" />
            </button>
        </form>
    </div>
</template>
<script setup>
import Loading from '../components/Loading.vue';
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    debit: Object,
    errors: Object
})

let form = useForm({
    name: props.debit.name,
    phone: props.debit.phone,
    type: props.debit.type,
    amount: props.debit.amount,
    notes: props.debit.notes,
})
const submit = () => {
    !form.processing &&
        form.put(`/debits/${props.debit.id}`);
}

</script>
