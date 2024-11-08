<template>
    <Navbar :setting="setting" />
    <Sidebar />
    <div class="content">
        <form @submit.prevent="setSettings" class="ctm-form mt-3">
            <h4 class="text-center mb-3">الاعدادات</h4>
            <div class="mb-3">
                <label for="title" class="form-label">عنوان التطبيق</label>
                <input type="text" class="form-control" id="title" v-model="settingForm.title">
                <span v-if="errors.title" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.title }}</span>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">رقم الهاتف</label>
                <input type="text" class="form-control" id="phone" v-model="settingForm.phone">
                <span v-if="errors.phone" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.phone }}</span>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">عنوان المكان</label>
                <input type="text" class="form-control" id="address" v-model="settingForm.address">
                <span v-if="errors.address" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.address }}</span>
            </div>
            <button class="btn ctm-btn">حفظ</button>
        </form>
    </div>
</template>
<script setup>
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';
import { useForm, usePage } from '@inertiajs/vue3';
defineProps({ errors: Object, setting: Object })
let setting = usePage().props.setting;
let settingForm = useForm({
    title: setting.title || '',
    phone: setting.phone || '',
    address: setting.address || ''
})
const setSettings = () => {
    !settingForm.processing &&
        settingForm.post('/settings');
}
</script>