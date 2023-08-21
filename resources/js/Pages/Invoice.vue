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
                <thead class="table-indigo">
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
                        <td scope="col" :data-calc="totalPrice += (sale.qty * sale.sale_price)">{{ sale.qty * sale.sale_price }}</td>
                    </tr>
                </tbody>
            </table>
            <span class="d-block span-border mt-4 mb-4"></span>
            <div class="total-price">
               <h4> الإجمالي : {{ totalPrice }}</h4>
            </div>
        </div>
    </div>
</template>
<style>
.invoice {
    border: 5px solid var(--main-color);
    min-height: 500px;
    max-width: 500px;
    min-width: 400px;
    margin: 60px auto 0;
    position: relative;
    padding: 20px;
    padding-top: 60px;
}

.invoice .invoice-header {
    --width: calc(100% - 50px);
    position: absolute;
    top: -50px;
    left: calc(50% - (var(--width)/ 2));
    background-color: var(--main-color);
    height: 100px;
    width: var(--width);
    color: #fff;
}
.span-border{
    height: 2px;
    background-color: var(--main-color);

}
</style>
<script setup>

defineProps({ invoice: Object })
let totalPrice = 0
</script>