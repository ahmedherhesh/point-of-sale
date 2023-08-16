<template>
    <div class="filter row">
        <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
            <input type="search" class="form-control" :class="errors.code && filterForm.code.trim() ? 'border-danger' : ''"
                placeholder="بحث بالكود" v-model="filterForm.code" @input="itemsFilter">
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
            <input type="search" class="form-control" placeholder="بحث العنوان" v-model="filterForm.title"
                @input="itemsFilter">
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
            <select class="form-select" @change="itemsFilter" v-model="filterForm.cat_id">
                <option value="">الأقسام</option>
                <option v-for="cat in categories" :value="cat.id">{{ cat.name }}</option>
            </select>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
            <select class="form-select" @change="itemsFilter" v-model="filterForm.company_id">
                <option value="">الشركات</option>
                <option v-for="company in companies" :value="company.id">{{ company.name }}</option>
            </select>
        </div>
    </div>
</template>
<script setup>
defineProps({ errors: Object, categories: Object, companies: Object })
import { reactive } from 'vue';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
let filterForm = reactive({
    title: '',
    company_id: '',
    cat_id: '',
    code: ''
});
const itemsFilter = e => {
    let page = usePage();
    axios.post('/items-filter', filterForm)
        .then(res => {
            page.props.items = res.data
        }).catch(res => {
            page.props.errors = res.response.data.errors
        })
}

</script>