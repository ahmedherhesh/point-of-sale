<template>
    <Navbar :setting="setting" />
    <Sidebar />
    <div class="content">
        <!-- <items-filter :errors="errors" :items="items" :categories="categories" :companies="companies" /> -->
        <div class="table-responsive shadow">
            <table class="table table-light table-hover table-bordered align-middle text-center m-auto">
                <thead class="table-indigo">
                    <tr>
                        <th class="text-center" scope="row">#</th>
                        <th class="text-center" scope="row">المنتج</th>
                        <th class="text-center" scope="col">الكمية</th>
                        <th class="text-center" scope="col">صورة المنتج</th>
                        <th class="text-center btns-controller" scope="col">تعديل</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <tr v-for="(damageItem, i) in damageItems.data">
                        <td scope="row">{{ ++i }}</td>
                        <td scope="row">{{ damageItem.item.title }}</td>
                        <td scope="col">{{ damageItem.stock }}</td>
                        <td scope="col"><img class="item-img" :src="damageItem.item.image" alt=""></td>
                        <td scope="col" class="btns-controller">
                            <div class="d-flex justify-content-center gap-2">
                                <Link :href="`/damages/${damageItem.id}/edit`" class="text-secondary btn p-0 edit-btn"><i
                                    class="fa-solid fa-pen-to-square"></i></Link>
                                <button @click="deleteDamageItem" class="text-secondary btn delete-btn p-0"
                                    :data-damageItemId="damageItem.id" data-type="القسم"><i
                                        class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <PrintButton />
        <Pagination :links="damageItems.links" />

    </div>
</template>
<script setup>
import Navbar from '../components/Navbar.vue';
import Pagination from '../components/Pagination.vue';
import PrintButton from '../components/PrintButton.vue';
import Sidebar from '../components/Sidebar.vue';
import { Link, router } from '@inertiajs/vue3'
defineProps({ setting: Object, damageItems: Object });
const deleteDamageItem = e => {
    if (confirm('هل انت متأكد من حذف هذا المنتج التالف'))
        router.delete(`/damages/${e.currentTarget.getAttribute('data-damageItemId')}`);
}
</script>