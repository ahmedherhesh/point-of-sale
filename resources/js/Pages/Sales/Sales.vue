<template>
    <Navbar :setting="setting" />
    <Sidebar />
    <div class="content">
        <DateFilter path='sales'/>
        <div class="filter">
            <div class="mb-3">
                <form @submit.prevent="getInvoice">
                    <input type="number" class="form-control" min="0" v-model="invoice_id" placeholder="رقم الفاتورة">
                    <button class="d-none">بحث</button>
                </form>
            </div>
        </div>
        <div class="table-responsive shadow">
            <table class="table table-light table-hover table-bordered align-middle text-center m-auto">
                <thead class="table-indigo">
                    <tr>
                        <th class="text-center" scope="row">#</th>
                        <th class="text-center" scope="row">اسم العميل</th>
                        <th class="text-center" scope="col">رقم المحمول</th>
                        <th class="text-center" scope="col">الخصم</th>
                        <th class="text-center" scope="col">تاريخ العملية</th>
                        <th class="text-center btns-controller" scope="col">تعديل</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <tr v-for="(operation) in operations.data">
                        <td scope="row">{{ operation.id }}</td>
                        <td scope="row">
                            <Link :href="'/sales/' + operation.id">{{ operation.customer_name ?? '-----' }}</Link>
                        </td>
                        <td scope="col">
                            <Link :href="'/sales/' + operation.id">{{ operation.customer_phone ?? '-----' }}</Link>
                        </td>
                        <td scope="col">
                            <Link :href="'/sales/' + operation.id">{{ operation.discount ?? 0 }}</Link>
                        </td>
                        <td scope="col">
                            <Link :href="'/sales/' + operation.id">{{ operation.created_at.split('T')[0] }}</Link>
                        </td>
                        <td scope="col">
                            <div class="d-flex justify-content-center gap-2 btns-controller">
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
        <PrintButton />
        <Pagination :links="operations.links" />

    </div>
</template>
<script setup>
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';
import Pagination from '../components/Pagination.vue';
import { Link, router } from '@inertiajs/vue3';
import PrintButton from '../components/PrintButton.vue';
import DateFilter from '../components/DateFilter.vue';

defineProps({ operations: Object ,setting:Object})
let invoice_id;
const getInvoice = e => {
    router.get(`/sales?invoice_id=${invoice_id}`)
    console.log(e);
}
let deleteOperation = e => {
    let el = e.currentTarget;
    if (confirm('هل انت متأكد من حذف هذه العملية'))
        router.delete(`/sales/${el.getAttribute('data-operationId')}`)
}
</script>