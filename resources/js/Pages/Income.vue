<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {ref} from "vue";

defineProps({
    incomes: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex gap-2">
                <a :href="route('dashboard')" class="btn btn-primary btn-sm">Dashboard</a>
                <a :href="route('courses.index')" class="btn btn-primary btn-sm">Courses</a>
                <div class="dropdown dropdown-hover">
                    <label tabindex="0" class="btn btn-primary btn-sm">Withdrawn</label>
                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a :href="route('withdraw.create')">Create New</a></li>
                        <li><a :href="route('withdraw.index')">View All</a></li>
                    </ul>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl overflow-auto mx-auto sm:px-6 lg:px-8">
                <table class="table">
                    <!-- head -->
                    <thead class="text-xl">
                    <tr>
                        <th>Cus. Phone</th>
                        <th>Cus. Name</th>
                        <th>Sale Price</th>
                        <th>Percent</th>
                        <th>Income</th>
                        <th>Date Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- row 1 -->
                    <tr v-for="(income, index) in incomes.data" :key="index">
                        <td>{{ income.customer_phone }}</td>
                        <td>{{ income.customer_name }}</td>
                        <td>{{ income.sale_price }}</td>
                        <td>{{ income.percent }}</td>
                        <td>{{ income.income }}</td>
                        <td>{{ income.created_at }}</td>
                    </tr>
                    </tbody>
                </table>
                <div class="flex flex-col justify-center items-center mt-4">
                    <div class="join">
                        <button class="join-item btn"
                                :disabled="!incomes.links.prev"
                                @click="$inertia.visit(incomes.links.prev)"
                        >«</button>
                        <button class="join-item btn">Page {{ incomes.meta.current_page }} of {{ incomes.meta.last_page }}</button>
                        <button class="join-item btn"
                                :disabled="!incomes.links.next"
                                @click="$inertia.visit(incomes.links.next)"
                        >»</button>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">Showing {{ incomes.meta.from }} to {{ incomes.meta.to }} out of {{ incomes.meta.total }} results</p>
                </div>
            </div>


        </div>
    </AuthenticatedLayout>
</template>
<style scoped>
    .table thead tr th {
        color: #121315;
    }
    .table tbody tr td {
        color: #121315;
    }
</style>
