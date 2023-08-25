<template>
    <div class="d-flex justify-content-around mt-2 ctm-pagination">
        <Link v-if="links.next" class="ctm-btn p-1 rounded shadow" :href="`${links.next}${windowSearch.args || ''}`">الصفحة
        التالية
        </Link>
        <Link v-if="links.prev" class="ctm-btn p-1 rounded shadow" :href="`${links.prev}${windowSearch.args || ''}`">الصفحة
        السابقة
        </Link>
    </div>
</template>
<script setup>
import { Link, } from '@inertiajs/vue3'
import { onMounted, reactive } from 'vue';
import { getParams } from '../../main'
defineProps({ links: Object })
let windowSearch = reactive({ args: '' })
onMounted(() => {
    let pageParams = getParams()
    for (let param in pageParams) {
        if (param != 'page')
            windowSearch.args += `${param}=${pageParams[param]}`
    }
    if (windowSearch.args)
        windowSearch.args = '&' + windowSearch.args
})
</script>