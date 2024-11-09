<template>
    <Navbar :setting="setting" />
    <Sidebar />
    <div class="content">
        <div class="table-responsive shadow">
            <table class="table table-light table-hover table-bordered align-middle text-center m-auto">
                <thead class="table-indigo">
                    <tr>
                        <th class="text-center" scope="row">#</th>
                        <th class="text-center" scope="row">الاسم</th>
                        <th class="text-center" scope="row">رقم المحمول</th>
                        <th class="text-center" scope="col">العنوان</th>
                        <th class="text-center" scope="col">الرقم القومي</th>
                        <th class="text-center btns-controller" scope="col">تعديل</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <tr v-for="(client, i) in clients.data">
                        <td scope="row">{{ ++i }}</td>
                        <td scope="row">{{ client.name }}</td>
                        <td scope="row">{{ client.phone }}</td>
                        <td scope="row">{{ client.address }}</td>
                        <td scope="row">{{ client.national_id }}</td>
                        <td scope="col" class="btns-controller">
                            <div class="d-flex justify-content-center gap-2">
                                <Link :href="`/clients/${client.id}/edit`" class="text-secondary btn p-0 edit-btn">
                                <i class="fa-solid fa-pen-to-square"></i>
                                </Link>
                                <button @click="deleteClient(client.id)" class="text-secondary btn delete-btn p-0">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <PrintButton />
        <Pagination :links="clients.links" />
    </div>
</template>
<style>
#tbody .item-img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 50%;
}
</style>
<script setup>
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';
import Pagination from '../components/Pagination.vue';
import { Link, router } from '@inertiajs/vue3';
import PrintButton from '../components/PrintButton.vue';
defineProps({
    errors: Object,
    clients: Object,
    setting: Object
})
let deleteClient = clientId => {
    if (confirm('هل انت متأكد من حذف هذا العميل'))
        router.delete(`clients/${clientId}`)
}
</script>