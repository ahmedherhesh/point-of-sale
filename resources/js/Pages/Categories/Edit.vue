<template>
    <Navbar :setting="setting" />
    <Sidebar />
    <div class="content">
        <form @submit.prevent="updateCategory" class="ctm-form mt-0">
            <h4 class="text-center mb-3">تعديل قسم</h4>
            <div class="mb-3" v-if="categories && categories.length">
                <label for="parent_id" class="form-label">القسم الرئيسي</label>
                <select v-model="categoryForm.parent_id" id="parent_id" class="form-select">
                    <option value=""></option>
                    <option v-for="cat in categories" :value="cat.id" :selected="cat.id == categoryForm.parent_id">{{
                        cat.name }}</option>
                </select>
                <span v-if="errors.name" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.parent_id }}</span>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">اسم القسم</label>
                <input type="text" class="form-control" id="name" v-model="categoryForm.name"
                    aria-describedby="emailHelp">
                <span v-if="errors.name" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.name }}</span>
            </div>

            <button class="btn ctm-btn">
                <span>حفظ</span>
                <Loading v-if="categoryForm.processing" />
            </button>
        </form>
    </div>
</template>
<script setup>
import Loading from '../components/Loading.vue';
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';
import {  useForm, usePage } from '@inertiajs/vue3';

defineProps({ categories: Object, category: Object, errors: Object, setting: Object })
let props = usePage().props;

let categoryForm = useForm({
    parent_id: props.category.parent_id,
    name: props.category.name,
})
const updateCategory = () => {
    !categoryForm.processing &&
        categoryForm.put(`/categories/${props.category.id}`)
}

</script>
