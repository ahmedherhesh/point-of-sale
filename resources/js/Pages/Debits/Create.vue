<script setup>
import Loading from '../components/Loading.vue';
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';
import { useForm } from '@inertiajs/vue3';
import ClientSearch from './Partials/ClientSearch.vue';

defineProps({
    clients: Object,
    errors: Object
})

let form = useForm({
    name: '',
    phone: '',
    type: '',
    amount: '',
    notes: '',
})
const submit = () => {
    !form.processing &&
        form.post('/debits', {
            onSuccess: () => form.reset()
        })
}
</script>

<template>
    <Navbar />
    <Sidebar />
    <div class="content">
        <form @submit.prevent="submit" class="ctm-form mt-3">
            <h4 class="text-center mb-3">إضافة دين</h4>
            <div class="mb-3">
                <label for="name" class="form-label">الاسم</label>
                <ClientSearch @change="value => form.client_id = value.id" :suggestions="clients" />
                <span v-if="errors.client_id" class="text-danger text-direction-rtl mt-1 mb-1">
                    {{ errors.client_id }}
                </span>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">نوع الدين</label>
                <select name="type" class="form-control" id="type" v-model="form.type">
                    <option value="debit">دائن</option>
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
                <span>اضافة</span>
                <Loading v-if="form.processing" />
            </button>
        </form>
    </div>
</template>
