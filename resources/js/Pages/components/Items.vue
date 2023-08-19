<template>
    <div class="items-section col-lg-6 col-sm-12 bg-light justify-content-center align-items-center m-0 d-flex flex-wrap gap-2 p-2 mt-2 rounded"
        style="max-height: 500px ;">
        <div v-for="item in items.data" @click="addToCart" class="item border rounded text-right position-relative"
            :data-id="item.id"
            :style="cartEls.includes(item.id) ? 'border-color:var(--border-color) !important' : 'border:1px solid #dee2e6!important'"
            :data-title="item.title" :data-price="item.sale_price" :data-stock="item.stock">
            <span class="position-absolute top-0 start-0 badge p-1 rounded"
                :class="item.stock > 10 ? 'bg-dark' : 'bg-danger'">{{ item.stock }}</span>
            <span class="position-absolute top-0 end-0 badge p-1 rounded bg-primary">${{ item.sale_price
            }}</span>
            <div class="d-flex justify-content-center">
                <img :src="item.image" class="rounded" alt="" srcset="">
            </div>
            <h5 class="p-1">{{ item.title }}</h5>
        </div>
    </div>
</template>
<style>
.items-section {
    max-height: 500px;
    overflow-y: scroll;
}

.items-section .item {
    cursor: pointer;
}
.items-section .item img {
    width: 100%;
    height: 100px;
    object-fit: cover;
}
</style>
<script setup>
defineProps({items:Object})
import { totalPrice,cartEls } from '../../main';
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
                                <td class="close-btn text-center" data-id="${itemId}"><img src="/imgs/close.svg" width="30"></td>
                             </tr>`
    }
    totalPrice();
}
</script>