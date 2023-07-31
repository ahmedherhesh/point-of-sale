<template>
    <NavBar />
    <Sidebar />
    <div class="content">
        <table class="table  table-hover">
            <thead>
                <tr>
                    <th class="text-center" scope="row">#</th>
                    <th class="text-center" scope="row">المنتج</th>
                    <th class="text-center" scope="col">الكمية</th>
                    <th class="text-center" scope="col">سعر الشراء</th>
                    <th class="text-center" scope="col">سعر البيع</th>
                    <th class="text-center" scope="col">البار كود</th>
                    <th class="text-center" scope="col">صورة المنتج</th>
                    <th class="text-center" scope="col"></th>
                </tr>
            </thead>
            <tbody id="tbody">
                <tr v-for="item in items.data">
                    <td class="text-center" scope="row">{{ item.id }}</td>
                    <td class="text-center" scope="row">{{ item.title }}</td>
                    <td class="text-center" scope="col">{{ item.stock }}</td>
                    <td class="text-center" scope="col">{{ item.price }}</td>
                    <td class="text-center" scope="col">{{ item.sale_price }}</td>
                    <td class="d-flex align-items-center  flex-column" scope="col" v-html="item.barcode"></td>
                    <td class="text-center" scope="col"><img src="imgs/logo-80.png" width="50" alt=""></td>
                    <td class="text-center" scope="col"></td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-around">
            <Link class="ctm-btn p-1 rounded" :href="items.links.next">الصفحة التالية</Link>
            <Link class="ctm-btn p-1 rounded" :href="items.links.prev">الصفحة السابقة</Link>
        </div>
    </div>
</template>
<script setup>
import NavBar from '../components/NavBar.vue';
import Sidebar from '../components/Sidebar.vue';
import { Link } from '@inertiajs/vue3';
defineProps({ items: Object })
</script>