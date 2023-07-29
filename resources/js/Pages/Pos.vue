<template>
    <navbar />
    <sidebar />
    <div class="content">
        <div class="filter d-flex gap-2">
            <input type="search" class="form-control" :class="errors.code ? 'border-danger' : 'border'"
                placeholder="بحث بالكود" v-model="form.code" @input="itemsFilter">
            <input type="search" class="form-control" placeholder="بحث العنوان" v-model="form.title" @input="itemsFilter">
            <select class="form-select" @change="itemsFilter" v-model="form.cat_id">
                <option value="">الأقسام</option>
                <option v-for="cat in categories" :value="cat.id">{{ cat.name }}</option>
            </select>
            <select class="form-select" @change="itemsFilter" v-model="form.company_id">
                <option value="">الشركات</option>
                <option v-for="company in companies" :value="company.id">{{ company.name }}</option>
            </select>
        </div>
        <div class="d-flex gap-2">
            <div class="items-section ctm-form justify-content-center m-0 d-flex flex-wrap gap-2 mt-2">
                <div v-for="item in items" @click="addToCart" class="item border rounded text-right p-1 position-relative"
                    :data-id="item.id"
                    :style="cartEls.includes(item.id) ? 'border-color:var(--border-color) !important' : 'border:1px solid #dee2e6!important'"
                    :data-title="item.title" :data-price="item.price" :data-stock="item.stock">
                    <span class="position-absolute top-0 start-0 badge p-1 rounded"
                        :class="item.stock > 10 ? 'bg-dark' : 'bg-danger'">{{ item.stock }}</span>
                    <span class="position-absolute top-0 end-0 badge p-1 rounded bg-primary">$100</span>
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
                                <th scope="col">#</th>
                                <th scope="col">المنتج</th>
                                <th scope="col">السعر</th>
                                <th scope="col">الكمية</th>
                                <th scope="col">الإجمالي</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="tbody"></tbody>
                    </table>
                </div>
                <div class="cart-controller d-flex justify-content-center align-items-center gap-2">
                    <button class="btn ctm-btn">بيع</button>
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
import { reactive } from 'vue'
import { usePage } from '@inertiajs/vue3';
import Navbar from './components/NavBar.vue'
import Sidebar from './components/Sidebar.vue'
import axios from 'axios';

let increment = 0;
let cartEls = reactive([]);
let form = reactive({
    title: '',
    company_id: '',
    cat_id: '',
    code: ''
})
const itemsFilter = () => {
    let page = usePage();
    axios.post('items-filter', form)
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
        tbody.innerHTML += ` <tr>
                                <th scope="row">${++increment}</th>
                                <td>${el.dataset.title}</td>
                                <td>${el.dataset.price}</td>
                                <td class='d-flex justify-content-center'>
                                    <span class='increment-btn bg-dark'>+</span>
                                    <span class="ms-2 me-2 qty" data-max='${el.dataset.stock}'>1</span>
                                    <span class='decrement-btn bg-dark'>-</span>
                                </td>
                                <td>${el.dataset.price}</td>
                                <td class="close-btn" data-id="${itemId}"><img src="imgs/close.svg" width="30"></td>
                             </tr>`
        document.querySelectorAll('.close-btn').forEach(btn => {
            btn.onclick = removeFromCart
        })
    }
}

const removeFromCart = e => {
    let el = e.currentTarget;
    let itemId = el.dataset.id;
    cartEls.pop(itemId)
    el.parentElement.remove()
}

const cancel = e => {
    cartEls.splice(0, cartEls.length)
    tbody.innerHTML = '';
    increment = 0;
}
$('body').on('click', '.increment-btn', function () {
    const self = $(this);
    const next = self.next();
    if (next.text() < next.data('max'))
        next.text(parseInt(next.text()) + 1);
})
$('body').on('click', '.decrement-btn', function () {
    const self = $(this);
    const prev = self.prev();
    if (prev.text() != 0)
        prev.text(parseInt(prev.text()) - 1)
})
</script>