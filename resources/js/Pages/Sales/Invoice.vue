<template>
    <Navbar :setting="setting" />
    <Sidebar />
    <div class="content">
        <div class="invoice">
            <div class="invoice-header d-flex justify-content-around align-items-center pe-2">
                <h3>{{ setting.title || 'POS' }}</h3>
                <!-- <img src="/imgs/logo.gif" width="90" alt=""> -->
            </div>
            <p class="mt-2"
                :class="invoice.data.customer_name && invoice.data.customer_phone ? 'd-flex justify-content-between' : ''">
                <span v-if="invoice.data.customer_name">اسم العميل : {{ invoice.data.customer_name }}</span>
                <span v-if="invoice.data.customer_phone">رقم الهاتف : {{ invoice.data.customer_phone }}</span>
            </p>
            <div class="table-responsive">
                <table class="table table-light table-hover table-bordered align-middle text-center m-auto">
                    <thead class="">
                        <tr>
                            <th class="text-center" scope="row">المنتج</th>
                            <th class="text-center" scope="col">الكمية</th>
                            <th class="text-center" scope="col">السعر</th>
                            <th class="text-center" scope="col">الإجمالي</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        {{ invoice.sales }}
                        <tr v-for="sale in invoice.data.sales">
                            <td scope="col">{{ sale.item.title }}</td>
                            <td scope="col">{{ sale.qty }}</td>
                            <td scope="col">{{ sale.sale_price }}</td>
                            <td scope="col" :data-total="totalPrice += (sale.qty * sale.sale_price)">{{ sale.qty *
                                sale.sale_price }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="total-price mt-3">
                    <h5> الخصم : {{ invoice.data.discount ?? '0.00' }}</h5>
                    <h5> الإجمالي : {{ totalPrice - invoice.data.discount }}</h5>
                </div>
                <div class="barcode d-flex flex-column align-items-end" v-html="barcode"></div>
                <div class="span-border mt-3 mb-3"></div>
                <p class="d-flex flex-column align-items-center">
                    <span><i class="fa-solid fa-location-dot ms-1"></i>{{ setting.address || '' }}</span>
                    <span class="mt-3"><span>للإستفسار -</span> {{ setting.phone || '' }} <i
                            class="fa-solid fa-square-phone me-1"></i></span>
                </p>
            </div>
        </div>
    </div>
</template>
<style>
.content {
    padding: 0;
}

.invoice {
    /* border: 5px solid gray; */
    padding-right: 10px;
    margin: 50px auto;
    position: relative;
    font-size: 14px;
}



h5 {
    font-size: 14px;
}

.invoice .invoice-header {
    border: 1px solid #000;
    height: 40px;
    width: var(--width);
    color: #000;
}

.invoice th,
.invoice td {
    border: 1px solid #000;
}

.invoice .span-border {
    height: 1px;
    background-color: #000;
}
</style>
<script setup>
import { onMounted } from 'vue'
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';
defineProps({ invoice: Object, barcode: String, setting: Object })
let totalPrice = 0
onMounted(() => {
    print()
})
</script>