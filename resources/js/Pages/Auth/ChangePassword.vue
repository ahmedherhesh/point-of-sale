<template>
    <Navbar :setting="setting" />
    <Sidebar />
    <div class="content">
        <form @submit.prevent="changePassword" class="ctm-form">
            <h4 class="text-center mb-4">تغيير كلمة السر</h4>
            <div class="mb-3">
                <label for="oldPassword" class="form-label">كلمة السر القديمة</label>
                <input type="password" class="form-control" id="oldPassword" v-model="passwordForm.oldPassword">

                <span v-if="errors.oldPassword" class="text-danger text-direction-rtl">{{ errors.oldPassword }}</span>

            </div>
            <div class="mb-3">
                <label for="password" class="form-label">كلمة السر الجديدة</label>
                <input type="password" class="form-control" id="password" v-model="passwordForm.password">
                <span v-if="errors.password" class="text-danger text-direction-rtl">{{ errors.password }}</span>

            </div>
            <div class="mb-3">
                <label for="password" class="form-label">تأكيد كلمة السر</label>
                <input type="password" class="form-control" id="repeatPassword" v-model="passwordForm.repeatPassword">
                <span v-if="errors.repeatPassword" class="text-danger text-direction-rtl">{{ errors.repeatPassword }}</span>
            </div>
            <button type="submit" class="btn ctm-btn">حفظ</button>
        </form>
    </div>
</template>
<script setup>
defineProps({ errors: Object,setting:Object })
import { useForm } from '@inertiajs/vue3';
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';

let passwordForm = useForm({
    oldPassword: '',
    password: '',
    repeatPassword: '',
})
const changePassword = () => {
    passwordForm.post('/change-password')
    passwordForm.reset()
}
</script>