<template>
    <navbar :setting="setting" />
    <sidebar />
    <div class="content">
        <DateFilter path="extra-profits" />
        <div class="table-responsive shadow" style="min-width: 600px;">
            <h4 class="text-center p-2"> إجمالي الأرباح الإضافية : {{ sumExtraProfits }}</h4>
            <table class="table table-light table-hover table-bordered align-middle text-center m-auto">
                <thead class="table-indigo">
                    <tr>
                        <th>#</th>
                        <th>العنوان</th>
                        <th>المبلغ</th>
                        <th>التاريخ</th>
                        <th class="btns-controller">تعديل</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(extraProfit, i) in extraProfits.data">
                        <td>{{ i + 1 }}</td>
                        <td>{{ extraProfit.title }}</td>
                        <td>{{ extraProfit.amount }}</td>
                        <td>{{ extraProfit.created_at.split('T')[0] }}</td>
                        <td class="btns-controller">
                            <div class="d-flex justify-content-center gap-2">
                                <Link :href="`/extra-profits/${extraProfit.id}/edit`"
                                    class="text-secondary btn p-0 edit-btn"><i class="fa-solid fa-pen-to-square"></i></Link>
                                <button class="text-secondary btn delete-btn p-0" @click="deleteExtraProfit"
                                    :data-extraProfitId="extraProfit.id"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <PrintButton />
        <Pagination :links="extraProfits.links" />

    </div>
</template>
<script setup>
import Navbar from '../components/Navbar.vue'
import Sidebar from '../components/Sidebar.vue'
import Pagination from '../components/Pagination.vue';
import { Link, router } from '@inertiajs/vue3';
import PrintButton from '../components/PrintButton.vue';
import DateFilter from '../components/DateFilter.vue';
defineProps({ extraProfits: Object, sumExtraProfits: String })
let deleteExtraProfit = e => {
    let el = e.currentTarget;
    if (confirm('هل انت متأكد من حذف هذا الربح الإضافي'))
        router.delete(`extra-profits/${el.getAttribute('data-extraProfitId')}`)
}
</script>