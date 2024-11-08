<template>
    <div class="date-form-filter d-flex align-items-center flex-column m-auto mt-3 mb-3">
        <form @submit.prevent="dateFormFilter($props.path)"
            class="date-filter mt-2 mb-2 d-flex justify-content-enter gap-2 flex-wrap">
            <div class="d-flex justify-content-center">
                <label for="from" class="mb-1 w-25">من:</label>
                <input class="form-control w-75" name="from" id="from" type="date" v-model="dateForm.from" min="2000-01-01">
            </div>
            <div class="d-flex justify-content-center">
                <label for="to" class="mb-1 w-25">إلى:</label>
                <input class="form-control w-75" name="to" id="to" type="date" v-model="dateForm.to" min="2000-01-01">
            </div>
            <button class="btn btn-indigo" id="submitBtn">بحث</button>
        </form>
    </div>
</template>
<script setup>
import { router } from '@inertiajs/vue3';
import { reactive } from 'vue';
defineProps({
    path: String
})
let dateForm = reactive({
    from: '',
    to: ''
})

const dateFormFilter = (path) => {
    console.log('date');
    if (dateForm.from || dateForm.to)
        router.get(`/${path}?from=${dateForm.from || ''}&to=${dateForm.to || ''}`)
}
</script>