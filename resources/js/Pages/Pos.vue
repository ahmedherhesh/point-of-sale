<template>
    <navbar />
    <sidebar />
    <div class="content">
        <div class="filter d-flex gap-2">
            <select class="form-select">
                <option value="">الأقسام</option>
                <option v-for="cat in categories" :value="cat.id">{{ cat.name }}</option>
            </select>
            <select class="form-select">
                <option value="">الشركات</option>
                <option v-for="company in companies" :value="company.id">{{ company.name }}</option>
            </select>
            <input type="search" class="form-control" placeholder="بحث بالكود / العنوان">
        </div>
        <div class="d-flex gap-2">

            <div class="items-section ctm-form justify-content-center m-0 d-flex flex-wrap gap-2 mt-2">
                <div v-for="item in items" class="item border rounded text-right p-1">
                    <h5>{{ item.title }}</h5>
                </div>
            </div>
            <div class="cart-section  w-100 mt-2 p-2 ctm-form">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">المنتج</th>
                            <th scope="col">السعر</th>
                            <th scope="col">الكمية</th>
                            <th scope="col">الإجمالي</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@mdo</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Larry the Bird</td>
                            <td>@mdo</td>
                            <td>@twitter</td>
                            <td>@twitter</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script setup>
defineProps({ items: Object, categories: Object, companies: Object })

import Navbar from './components/NavBar.vue'
import Sidebar from './components/Sidebar.vue'
</script>