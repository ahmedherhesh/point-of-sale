<template>
    <Navbar />
    <Sidebar />
    <div class="content">
        <form @submit.prevent="addCompany" class="ctm-form mt-0">
            <h4 class="text-center mb-3">إضافة شركة</h4>
            <div class="mb-3">
                <label for="name" class="form-label">اسم الشركة</label>
                <input type="text" class="form-control" id="name" v-model="companyForm.name" aria-describedby="emailHelp">
                <span v-if="errors.name" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.name }}</span>
            </div>

            <button class="btn ctm-btn">إضافة</button>
        </form>
    </div>
</template>
<script setup>
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';
import { router } from '@inertiajs/vue3';

defineProps({ errors: Object })

let companyForm = {
    name: '',
}
const addCompany = () => {
    router.post('/companies', companyForm)
    companyForm.name = ''
}

</script>
