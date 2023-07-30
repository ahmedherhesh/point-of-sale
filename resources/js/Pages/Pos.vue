<template>
    <navbar />
    <sidebar />
    <div class="content">
        <div class="filter d-flex gap-2">
            <input type="search" class="form-control" :class="errors.code ? 'border-danger' : ''" placeholder="بحث بالكود"
                v-model="filterForm.code" @input="itemsFilter">
            <input type="search" class="form-control" placeholder="بحث العنوان" v-model="filterForm.title"
                @input="itemsFilter">
            <select class="form-select" @change="itemsFilter" v-model="filterForm.cat_id">
                <option value="">الأقسام</option>
                <option v-for="cat in categories" :value="cat.id">{{ cat.name }}</option>
            </select>
            <select class="form-select" @change="itemsFilter" v-model="filterForm.company_id">
                <option value="">الشركات</option>
                <option v-for="company in companies" :value="company.id">{{ company.name }}</option>
            </select>
        </div>
        <div class="d-flex flex-wrap justify-content-center gap-2">
            <div
                class="items-section w-50 ctm-form justify-content-center align-items-center m-0 d-flex flex-wrap gap-2 mt-2">
                <div v-for="item in items" @click="addToCart" class="item border rounded text-right p-1 position-relative"
                    :data-id="item.id"
                    :style="cartEls.includes(item.id) ? 'border-color:var(--border-color) !important' : 'border:1px solid #dee2e6!important'"
                    :data-title="item.title" :data-price="item.price_of_sale" :data-stock="item.stock">
                    <span class="position-absolute top-0 start-0 badge p-1 rounded"
                        :class="item.stock > 10 ? 'bg-dark' : 'bg-danger'">{{ item.stock }}</span>
                    <span class="position-absolute top-0 end-0 badge p-1 rounded bg-primary">${{ item.price_of_sale
                    }}</span>
                    <div class="d-flex justify-content-center">
                        <img src="imgs/logo-80.png" alt="" srcset="">
                    </div>
                    <h5>{{ item.title }}</h5>
                </div>
            </div>
            <div class="cart-section  w-100 mt-2 p-2 ctm-form">
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
                <div class="final-price-section d-flex align-items-center">
                    <input type="number" min="0" class="discount form-control m-2 w-50" placeholder="الخصم"
                        @input="totalPrice" v-model="discount">
                    <h5 class="w-50 final-price"><span>الإجمالي</span> : <span id="finalPrice">0</span>
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

.items-section.ctm-form {
    max-height: 500px;
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
import { usePage } from '@inertiajs/vue3';
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
        items: []
    };

const totalPrice = () => {
    let result = 0;
    $('.total-price').each(function () {
        result += parseFloat($(this).text())
    })
    $('#finalPrice').text(result - (parseFloat(discount._value) || 0));
};

const itemsFilter = () => {
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
    let itemId = el.dataset.id;
    if (!cartEls.includes(itemId)) {
        cartEls.push(parseInt(itemId))
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
const sale = e => {
    saleForm.items = []
    let cartItems = document.querySelectorAll('.cart-item');
    cartItems.forEach(el => {
        let id = parseFloat(el.dataset.id);
        let qty = parseFloat(el.querySelector('.qty').innerText);
        saleForm.items.push({ id, qty })
    })
    saleForm.discount = discount._value || 0
    console.log(saleForm);
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
}

$('body').on('click', '.increment-btn', function () {
    const self = $(this);
    const next = self.next();
    const parent = next.parent();
    if (next.text() < next.data('max'))
        next.text(parseInt(next.text()) + 1);
    parent.siblings('.total-price').text(parseInt(parent.siblings('.price').text()) * parseInt(next.text()))
    totalPrice();

})

$('body').on('click', '.decrement-btn', function () {
    const self = $(this);
    const prev = self.prev();
    const parent = prev.parent();
    if (prev.text() > 1)
        prev.text(parseInt(prev.text()) - 1)
    parent.siblings('.total-price').text(parseInt(parent.siblings('.price').text()) * parseInt(prev.text()))
    totalPrice();

})

$('body').on('click', '.close-btn', removeFromCart)

</script>