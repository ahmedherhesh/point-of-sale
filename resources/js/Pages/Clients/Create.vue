<script setup>
import Loading from '../components/Loading.vue';
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';
import { useForm } from '@inertiajs/vue3';

defineProps({ errors: Object })

let form = useForm({
    name: '',
    phone: '',
    address: '',
    national_id: '',
})
const submit = () => {
    !form.processing &&
        form.post('/clients', {
            onSuccess: () => form.reset()
        })
}
</script>

<template>
    <Navbar />
    <Sidebar />
    <div class="content">
        <form @submit.prevent="submit" class="ctm-form mt-3">
            <h4 class="text-center mb-3">إضافة عميل</h4>
            <div class="mb-3">
                <label for="name" class="form-label">الاسم</label>
                <input type="text" class="form-control" id="name" v-model="form.name">
                <span v-if="errors.name" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.name }}</span>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">رقم المحمول</label>
                <input type="text" class="form-control" id="phone" v-model="form.phone">
                <span v-if="errors.phone" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.phone }}</span>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">العنوان</label>
                <input type="text" class="form-control" id="address" v-model="form.address">
                <span v-if="errors.address" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.address }}</span>
            </div>
            <div class="mb-3">
                <label for="national_id" class="form-label">الرقم القومي</label>
                <input type="number" min="0" class="form-control" id="national_id" v-model="form.national_id">
                <span v-if="errors.national_id" class="text-danger text-direction-rtl mt-1 mb-1">
                    {{ errors.national_id }}
                </span>
            </div>
            <button class="btn ctm-btn">
                <span>اضافة</span>
                <Loading v-if="form.processing" />
            </button>
        </form>
    </div>
</template>
