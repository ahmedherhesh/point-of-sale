<template>
    <navbar />
    <sidebar />
    <div class="content">
        <div class="table-responsive shadow">
            <table class="table table-light table-hover table-bordered align-middle text-center m-auto mb-5">
                <thead class=" table-indigo">
                    <tr>
                        <th>#</th>
                        <th>الإسم</th>
                        <th>نوع القسم</th>
                        <th>تعديل</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(category, i) in categories.data">
                        <td>{{ i + 1 }}</td>
                        <td>{{ category.name }}</td>
                        <td>{{ category.parent_id ? 'رئيسي' : 'فرعي' }}</td>
                        <td>
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
            <Link v-if="categories.links.next" class="ctm-btn p-1 rounded shadow" :href="categories.links.next">الصفحة التالية</Link>
            <Link v-if="categories.links.prev" class="ctm-btn p-1 rounded shadow" :href="categories.links.prev">الصفحة السابقة</Link>
        </div>
    </div>
</template>
<script setup>
import Navbar from '../components/Navbar.vue'
import Sidebar from '../components/Sidebar.vue'
import { Link } from '@inertiajs/vue3';
defineProps({ categories: Object })

</script>