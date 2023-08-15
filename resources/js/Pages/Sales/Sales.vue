<template>
    <NavBar />
    <Sidebar />
    <div class="content">
        <div class="table-responsive shadow">
            <table class="table table-light table-hover table-bordered align-middle text-center m-auto">
                <thead class="table-indigo">
                    <tr>
                        <th class="text-center" scope="row">#</th>
                        <th class="text-center" scope="row">اسم العميل</th>
                        <th class="text-center" scope="col">رقم المحمول</th>
                        <th class="text-center" scope="col">تاريخ العملية</th>
                        <th class="text-center" scope="col">تعديل</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <tr v-for="(operation) in operations.data">
                        <td scope="row">{{ operation.id }}</td>
                        <td scope="row">{{ operation.customer_name  ?? '-----'}}</td>
                        <td scope="col">{{ operation.customer_phone  ?? '-----'}}</td>
                        <td scope="col">{{ operation.created_at.split('T')[0] }}</td>
                        <td scope="col">
                            <div class="d-flex justify-content-center gap-2">
                                <Link :href="`/sales/${operation.id}/edit`" class="text-secondary btn p-0 edit-btn"><i
                                    class="fa-solid fa-pen-to-square"></i></Link>
                                <button @click="deleteOperation" class="text-secondary btn delete-btn p-0"
                                    :data-operationId="operation.id" data-type="القسم"><i
                                        class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-around mt-2">
            <Link v-if="operations.links.next" class="ctm-btn p-1 rounded shadow" :href="operations.links.next">الصفحة
            التالية</Link>
            <Link v-if="operations.links.prev" class="ctm-btn p-1 rounded shadow" :href="operations.links.prev">الصفحة
            السابقة</Link>
        </div>
    </div>
</template>
<script setup>
import NavBar from '../components/NavBar.vue';
import Sidebar from '../components/Sidebar.vue';
import { Link, router } from '@inertiajs/vue3';
defineProps({ operations: Object })
let deleteOperation = e => {
    let el = e.currentTarget;
    if (confirm('هل انت متأكد من حذف هذه العملية'))
        router.delete(`sales/${el.getAttribute('data-operationId')}`)
}
</script>