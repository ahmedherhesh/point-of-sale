<template>
    <navbar />
    <sidebar />
    <div class="content">
        <div class="table-responsive shadow" style="min-width: 600px;">
            <table class="table table-light table-hover table-bordered align-middle text-center m-auto">
                <thead class="table-indigo">
                    <tr>
                        <th>#</th>
                        <th>العنوان</th>
                        <th>المبلغ</th>
                        <th>التاريخ</th>
                        <th>تعديل</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(expense, i) in expenses.data">
                        <td>{{ i + 1 }}</td>
                        <td>{{ expense.title }}</td>
                        <td>{{ expense.amount }}</td>
                        <td>{{ expense.created_at.split('T')[0] }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <Link :href="`/expenses/${expense.id}/edit`" class="text-secondary btn p-0 edit-btn"><i
                                        class="fa-solid fa-pen-to-square"></i></Link>
                                <button class="text-secondary btn delete-btn p-0" @click="deleteExpense"
                                    :data-expenseId="expense.id"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-around mt-2">
            <Link v-if="expenses.links.next" class="ctm-btn p-1 rounded shadow" :href="expenses.links.next">الصفحة التالية</Link>
            <Link v-if="expenses.links.prev" class="ctm-btn p-1 rounded shadow" :href="expenses.links.prev">الصفحة السابقة</Link>
        </div>
    </div>
</template>
<script setup>
import Navbar from '../components/Navbar.vue'
import Sidebar from '../components/Sidebar.vue'
import { Link, router } from '@inertiajs/vue3';
defineProps({ expenses: Object })
let deleteExpense = e => {
    let el = e.currentTarget;
    if (confirm('هل انت متأكد من حذف هذا المصروف'))
        router.delete(`expenses/${el.getAttribute('data-expenseId')}`)
}
</script>