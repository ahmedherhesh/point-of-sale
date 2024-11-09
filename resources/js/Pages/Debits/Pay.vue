<script setup>
import Loading from '../components/Loading.vue';
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    debit: Object,
    errors: Object
})

const debit = props.debit.data

let form = useForm({
    debit_id: debit.id,
    type: 'full',
    amount: null,
})
const submit = () => {
    !form.processing &&
        form.post('/debits/pay', {
            onSuccess: () => form.reset()
        })
}
</script>

<template>
    <Navbar />
    <Sidebar />
    <div class="content">
        <form @submit.prevent="submit" class="ctm-form mt-3">
            <h4 class="text-center mb-3">دفع دين</h4>
            <div class="mb-3">
                <label for="name" class="form-label">الاسم</label>
                <input type="text" class="form-control" id="name" :value="debit.client.name" disabled>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">نوع الدفع</label>
                <select name="type" class="form-control" id="type" v-model="form.type">
                    <option value="full">كلي</option>
                    <option value="partial">جزئي</option>
                </select>
                <span v-if="errors.type" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.type }}</span>
            </div>
            <div v-if="form.type == 'partial'" class="mb-3">
                <label for="amount" class="form-label">المبلغ</label>
                <input type="number" min="0" class="form-control" id="amount" v-model="form.amount">
                <span v-if="errors.amount" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.amount }}</span>
            </div>
            <button class="btn ctm-btn">
                <span>تسديد</span>
                <Loading v-if="form.processing" />
            </button>
        </form>
    </div>
</template>
