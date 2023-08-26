<template>
    <navbar />
    <sidebar />
    <div class="content">
        <div class="table-responsive shadow" style="min-width: 600px;">
            <table class="table table-light table-hover table-bordered align-middle text-center m-auto">
                <thead class="table-indigo">
                    <tr>
                        <th>#</th>
                        <th>الإسم</th>
                        <th>الصلاحية</th>
                        <th>الحالة</th>
                        <th class="btns-controller">تعديل</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, i) in users.data">
                        <td>{{ i + 1 }}</td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.role }}</td>
                        <td>{{ user.status }}</td>
                        <td class="btns-controller">
                            <div class="d-flex justify-content-center gap-2">
                                <Link :href="`/users/${user.id}/edit`" class="text-secondary btn p-0 edit-btn"><i
                                    class="fa-solid fa-pen-to-square"></i></Link>
                                <button class="text-secondary btn delete-btn p-0" @click="deleteUser"
                                    :data-userId="user.id"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <Pagination :links="users.links" />
    </div>
</template>
<script setup>
import Navbar from '../components/Navbar.vue'
import Sidebar from '../components/Sidebar.vue'
import Pagination from '../components/Pagination.vue';
import { Link, router } from '@inertiajs/vue3';
defineProps({ users: Object })
let deleteUser = e => {
    let el = e.currentTarget;
    if (confirm('هل انت متأكد من حذف هذا المستخدم'))
        router.delete(`users/${el.getAttribute('data-userId')}`)
}
</script>