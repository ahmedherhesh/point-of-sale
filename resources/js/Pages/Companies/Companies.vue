<template>
    <navbar />
    <sidebar />
    <div class="content">
        <div class="table-responsive shadow">
            <table class="table table-light table-hover table-bordered align-middle text-center m-auto
            ">
                <thead class="table-indigo">
                    <tr>
                        <th>#</th>
                        <th>الإسم</th>
                        <th>تعديل</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(company, i) in companies.data">
                        <td>{{ i + 1 }}</td>
                        <td>{{ company.name }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <Link :href="`/companies/${company.id}/edit`" class="text-secondary btn p-0 edit-btn"><i
                                        class="fa-solid fa-pen-to-square"></i></Link>
                                        <button @click="deleteCompany" class="text-secondary btn delete-btn p-0" :data-companyId="company.id" data-type="الشركة"><i
                                        class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-around mt-2">
            <Link v-if="companies.links.next" class="ctm-btn p-1 rounded shadow" :href="companies.links.next">الصفحة التالية</Link>
            <Link v-if="companies.links.prev" class="ctm-btn p-1 rounded shadow" :href="companies.links.prev">الصفحة السابقة</Link>
        </div>
    </div>
</template>
<script setup>
import Navbar from '../components/Navbar.vue'
import Sidebar from '../components/Sidebar.vue'
import { Link, router } from '@inertiajs/vue3';
defineProps({ companies: Object })
let deleteCompany = e => {
    let el = e.currentTarget;
    if (confirm('هل انت متأكد من حذف هذه الشركة'))
        router.delete(`companies/${el.getAttribute('data-companyId')}`)
}
</script>