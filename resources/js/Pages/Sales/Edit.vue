<template>
    <navbar :setting="setting" />
    <sidebar />
    <div class="content">
        <items-filter :errors="errors" :items="items" :categories="categories" :companies="companies" />
        <div class="row justify-content-around align-items-start">
            <items :items="items" />
            <cart :operation="operation"/>
        </div>
    </div>
</template>

<script setup>
defineProps({ errors: Object, items: Object, categories: Object, companies: Object, operation: Object ,setting:Object})
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';
import Cart from '../components/Cart.vue';
import ItemsFilter from '../components/ItemsFilter.vue';
import Items from '../components/Items.vue';
</script>