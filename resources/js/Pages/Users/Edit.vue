<template>
    <Navbar />
    <Sidebar />
    <div class="content">
        <form @submit.prevent="updateUser" class="ctm-form mt-0">
            <h4 class="text-center mb-3"> تعديل مستخدم</h4>
            <div class="mb-3">
                <label for="edit_name" class="form-label">الإسم بالكامل</label>
                <input type="text" class="form-control" id="edit_name" v-model="userForm.name" aria-describedby="emailHelp">
                <span v-if="errors.name" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.name }}</span>
            </div>
            <div class="mb-3">
                <label for="edit_username" class="form-label">اسم المستخدم</label>
                <input type="text" class="form-control" id="edit_username" v-model="userForm.username"
                    aria-describedby="emailHelp">
                <span v-if="errors.username" class="text-danger text-direction-rtl mt-1 mb-1">{{errors.username}}</span>
            </div>
            <div class="mb-3">
                <label for="edit_email" class="form-label">الإيميل</label>
                <input type="text" class="form-control" id="edit_email" v-model="userForm.email"
                    aria-describedby="emailHelp">
                <span v-if="errors.email" class="text-danger text-direction-rtl mt-1 mb-1">{{errors.email}}</span>
            </div>
            <div class="mb-3">
                <label for="edit_role" class="form-label">الصلاحية</label>
                <select class="form-select" id="edit_role" v-model="userForm.role">
                    <option v-for="(role, key) in enums.user.roles" :value="key" :selected="user.role == key">{{ role }}</option>
                </select>
                <span v-if="errors.role" class="text-danger text-direction-rtl mt-1 mb-1">{{errors.role}}</span>

            </div>
            <div class="mb-3">
                <label for="edit_status" class="form-label">الحاله</label>
                <select class="form-select" id="edit_status" v-model="userForm.status">
                    <option v-for="(status, key) in enums.user.status" :value="key" :selected="user.status == key">{{ status }}</option>
                </select>
                <span v-if="errors.status" class="text-danger text-direction-rtl mt-1 mb-1">{{errors.status}}</span>
            </div>
            <div class="mb-3">
                <label for="edit_password" class="form-label">كلمة السر</label>
                <input type="password" class="form-control" id="edit_password" v-model="userForm.password">
                <span v-if="errors.password" class="text-danger text-direction-rtl mt-1 mb-1">{{errors.password}}</span>
            </div>
            <button class="btn ctm-btn">حفظ</button>
        </form>
    </div>
</template>
<script setup>
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';
import { router, usePage } from '@inertiajs/vue3';
import enums from '../../constants.js';

defineProps({ user: Object, errors: Object })
let props = usePage().props;
let userForm = {
    name: props.user.name,
    username: props.user.username,
    email: props.user.email,
    password: '',
    role: props.user.role,
    status: props.user.status
}
const updateUser = () => {
    router.put(`/users/${props.user.id}`, userForm)
}

</script>
