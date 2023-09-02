<template>
    <Navbar :setting="setting" />
    <Sidebar />
    <div class="content">
        <form @submit.prevent="addUser" class="ctm-form mt-0">
            <h4 class="text-center mb-3">إضافة مستخدم</h4>
            <div class="mb-3">
                <label for="name" class="form-label">الإسم بالكامل</label>
                <input type="text" class="form-control" id="name" v-model="userForm.name" aria-describedby="emailHelp">
                <span v-if="errors.name" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.name }}</span>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">اسم المستخدم</label>
                <input type="text" class="form-control" id="username" v-model="userForm.username"
                    aria-describedby="emailHelp">
                <span v-if="errors.username" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.username }}</span>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">الإيميل</label>
                <input type="text" class="form-control" id="email" v-model="userForm.email" aria-describedby="emailHelp">
                <span v-if="errors.email" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.email }}</span>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">الوظيفه</label>
                <select class="form-select" id="role" v-model="userForm.role">
                    <option v-for="(role, key) in enums.user.roles" :value="key">{{ role }}
                    </option>
                </select>
                <span v-if="errors.role" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.role }}</span>
            </div>
            <div class="mb-3">
                <label for="permission" class="form-label">الصلاحيات</label>
                <p v-if="errors.permissions" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.permissions }}</p>
                <div v-for="permission in $page.props.permissions" class="d-inline-block w-50">
                    <input class="ms-2" type="checkbox" :value="permission" :id="permission" v-model="permissions"
                        @change="pushPermission">
                    <label :for="permission" class="d-inline-block ms-2">{{ permission }}</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">الحاله</label>
                <select class="form-select" id="status" v-model="userForm.status">
                    <option v-for="(status, key) in enums.user.status" :value="key">{{ status
                    }}</option>
                </select>
                <span v-if="errors.status" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.status }}</span>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">كلمة السر</label>
                <input type="password" class="form-control" id="password" v-model="userForm.password">
                <span v-if="errors.password" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.password }}</span>
            </div>
            <button class="btn ctm-btn">إضافة</button>
        </form>
    </div>
</template>
<script setup>
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';
import { router } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import enums from '../../constants.js';

defineProps({ user: Object, errors: Object, setting: Object })
const permissions = ref([]);
let userForm = {
    name: '',
    username: '',
    email: '',
    password: '',
    role: '',
    permissions: [],
    status: ''
}
onMounted(() => {
    pushPermission()
});
const pushPermission = e => {
    userForm.permissions = permissions._value;
}

const addUser = () => {
    router.post('/users', userForm)
}

</script>
