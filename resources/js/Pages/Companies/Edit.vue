<template>
    <Navbar :setting="setting" />
    <Sidebar />
    <div class="content">
        <form @submit.prevent="updateCompany" class="ctm-form mt-0">
            <h4 class="text-center mb-3">تعديل شركة</h4>
            <div class="mb-3">
                <label for="name" class="form-label">اسم الشركة</label>
                <input type="text" class="form-control" id="name" v-model="companyForm.name"
                    aria-describedby="emailHelp">
                <span v-if="errors.name" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.name }}</span>
            </div>
            <button class="btn ctm-btn">
                <span>حفظ</span>
                <Loading v-if="companyForm.processing" />
            </button>
        </form>
    </div>
</template>
<script setup>
import Loading from '../components/Loading.vue';
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';
import { useForm, usePage } from '@inertiajs/vue3';

defineProps({ errors: Object, company: Object, setting: Object })

let props = usePage().props
let companyForm = useForm({
    name: props.company.name,
})
const updateCompany = () => {
    !companyForm.processing &&
        companyForm.put(`/companies/${props.company.id}`)
}

</script>
