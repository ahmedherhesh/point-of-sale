<template>
    <navbar />
    <sidebar />
    <div class="content">
        <div class="filter row">
            <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                <input type="search" class="form-control"
                    :class="errors.code && filterForm.code.trim() ? 'border-danger' : ''" placeholder="بحث بالكود"
                    v-model="filterForm.code" @input="itemsFilter">
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                <input type="search" class="form-control" placeholder="بحث العنوان" v-model="filterForm.title"
                    @input="itemsFilter">
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                <select class="form-select" @change="itemsFilter" v-model="filterForm.cat_id">
                    <option value="">الأقسام</option>
                    <option v-for="cat in categories" :value="cat.id">{{ cat.name }}</option>
                </select>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                <select class="form-select" @change="itemsFilter" v-model="filterForm.company_id">
                    <option value="">الشركات</option>
                    <option v-for="company in companies" :value="company.id">{{ company.name }}</option>
                </select>
            </div>
        </div>
        <div class="row justify-content-around align-items-start">
            <div
                class="items-section col-lg-6 col-sm-12 bg-light justify-content-center align-items-center m-0 d-flex flex-wrap gap-2 p-2 mt-2 rounded" style="max-height: 500px ;">
                <div v-for="item in items.data" @click="addToCart"
                    class="item border rounded text-right p-1 position-relative" :data-id="item.id"
                    :style="cartEls.includes(item.id) ? 'border-color:var(--border-color) !important' : 'border:1px solid #dee2e6!important'"
                    :data-title="item.title" :data-price="item.sale_price" :data-stock="item.stock">
                    <span class="position-absolute top-0 start-0 badge p-1 rounded"
                        :class="item.stock > 10 ? 'bg-dark' : 'bg-danger'">{{ item.stock }}</span>
                    <span class="position-absolute top-0 end-0 badge p-1 rounded bg-primary">${{ item.sale_price
                    }}</span>
                    <div class="d-flex justify-content-center">
                        <img src="imgs/logo-80.png" alt="" srcset="">
                    </div>
                    <h5>{{ item.title }}</h5>
                </div>
            </div>
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
                        <input type="number" min="0" class="discount form-control m-2 me-0" placeholder="الخصم"
                            @input="totalPrice" v-model="saleForm.discount">
                    </div>
                    <h5 class="col-md-6 col-sm-12 final-price"><span>الإجمالي</span> : <span id="finalPrice">0</span>
                    </h5>
                </div>
                <div class="cart-controller d-flex justify-content-center align-items-center gap-2">
                    <button class="btn ctm-btn" @click="sale">بيع</button>
                    <button class="btn btn-danger" @click="cancel">إلغاء</button>
                </div>
            </div>
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
defineProps({ errors: Object, items: Object, categories: Object, companies: Object })
import { reactive, ref } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3';
import Navbar from './components/NavBar.vue'
import Sidebar from './components/Sidebar.vue'
import axios from 'axios';
let cartEls = reactive([]),
    filterForm = reactive({
        title: '',
        company_id: '',
        cat_id: '',
        code: ''
    }),
    discount = ref(),
    saleForm = {
        discount: 0,
        customer_name: '',
        customer_phone: '',
        items: []
    };

const totalPrice = () => {
    let result = 0;
    $('.total-price').each(function () {
        result += parseFloat($(this).text())
    })
    $('#finalPrice').text(result - (parseFloat(saleForm.discount) || 0));
};

const itemsFilter = e => {
    let page = usePage();
    axios.post('items-filter', filterForm)
        .then(res => {
            page.props.items = res.data
        }).catch(res => {
            page.props.errors = res.response.data.errors
        })
}

const addToCart = e => {
    let el = e.currentTarget;
    let itemId = parseInt(el.dataset.id);
    if (!cartEls.includes(itemId)) {
        cartEls.push(itemId)
        tbody.innerHTML += ` <tr class='cart-item' data-id="${itemId}">
                                <td class='text-center'>${el.dataset.title}</td>
                                <td class='price text-center'>${el.dataset.price}</td>
                                <td class='d-flex justify-content-center'>
                                    <span class='increment-btn bg-dark'>+</span>
                                    <span class="ms-2 me-2 qty" data-max='${el.dataset.stock}'>1</span>
                                    <span class='decrement-btn bg-dark'>-</span>
                                </td>
                                <td class='total-price text-center'>${el.dataset.price}</td>
                                <td class="close-btn text-center" data-id="${itemId}"><img src="imgs/close.svg" width="30"></td>
                             </tr>`
    }
    totalPrice();
}

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