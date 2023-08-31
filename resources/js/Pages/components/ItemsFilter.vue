<template>
    <div class="filter row justify-content-center w-100 items-filter mb-2">
        <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
            <input type="number" min="0" class="form-control"
                :class="errors.code && filterForm.code ? 'border-danger' : ''" placeholder="بحث بالكود"
                v-model="filterForm.code" @input="itemsFilter">
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
            <input type="search" class="form-control" placeholder="بحث العنوان" v-model="filterForm.title"
                @input="itemsFilter">
        </div>
        <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
            <select class="form-select" @change="itemsFilter" v-model="filterForm.cat_id">
                <option value="">الأقسام</option>
                <option v-for="cat in categories" :value="cat.id">{{ cat.name }}</option>
            </select>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
            <select class="form-select" @change="itemsFilter" v-model="filterForm.company_id">
                <option value="">الشركات</option>
                <option v-for="company in companies" :value="company.id">{{ company.name }}</option>
            </select>
        </div>
        <div style="width: fit-content;">
            <button class="search-btn btn btn-indigo" id="searchBtn" @click="itemsFilter">بحث</button>
        </div>
    </div>
</template>
<script setup>
defineProps({ errors: Object, categories: Object, companies: Object })
import { onMounted, reactive } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import axios from 'axios';
import { getParams } from '../../main';
let filterForm = reactive({
    title: '',
    company_id: '',
    cat_id: '',
    code: '',
});
onMounted(() => {
    let params = getParams();
    // filterForm.title = params.title || ''
    filterForm.company_id = params.company_id || ''
    filterForm.cat_id = params.cat_id || ''
    filterForm.code = params.code || ''
    if (window.location.pathname == '/')
        searchBtn.remove()

})
const itemsFilter = e => {
    let page = usePage();
    let pathname = window.location.pathname;
    pathname.includes('not-in-stock') ? filterForm['notInStock'] = true : filterForm['inStock'] = true
    if (pathname == '/') {
        axios.post('/items-filter', filterForm)
            .then(res => {
                page.props.items = res.data
            }).catch(res => {
                page.props.errors = res.response.data.errors
            })
    } else if (e.currentTarget.classList.contains('search-btn')) {
        let params = JSON.stringify(filterForm).replaceAll('"', '').replaceAll(',', '&').replaceAll(':', '=').replace('{', '').replace('}', '')
        if (pathname.includes('barcode'))
            router.get(`/barcode?${params}`)
        else
            router.get(`/items?${params}`)
    }
}

</script>