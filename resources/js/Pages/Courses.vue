<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {ref} from "vue";

defineProps({
    courses: {
        type: Array,
        required: true,
    }
})

const showToast = ref(false);

const copyLink = (link) => {
    navigator.clipboard.writeText(link);
    showToast.value = true;
    setTimeout(() => {
        showToast.value = false;
    }, 2000);
}
</script>

<template>
    <Head title="Courses" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex gap-2">
                <a :href="route('dashboard')" class="btn btn-primary btn-sm">Dashboard</a>
                <a :href="route('income.index')" class="btn btn-primary btn-sm">Income</a>
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
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center items-center">
                    <div class="grid gap-5 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">
                        <div class="card card-compact w-96 bg-base-100 shadow-xl" v-for="(item, i) in courses" :key="i">
                            <figure>
                                <img :src="item.image" :alt="item.name" style="max-height: 250px; width: 100%; object-fit: fill; object-position: center;">
                            </figure>
                            <div class="card-body">
                                <h2 class="card-title">{{ item.title }}</h2>
                                <p class="text-sm text-white">{{ `${item.link}?code=${$page.props.auth.user.code}` }}</p>
                                <div class="card-actions justify-end">
                                    <button class="btn btn-primary" @click="copyLink(`${item.link}?code=${$page.props.auth.user.code}`)">Copy</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="showToast" class="toast toast-top toast-end">
                    <div class="alert alert-success">
                        <span>Link copied to clipboard</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
