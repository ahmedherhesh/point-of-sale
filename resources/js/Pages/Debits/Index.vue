<template>
    <Navbar :setting="setting" />
    <Sidebar />
    <div class="content">
        <div class="table-responsive shadow">
            <table class="table table-light table-hover table-bordered align-middle text-center m-auto">
                <thead class="table-indigo">
                    <tr>
                        <th class="text-center" scope="row">#</th>
                        <th class="text-center" scope="row">الاسم</th>
                        <th class="text-center" scope="row">رقم المحمول</th>
                        <th class="text-center" scope="col">المبلغ</th>
                        <th class="text-center" scope="col">تم تسديد مبلغ</th>
                        <th class="text-center" scope="col">باقي</th>
                        <th class="text-center" scope="col">نوع الدين</th>
                        <th class="text-center" scope="col">التاريخ</th>
                        <th class="text-center btns-controller" scope="col">تعديل</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <tr v-for="(debit, i) in debits.data">
                        <td scope="row">{{ debit.id }}</td>
                        <td scope="row">{{ debit.name }}</td>
                        <td scope="row">{{ debit.phone }}</td>
                        <td scope="row">{{ debit.amount }}</td>
                        <td scope="col">0</td>
                        <td scope="col">0</td>
                        <td scope="col">{{ debit.type }}</td>
                        <td scope="col">{{ debit.created_at }}</td>
                        <td scope="col" class="btns-controller">
                            <div class="d-flex justify-content-center gap-2">
                                <Link :href="`/debits/${debit.id}/edit`" class="text-secondary btn p-0 edit-btn"><i
                                    class="fa-solid fa-pen-to-square"></i></Link>
                                <button @click="deleteDebit" class="text-secondary btn delete-btn p-0"
                                    :data-debitId="debit.id" ><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <PrintButton />
        <Pagination :links="debits.links" />
    </div>
</template>
<style>
#tbody .item-img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 50%;
}
</style>
<script setup>
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';
import Pagination from '../components/Pagination.vue';
import { Link, router } from '@inertiajs/vue3';
import PrintButton from '../components/PrintButton.vue';
defineProps({
    errors: Object,
    debits: Object,
    setting: Object
})
let deleteDebit = e => {
    let el = e.currentTarget;
    if (confirm('هل انت متأكد من حذف هذا الدين'))
        router.delete(`debits/${el.getAttribute('data-debitId')}`)
}
</script>