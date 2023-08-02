<template>
    <navbar />
    <sidebar />
    <div class="content">
        <div class="table-responsive shadow">
            <table class="table table-light table-hover table-bordered align-middle text-center m-auto">
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
                        <td>{{ category.parent_id ? 'فرعي' : 'رئيسي' }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <Link :href="`/categories/${category.id}/edit`" class="text-secondary btn p-0 edit-btn"><i
                                        class="fa-solid fa-pen-to-square"></i></Link>
                                <button @click="deleteCategory" class="text-secondary btn delete-btn p-0" :data-categoryId="category.id" data-type="القسم"><i
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
import { Link, router } from '@inertiajs/vue3';

defineProps({ categories: Object })
let deleteCategory = e => {
    let el = e.currentTarget;
    if (confirm('هل انت متأكد من حذف هذا القسم'))
        router.delete(`categories/${el.getAttribute('data-categoryId')}`)
}
</script>