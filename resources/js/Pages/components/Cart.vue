<script setup>
defineProps({ operation: Object })
import { totalPrice, saleForm, cartEls } from '../../main';
import { usePage, Link, router } from '@inertiajs/vue3';
import { onMounted, reactive, ref } from 'vue';
import ToggleSwitch from 'primevue/toggleswitch';
import Loading from '../components/Loading.vue';
let props = usePage().props;
let invoice_data = reactive({ invoice_id: 0 });
const isWholeSale = ref(false);
onMounted(() => {
    cancel();
    if (props.operation) {
        let { customer_name, customer_phone, discount, is_whole_sale, sales } = props.operation.data
        saleForm.customer_name = customer_name;
        saleForm.customer_phone = customer_phone;
        saleForm.discount = discount || '';
        saleForm.is_whole_sale = is_whole_sale;
        let operation_sales = sales;
        operation_sales.forEach(sale => {
            let itemId = parseFloat(sale.item_id)
            if (!cartEls.includes(sale.item_id)) {
                cartEls.push(itemId)
                tbody.innerHTML += ` <tr class='cart-item' data-id="${itemId}">
                                        <td class='text-center'>${sale.item.title}</td>
                                        <td class='price text-center'>${sale.sale_price}</td>
                                        <td class='counter'>
                                            <div class='d-flex justify-content-center'>
                                                <span class='increment-btn bg-dark'>+</span>
                                                <span class="ms-2 me-2 qty" data-max='${sale.item.stock + sale.qty}'>${sale.qty}</span>
                                                <span class='decrement-btn bg-dark'>-</span>
                                            </div>
                                        </td>
                                        <td class='total-price text-center'>${sale.sale_price * sale.qty}</td>
                                        <td class="close-btn text-center" data-id="${itemId}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" height="40" viewBox="0 -960 960 960" width="30">
                                                <path d="m249-207-42-42 231-231-231-231 42-42 231 231 231-231 42 42-231 231 231 231-42 42-231-231-231 231Z" />
                                            </svg>
                                        </td>
                                     </tr>`
            }
            totalPrice();
        })
    }
})

// controller for cart qty 
const qtyController = (el, operator) => {
    let qty = parseInt(el.innerText)
    let maxQty = parseInt(el.dataset.max)
    if (operator == '+' && qty != maxQty)
        el.innerText = qty + 1;
    else if (operator == '-' && qty > 1)
        el.innerText = qty - 1;
    const cartItem = el.closest('.cart-item');
    cartItem.querySelector('.total-price').innerText = parseInt(cartItem.querySelector('.price').innerText) * parseInt(el.innerText)
}

const sale = e => {
    if (saleForm.processing) return;
    let btn = e.target;
    saleForm.items = []
    let cartItems = document.querySelectorAll('.cart-item');
    cartItems.forEach(el => {
        let id = parseFloat(el.dataset.id);
        let qty = parseFloat(el.querySelector('.qty').innerText);
        saleForm.items.push({ id, qty })
    })
    saleForm.discount = saleForm.discount || 0
    if (saleForm.items.length) {
        if (props.operation) {
            saleForm.put(`/sales/${props.operation.data.id}`)
        }
        else {
            saleForm.post('/sale')
            cancel();
        }
    }
}

const removeFromCart = e => {
    let el = e.currentTarget;
    let itemId = el.dataset.id;
    const index = cartEls.findIndex(item => item == itemId);

    if (index !== -1) {
        cartEls.splice(index, 1);
    }
    el.parentElement.remove()
    totalPrice();
}

const cancel = e => {
    cartEls.splice(0, cartEls.length)
    tbody.innerHTML = '';
    saleForm.customer_name = ''
    saleForm.customer_phone = ''
    saleForm.discount = '';
    totalPrice();
}
const cancelPrint = () => {
    router.get(window.location.href)
}
document.body.onclick = e => {
    let el = e.target;
    if (el.classList.contains('increment-btn')) {
        const next = el.nextElementSibling;
        qtyController(next, '+')
    } else if (el.classList.contains('decrement-btn')) {
        const prev = el.previousElementSibling;
        qtyController(prev, '-')
    }
    totalPrice()
}
$('body').on('click', '.close-btn', removeFromCart);
</script>
<template>
    <div class="cart-section col-lg-5 col-sm-12 mt-2 p-2 bg-light rounded">
        <div class="is-whole-sale d-flex align-items-center gap-2">
            <ToggleSwitch v-if="!props.operation" v-model="isWholeSale" @change="(e) => {
                saleForm.is_whole_sale = isWholeSale;
                cancel()
            }" />
            <h4 v-if="(props.operation && saleForm.is_whole_sale) || !props.operation" class="text-center font-bold">بيع
                بالجملة</h4>
        </div>
        <div class="cart-items">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center" scope="row">المنتج</th>
                            <th class="text-center" scope="col">السعر</th>
                            <th class="text-center" scope="col">الكمية</th>
                            <th class="text-center" scope="col">الإجمالي</th>
                            <th class="text-center" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody id="tbody"></tbody>
                </table>
            </div>
        </div>
        <div class="row  customer-info pt-2">
            <div class="col-md-6 col-sm-12 mb-2">
                <input class="form-control" type="text" v-model="saleForm.customer_name" placeholder="اسم العميل">
            </div>
            <div class="col-md-6 col-sm-12">
                <input class="form-control" type="text" v-model="saleForm.customer_phone" placeholder="رقم المحمول">
            </div>
        </div>
        <div class="cost-section row align-items-center">
            <div class="col-md-6 col-sm-12">
                <input type="number" min="0" class="left-cost form-control m-2 me-0" placeholder="المدفوع"
                    @input="totalPrice">
            </div>
            <h5 class="col-md-6 col-sm-12 final-price"><span>المتبقي</span> : <span id="leftCost">0</span>
            </h5>
        </div>
        <div class="final-price-section row align-items-center">
            <div class="col-md-6 col-sm-12">
                <input type="number" min="0" class="discount form-control m-2 me-0" placeholder="الخصم"
                    @input="totalPrice" v-model="saleForm.discount">
            </div>
            <h5 class="col-md-6 col-sm-12 final-price"><span>الإجمالي</span> : <span id="finalPrice">0</span>
            </h5>
        </div>
        <div class="cart-controller d-flex justify-content-center align-items-center gap-2">
            <button class="btn ctm-btn" @click="sale" :data-title="operation ? 'حفظ' : 'بيع'">
                <span>{{ operation ? 'حفظ' : 'بيع' }}</span>
                <!-- <Loading v-if="saleForm.processing" /> -->
            </button>
            <button class="btn btn-danger" @click="cancel">إلغاء</button>
        </div>
    </div>
    <div v-if="$page.props.flash.operation_id" class="outlay" id="outlay">
        <Link :href="`/sales/${$page.props.flash.operation_id}`" class="print_invoice btn btn-indigo">طباعة</Link>
        <a class="cancel_print btn btn-danger" @click="cancelPrint">إلغاء</a>
    </div>
</template>
<style>
.outlay {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 100%;
    background-color: rgb(0, 0, 0, .7);
    z-index: 10000;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
}

.cart-items {
    min-height: 200px;
    max-height: 300px;
    overflow-y: scroll;
}

.items-section {
    max-height: 500px;
    overflow-y: scroll;
}

.items-section .item {
    cursor: pointer;
}

.close-btn {
    cursor: pointer;
}

.increment-btn,
.decrement-btn {
    cursor: pointer;
    height: 30px;
    width: 30px;
    border-radius: 50%;
    text-align: center;
    font-size: 20px;
    font-weight: bold;
    color: #fff;
    box-shadow: var(--box-shadow);
}
</style>
