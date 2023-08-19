<template>
    <Navbar />
    <Sidebar />
    <div class="content">
        <form @submit.prevent="updateItem" class="ctm-form mt-0" enctype="multipart/form-data">
            <h4 class="text-center mb-3">تعديل منتج</h4>
            <div class="mb-3">
                <label for="title" class="form-label">اسم المنتج</label>
                <input type="text" class="form-control" id="title" v-model="itemForm.title">
                <span v-if="errors.title" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.title }}</span>
            </div>
            <div class="mb-3">
                <label for="notes" class="form-label">وصف المنتج</label>
                <textarea class="form-control" id="notes" v-model="itemForm.notes"> </textarea>
                <span v-if="errors.notes" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.notes }}</span>
            </div>
            <div class="mb-3">
                <label for="cat_id" class="form-label">القسم الرئيسي</label>
                <select v-model="itemForm.cat_id" id="cat_id" class="form-select categories" @change="showSubCats">
                    <option v-for="cat in catsTree" :value="cat.id" :selected="cat.id == itemForm.cat_id"
                        :data-children="JSON.stringify(cat.children)">{{
                            cat.name }}</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="sub_cat_id" class="form-label">القسم الفرعي</label>
                <select v-model="itemForm.sub_cat_id" id="sub_cat_id" class="form-select sub-cats">
                    <option value=""></option>
                </select>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">السعر الأصلي</label>
                <input type="number" class="form-control" id="price" v-model="itemForm.price">
                <span v-if="errors.price" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.price }}</span>
            </div>
            <div class="mb-3">
                <label for="sale_price" class="form-label">سعر البيع</label>
                <input type="number" class="form-control" id="sale_price" v-model="itemForm.sale_price">
                <span v-if="errors.sale_price" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.sale_price
                }}</span>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">الكمية</label>
                <input type="number" class="form-control" id="stock" v-model="itemForm.stock">
                <span v-if="errors.stock" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.stock }}</span>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">صورة المنتج</label>
                <input type="file" class="form-control" id="image" @input="itemForm.image = $event.target.files[0]">
                <span v-if="errors.image" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.image }}</span>
            </div>
            <div class="mb-3">
                <label for="code" class="form-label">كود المنتج</label>
                <input type="number" class="form-control" id="code" v-model="itemForm.code">
                <span v-if="errors.code" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.code }}</span>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">حالة المنتج</label>
                <select v-model="itemForm.status" id="status" class="form-select">
                    <option v-for="(status, key) in enums.item.status" :value="key">{{ status }}</option>
                </select>
                <span v-if="errors.status" class="text-danger text-direction-rtl mt-1 mb-1">{{ errors.status }}</span>
            </div>
            <button class="btn ctm-btn">حفظ</button>
        </form>
    </div>
</template>
<script setup>

import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';
import { router, usePage } from '@inertiajs/vue3';
import { onMounted, reactive } from 'vue';
import enums from '../../constants';

defineProps({ errors: Object, catsTree: Object, item: Object })
let props = usePage().props;

let showSubCats = () => {
    let el = $('.categories').find(':selected');
    let children = el.data('children')
    let subCatsSelect = $('.sub-cats')
    subCatsSelect.html(`<option></option>`)
    if (children.length) {
        for (let subCat in children) {
            let subCatId = children[subCat].id;
            subCatsSelect.append(`<option value='${subCatId}' selected='${subCatId == itemForm.sub_cat_id}'>${children[subCat].name}</option>`)
        }
    }
}

let itemForm = {
    cat_id: props.item.cat_id,
    sub_cat_id: props.item.sub_cat_id,
    title: props.item.title,
    notes: props.item.notes,
    price: props.item.price,
    sale_price: props.item.sale_price,
    stock: props.item.stock,
    image: '',
    code: props.item.code,
    status: props.item.status,
}
const updateItem = () => {
    router.post(`/items/${props.item.id}`, itemForm)
}
onMounted(() => {
    showSubCats();
})
</script>