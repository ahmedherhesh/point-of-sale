<template>
    <form class="ctm-form d-block" @submit.prevent="login">
        <!-- <div class="logo d-flex justify-content-center m-3">
            <img src="imgs/logo-80.png" alt="">
        </div> -->
        <h4 class="text-center p-3">تسجيل الدخول</h4>
        <div>
            <label class="label" for="username">اسم المستخدم :</label>
            <input type="text" v-model="form.username" class="form-control mt-2 mb-2"
                :class="errors.username ? 'border-red-400' : 'border-gray-400'" :placeholder="errors.username"
                id="username">
        </div>
        <div>
            <label class="label" for="password">كلمة السر :</label>
            <input type="password" v-model="form.password" class="form-control mt-2 mb-2"
                :class="errors.password ? 'border-red-400' : 'border-gray-400'" :placeholder="errors.password"
                id="password">
        </div>
        <button class="btn ctm-btn w-100">
           <span>تسجيل الدخول</span>
            <Loading v-if="form.processing" />
        </button>

    </form>
</template>
<style>
@media(max-width:33rem) {
    .ctm-form {
        width: 100%;
    }
}
</style>
<script setup>
defineProps({ errors: Object })
import { useForm } from "@inertiajs/vue3";
import Loading from '../components/Loading.vue';
const form = useForm({
    username: null,
    password: null
});
const login = () => {
    !form.processing &&
        form.post('login')
}
</script>