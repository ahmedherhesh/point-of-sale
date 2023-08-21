<template>
    <div class="invoice">
        <div class="invoice-header d-flex justify-content-around align-items-center pe-2">
            <h3 class="">فاضل فون</h3>
            <!-- <img src="/imgs/logo.gif" width="90" alt=""> -->
        </div>
        <p :class="invoice.data.customer_name && invoice.data.customer_phone ? 'd-flex justify-content-between' : ''">
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
                        <td scope="col" :data-total="totalPrice += (sale.qty * sale.sale_price)">{{ sale.qty * sale.sale_price }}</td>
                    </tr>
                </tbody>
            </table>
            <span class="d-block span-border mt-4 mb-4"></span>
            <div class="total-price" :class="invoice.data.discount ? 'd-flex justify-content-between' : ''">
                <h5> الإجمالي : {{ totalPrice - invoice.data.discount }}</h5>
                <h5 v-if="invoice.data.discount"> الخصم : {{ invoice.data.discount }}</h5>
            </div>
            <div class="barcode mt-5 d-flex flex-column align-items-end" v-html="barcode"></div>
        </div>
    </div>
</template>
<style>
.invoice {
    border: 5px solid gray;
    /* min-height: 500px; */
    max-width: 500px;
    min-width: 400px;
    margin: 50px auto 0;
    position: relative;
    padding: 20px;
    padding-top: 60px;
}

.invoice .invoice-header {
    --width: calc(100% - 50px);
    position: absolute;
    top: -25px;
    left: calc(50% - (var(--width)/ 2));
    background-color: gray;
    height: 50px;
    width: var(--width);
    color: #fff;
}
.span-border{
    height: 1px;
    background-color: gray;
}
</style>
<script setup>

defineProps({ invoice: Object,barcode:String })
let totalPrice = 0
</script>