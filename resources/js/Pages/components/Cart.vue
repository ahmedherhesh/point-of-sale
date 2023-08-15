<template>
    <div class="cart-section col-lg-5 col-sm-12 mt-2 p-2 bg-light rounded">
        <div class="cart-items">
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
        <div class="row  customer-info pt-2">
            <div class="col-md-6 col-sm-12 mb-2">
                <input class="form-control" type="text" v-model="saleForm.customer_name" placeholder="اسم العميل">
            </div>
            <div class="col-md-6 col-sm-12">
                <input class="form-control" type="text" v-model="saleForm.customer_phone" placeholder="رقم المحمول">
            </div>
        </div>
        <div class="final-price-section row align-items-center">
            <div class="col-md-6 col-sm-12">
                <input type="number" min="0" class="discount form-control m-2 me-0" placeholder="الخصم" @input="totalPrice"
                    v-model="saleForm.discount">
            </div>
            <h5 class="col-md-6 col-sm-12 final-price"><span>الإجمالي</span> : <span id="finalPrice">0</span>
            </h5>
        </div>
        <div class="cart-controller d-flex justify-content-center align-items-center gap-2">
            <button class="btn ctm-btn" @click="sale">{{ operation ? 'حفظ' : 'بيع' }}</button>
            <button class="btn btn-danger" @click="cancel">إلغاء</button>
        </div>
    </div>
</template>
<style>
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
<script setup>
defineProps({ operation: Object })
import { useForm } from '@inertiajs/vue3';
import { totalPrice, saleForm, cartEls } from '../../main';
import { usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';
let props = usePage().props;
onMounted(() => {
    cancel();
    if (props.operation) {
        saleForm.customer_name = props.operation.data.customer_name ?? '';
        saleForm.customer_phone = props.operation.data.customer_phone ?? '';
        saleForm.discount = props.operation.data.discount ?? 0;
        let operation_sales = props.operation.data.sales ?? [];
        operation_sales.forEach(sale => {
            let itemId = parseFloat(sale.item_id)
            if (!cartEls.includes(sale.item_id)) {
                cartEls.push(itemId)
                tbody.innerHTML += ` <tr class='cart-item' data-id="${itemId}">
                                        <td class='text-center'>${sale.item.title}</td>
                                        <td class='price text-center'>${sale.sale_price}</td>
                                        <td class='d-flex justify-content-center'>
                                            <span class='increment-btn bg-dark'>+</span>
                                            <span class="ms-2 me-2 qty" data-max='${sale.item.stock}'>${sale.qty}</span>
                                            <span class='decrement-btn bg-dark'>-</span>
                                        </td>
                                        <td class='total-price text-center'>${sale.sale_price * sale.qty}</td>
                                        <td class="close-btn text-center" data-id="${itemId}"><img src="/imgs/close.svg" width="30"></td>
                                     </tr>`
            }
            totalPrice();
        })
    }
})

// controller for cart qty 
const qtyController = (el, operator) => {
    const parent = el.parentElement;
    let qty = parseInt(el.innerText)
    let maxQty = parseInt(el.dataset.max)
    if (qty >= maxQty || (qty <= 1 && operator == '-')) return;
    el.innerText = operator == '+' ? qty + 1 : qty - 1;
    const grandParent = parent.parentElement
    grandParent.querySelector('.total-price').innerText = parseInt(grandParent.querySelector('.price').innerText) * parseInt(el.innerText)
}

const sale = e => {
    saleForm.items = []
    let cartItems = document.querySelectorAll('.cart-item');
    cartItems.forEach(el => {
        let id = parseFloat(el.dataset.id);
        let qty = parseFloat(el.querySelector('.qty').innerText);
        saleForm.items.push({ id, qty })
    })
    saleForm.discount = saleForm.discount || 0
    console.log(saleForm);
    useForm(saleForm).post('/sale')
    cancel();
}

const removeFromCart = e => {
    let el = e.currentTarget;
    let itemId = el.dataset.id;
    cartEls.pop(itemId)
    el.parentElement.remove()
    totalPrice();
}

const cancel = e => {
    cartEls.splice(0, cartEls.length)
    tbody.innerHTML = '';
    saleForm.customer_name = ''
    saleForm.customer_phone = ''
    saleForm.discount = 0
}

document.onclick = e => {
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