<template>
    <navbar />
    <sidebar />
    <div class="content">
        <div class="profit-sections p-2 row gap-2 justify-content-center">
            <div class="col-lg-2 col-md-4 col-sm-5 text-center">
                <h4>أرباح الشهر</h4>
                <span>{{ monthProfits.profits }}</span>
                <span class="money-icon"> <i class="fa-solid fa-dollar-sign me-1"></i> </span>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-5 text-center">
                <h4>أرباح 3 أشهر</h4>
                <span>{{ threeMonthProfits.profits }}</span>
                <span class="money-icon"> <i class="fa-solid fa-dollar-sign me-1"></i> </span>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-5 text-center">
                <h4>أرباح 6 أشهر</h4>
                <span>{{ sixMonthProfits.profits }}</span>
                <span class="money-icon"> <i class="fa-solid fa-dollar-sign me-1"></i> </span>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-5 text-center">
                <h4>أرباح السنة</h4>
                <span>{{ yearProfits.profits }}</span>
                <span class="money-icon"> <i class="fa-solid fa-dollar-sign me-1"></i> </span>
            </div>
        </div>
        <div class="profits-calc d-flex align-items-center flex-column m-auto mt-3">
            <form @submit.prevent="profitsFilter" class="date-filter mt-2 mb-2 d-flex justfy-content-center  gap-2">
                <div class="d-flex justify-content-center">
                    <label for="from" class="mb-1 w-25">من:</label>
                    <input class="form-control w-75" name="from" id="from" type="date" v-model="dateForm.from"
                        min="2000-01-01">
                </div>
                <div class="d-flex justify-content-center">
                    <label for="to" class="mb-1 w-25">إلى:</label>
                    <input class="form-control w-75" name="to" id="to" type="date" v-model="dateForm.to" min="2000-01-01">
                </div>
                <button class="btn btn-indigo" id="submitBtn">بحث</button>
            </form>
        </div>
        <div class="table-responsive shadow mt-3">
            <table class="table table-light table-hover table-bordered align-middle text-center m-auto">
                <thead class="table-indigo">
                    <tr>
                        <th class="text-center" scope="row">اجمالي سعر البيع</th>
                        <th class="text-center" scope="row">اجمالي سعر الشراء</th>
                        <th class="text-center" scope="col">اجمالي المصروفات</th>
                        <th class="text-center" scope="col">اجمالي الخصومات</th>
                        <th class="text-center" scope="col">اجمالي الأرباح</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <tr>
                        <td scope="row">{{ allProfits.sale_price }}</td>
                        <td scope="row">{{ allProfits.price }}</td>
                        <td scope="col">{{ expenses }}</td>
                        <td scope="col">{{ allProfits.discounts }}</td>
                        <td scope="col">{{ allProfits.profits }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table-responsive shadow mt-3">
            <table class="table table-light table-hover table-bordered align-middle text-center m-auto">
                <thead class="table-indigo">
                    <tr>
                        <th class="text-center" scope="row">#</th>
                        <th class="text-center" scope="row">اسم العميل</th>
                        <th class="text-center" scope="col">رقم المحمول</th>
                        <th class="text-center" scope="col">سعر الشراء</th>
                        <th class="text-center" scope="col">سعر البيع</th>
                        <th class="text-center" scope="col">الخصم</th>
                        <th class="text-center" scope="col">الربح</th>
                        <th class="text-center" scope="col">تاريخ العملية</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <tr v-for="(operation) in operations.data">
                        <td scope="row">{{ operation.id }}</td>
                        <td scope="row">{{ operation.customer_name ?? '-----' }}</td>
                        <td scope="col">{{ operation.customer_phone ?? '-----' }}</td>
                        <td scope="col">{{ operation.price }}</td>
                        <td scope="col">{{ operation.sale_price }}</td>
                        <td scope="col">{{ operation.discount ?? 0 }}</td>
                        <td scope="col">{{ operation.profits }}</td>
                        <td scope="col">{{ operation.created_at }}</td>
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
<style>
.profit-sections>*,
.profits-calc {
    padding: 20px;
    box-shadow: var(--box-shadow);
    background-color: #fff;
    border-radius: 10px;
    /* color:#fff; */

}

.profit-sections>* {
    color: #fff;
}

.profit-sections>*:nth-child(1) {
    background-color: #3498db;
}

.profit-sections>*:nth-child(2) {
    background-color: #1abc9c;
}

.profit-sections>*:nth-child(3) {
    background-color: #40739e
}

.profit-sections>*:nth-child(4) {
    background-color: var(--main-color);
}

.profits-calc {
    max-width: 30rem;
    transition: height .5s;
}

.spinner {
    animation: spinner 60s;
}

@keyframes spinner {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360000000deg);
    }
}
</style>
<script setup>
import axios from 'axios';
import Navbar from './components/Navbar.vue';
import Sidebar from './components/Sidebar.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { onMounted, reactive } from 'vue';

defineProps({
    allProfits: Object,
    expenses: Number,
    monthProfits: Object,
    threeMonthProfits: Object,
    sixMonthProfits: Object,
    yearProfits: Object,
    operations: Object
})
let props = usePage().props;
let dateForm = reactive({
    from: '',
    to: ''
})
let loading = false;
const profitsFilter = () => {
    if (loading == false && (dateForm.from || dateForm.to)) {
        loading = true;
        submitBtn.innerHTML = `<i class="fa-solid fa-spinner spinner"></i>`
        axios.post('/profits-filter', dateForm).then(res => {
            loading = false;
            submitBtn.innerHTML = `بحث`
            props.allProfits = res.data.allProfits
            props.operations.data = res.data.operations
            props.expenses = res.data.expenses
        }).catch(err => {
            loading = false;
            submitBtn.innerHTML = `بحث`
        })
    }
}
</script>