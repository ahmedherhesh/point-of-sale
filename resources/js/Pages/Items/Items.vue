<template>
    <Navbar :setting="setting" />
    <Sidebar />
    <div class="content">
        <items-filter :errors="errors" :items="items" :categories="categories" :companies="companies" />
        <div class="table-responsive shadow">
            <div class="row p-2">
                <h4 class="col-md-6 col-sm-12 text-center">إجمالي سعر الشراء : {{ totalPrice }}</h4>
                <h4 class="col-md-6 col-sm-12 text-center">اجمالي سعر البيع : {{ totalSalePrice }}</h4>
            </div>
            <table class="table table-light table-hover table-bordered align-middle text-center m-auto">
                <thead class="table-indigo">
                    <tr>
                        <th class="text-center" scope="row">#</th>
                        <th class="text-center" scope="row">المنتج</th>
                        <th class="text-center" scope="row">الوصف</th>
                        <th class="text-center" scope="col">الكمية</th>
                        <th class="text-center" scope="col">سعر الشراء</th>
                        <th class="text-center" scope="col">سعر البيع قطاعي</th>
                        <th class="text-center" scope="col">سعر البيع بالجملة</th>
                        <th class="text-center" scope="col">البار كود</th>
                        <th class="text-center" scope="col">صورة المنتج</th>
                        <th class="text-center btns-controller" scope="col">تعديل</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <tr v-for="(item, i) in items.data">
                        <td scope="row">{{ ++i }}</td>
                        <td scope="row">{{ item.title }}</td>
                        <td scope="row">{{ item.notes ?? '-----' }}</td>
                        <td scope="col">{{ item.stock }}</td>
                        <td scope="col">{{ item.price }}</td>
                        <td scope="col">{{ item.sale_price }}</td>
                        <td scope="col">{{ item.whole_sale_price }}</td>
                        <td class="d-flex align-items-center  flex-column" scope="col" v-html="item.barcode"></td>
                        <td scope="col"><img class="item-img" :src="item.image" alt=""></td>
                        <td scope="col" class="btns-controller">
                            <div class="d-flex justify-content-center gap-2">
                                <Link :href="`/items/${item.id}/edit`" class="text-secondary btn p-0 edit-btn"><i
                                    class="fa-solid fa-pen-to-square"></i></Link>
                                <button @click="deleteItem" class="text-secondary btn delete-btn p-0" :data-itemId="item.id"
                                    data-type="القسم"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <PrintButton />
        <Pagination :links="items.links" />

    </div>
</template>
<style>
#tbody .item-img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 50%;
}
</style>
<script setup>
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';
import ItemsFilter from '../components/ItemsFilter.vue';
import Pagination from '../components/Pagination.vue';
import { Link, router } from '@inertiajs/vue3';
import PrintButton from '../components/PrintButton.vue';
defineProps({
    errors: Object,
    items: Object,
    categories: Object,
    companies: Object,
    setting: Object,
    totalSalePrice: Object,
    totalPrice: Object,
})
let deleteItem = e => {
    let el = e.currentTarget;
    if (confirm('هل انت متأكد من حذف هذا المنتج'))
        router.delete(`items/${el.getAttribute('data-itemId')}`)
}
</script>