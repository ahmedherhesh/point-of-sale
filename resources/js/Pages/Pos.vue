<template>
    <navbar />
    <sidebar />
    <div class="content">
        <div class="filter d-flex gap-2">
            <input type="search" class="form-control" placeholder="بحث بالكود / العنوان">
            <select class="form-select">
                <option value="">الأقسام</option>
                <option v-for="cat in categories" :value="cat.id">{{ cat.name }}</option>
            </select>
            <select class="form-select">
                <option value="">الشركات</option>
                <option v-for="company in companies" :value="company.id">{{ company.name }}</option>
            </select>
        </div>
        <div class="d-flex gap-2">
            <div class="items-section ctm-form justify-content-center m-0 d-flex flex-wrap gap-2 mt-2">
                <div v-for="item in items" @click="addToCart" class="item border rounded text-right p-1 position-relative"
                    :data-id="item.id"
                    :style="cartEls.includes(item.id) ? 'border-color:var(--border-color) !important' : 'border:1px solid #dee2e6!important'"
                    :data-title="item.title" :data-price="item.price" :data-stock="item.qty">
                    <span class="position-absolute top-0 start-0 badge p-1 rounded"
                        :class="item.qty > 10 ? 'bg-dark' : 'bg-danger'">{{ item.qty }}</span>
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
</style>
<script setup>
defineProps({ items: Object, categories: Object, companies: Object })
import { reactive } from 'vue'
import Navbar from './components/NavBar.vue'
import Sidebar from './components/Sidebar.vue'

let increment = 0;
let cartEls = reactive([]);
const addToCart = e => {
    let el = e.currentTarget;
    let itemId = el.dataset.id;
    if (!cartEls.includes(itemId)) {
        cartEls.push(parseInt(itemId))
        tbody.innerHTML += ` <tr>
                                <th scope="row">${++increment}</th>
                                <td>${el.dataset.title}</td>
                                <td>${el.dataset.price}</td>
                                <td><input class="form-control" type="number" value="1" min="1" max="${el.dataset.stock}" style="width: 75px;"></td>
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
    cartEls.splice(0,cartEls.length)
    tbody.innerHTML = '';
    increment = 0;
}
</script>