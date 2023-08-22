<template>
    <div class="d-flex justify-content-around mt-2 ctm-pagination">
        <Link v-if="links.next" class="ctm-btn p-1 rounded shadow" :href="links.next">الصفحة التالية</Link>
        <Link v-if="links.prev" class="ctm-btn p-1 rounded shadow" :href="links.prev">الصفحة السابقة</Link>
    </div>
</template>
<script setup>
import {Link} from '@inertiajs/vue3'
defineProps({ links: Object })
</script>