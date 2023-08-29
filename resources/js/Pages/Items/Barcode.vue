
<template>
    <Navbar :setting="setting" />
    <Sidebar />
    <div class="content">
        <items-filter :errors="errors" :items="items" :categories="categories" :companies="companies" />
        <div class="barcodes d-flex justify-content-center flex-wrap gap-2">
            <div v-for="item in items.data" class="card rounded">
                <div class="card-body p-2" style="min-width: 170px;">
                    <h6 class="text-center">{{ setting.title || 'POS' }}</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span>السعر</span>
                        <span>{{ item.sale_price }}</span>
                    </div>
                    <div class="d-flex  flex-column align-items-center" v-html="item.barcode"></div>
                    <p class="text-center" style="font-size: 12px;">{{ item.title }}</p>
                </div>
            </div>
        </div>
        <PrintButton />
        <Pagination :links="items.links" />
    </div>
</template>
<style>
@media print{

    .barcodes{
        flex-direction: column ;
        align-items: center ;
    }
}
</style>
<script setup>
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';
import ItemsFilter from '../components/ItemsFilter.vue';
import Pagination from '../components/Pagination.vue';
import PrintButton from '../components/PrintButton.vue';
defineProps({ errors: Object, items: Object, categories: Object, companies: Object ,setting:Object})
</script>