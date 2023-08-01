<template>
    <NavBar />
    <Sidebar />
    <div class="content">
        <div class="table-responsive shadow">
            <table class="table table-light table-hover table-bordered align-middle text-center m-auto mb-5">
                <thead class="table-indigo">
                    <tr>
                        <th class="text-center" scope="row">#</th>
                        <th class="text-center" scope="row">المنتج</th>
                        <th class="text-center" scope="col">الكمية</th>
                        <th class="text-center" scope="col">سعر الشراء</th>
                        <th class="text-center" scope="col">سعر البيع</th>
                        <th class="text-center" scope="col">البار كود</th>
                        <th class="text-center" scope="col">صورة المنتج</th>
                        <th class="text-center" scope="col">تعديل</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <tr v-for="item in items.data">
                        <td scope="row">{{ item.id }}</td>
                        <td scope="row">{{ item.title }}</td>
                        <td scope="col">{{ item.stock }}</td>
                        <td scope="col">{{ item.price }}</td>
                        <td scope="col">{{ item.sale_price }}</td>
                        <td class="d-flex align-items-center  flex-column" scope="col" v-html="item.barcode"></td>
                        <td scope="col"><img src="imgs/logo-80.png" width="50" alt=""></td>
                        <td scope="col">
                            <div class="d-flex justify-content-center gap-2">
                                <button class="text-secondary btn p-0 edit-btn"><i
                                        class="fa-solid fa-pen-to-square"></i></button>
                                <button class="text-secondary btn delete-btn p-0" data-type="المستخدم"><i
                                        class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-around mt-2">
            <Link v-if="items.links.next" class="ctm-btn p-1 rounded shadow" :href="items.links.next">الصفحة التالية</Link>
            <Link v-if="items.links.prev" class="ctm-btn p-1 rounded shadow" :href="items.links.prev">الصفحة السابقة</Link>
        </div>
    </div>
</template>
<script setup>
import NavBar from '../components/NavBar.vue';
import Sidebar from '../components/Sidebar.vue';
import { Link } from '@inertiajs/vue3';
defineProps({ items: Object })
</script>