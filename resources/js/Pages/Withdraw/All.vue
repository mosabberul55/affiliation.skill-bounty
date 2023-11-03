<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, usePage} from '@inertiajs/vue3';
import {ref} from "vue";

defineProps({
    withdraws: {
        type: Object,
        required: true,
    },
    success: {
        type: Boolean,
        default: false,
    },
    successMessage: {
        type: String,
        default: '',
    },
})
const showToast = ref(usePage().props.success);
if (showToast) {
    setTimeout(() => {
        showToast.value = false;
    }, 2000)
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex gap-2">
                <a :href="route('dashboard')" class="btn btn-primary btn-sm">Dashboard</a>
                <a :href="route('courses.index')" class="btn btn-primary btn-sm">Course</a>
                <a :href="route('income.index')" class="btn btn-primary btn-sm">Income</a>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl overflow-auto mx-auto sm:px-6 lg:px-8">
                <table class="table">
                    <!-- head -->
                    <thead class="text-xl">
                    <tr>
                        <th>Amount</th>
                        <th>MFS</th>
                        <th>Status</th>
<!--                        <th>Transaction Id</th>-->
                        <th>Date Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- row 1 -->
                    <tr v-for="(withdraw, index) in withdraws.data" :key="index">
                        <td>{{ withdraw.amount }}</td>
                        <td>{{ withdraw.mfs }}</td>
                        <td> <strong class="capitalize"
                            :class="{
                                'text-green-800': withdraw.status === 'approved',
                                'text-red-500': withdraw.status === 'rejected',
                                'text-yellow-600': withdraw.status === 'pending',
                            }">{{ withdraw.status }}</strong></td>
<!--                        <td>{{ withdraw.transaction_id }}</td>-->
                        <td>{{ withdraw.created_at }}</td>
                    </tr>
                    </tbody>
                </table>
                <div class="flex flex-col justify-center items-center mt-4">
                    <div class="join">
                        <button class="join-item btn"
                                :disabled="!withdraws.links.prev"
                                @click="$inertia.visit(withdraws.links.prev)"
                        >«</button>
                        <button class="join-item btn">Page {{ withdraws.meta.current_page }} of {{ withdraws.meta.last_page }}</button>
                        <button class="join-item btn"
                                :disabled="!withdraws.links.next"
                                @click="$inertia.visit(withdraws.links.next)"
                        >»</button>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">Showing {{ withdraws.meta.from }} to {{ withdraws.meta.to }} out of {{ withdraws.meta.total }} results</p>
                </div>
            </div>

            <div v-if="showToast" class="toast toast-top toast-end">
                <div class="alert alert-success">
                    <span>{{ successMessage }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
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
