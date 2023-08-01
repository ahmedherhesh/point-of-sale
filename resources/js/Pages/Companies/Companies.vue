<template>
    <navbar />
    <sidebar />
    <div class="content">
        <div class="table-responsive shadow">
            <table class="table table-light table-hover table-bordered align-middle text-center m-auto mb-5">
                <thead class="table-indigo">
                    <tr>
                        <th>#</th>
                        <th>الإسم</th>
                        <th>تعديل</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(company, i) in companies.data">
                        <td>{{ i + 1 }}</td>
                        <td>{{ company.name }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <button class="text-secondary btn p-0 edit-btn"><i
                                        class="fa-solid fa-pen-to-square"></i></button>
                                <button type="submit" class="text-secondary btn delete-btn p-0" data-type="المستخدم"><i
                                        class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script setup>
import Navbar from '../components/Navbar.vue'
import Sidebar from '../components/Sidebar.vue'
defineProps({ companies: Object })
</script>