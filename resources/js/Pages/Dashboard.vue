<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {ref} from "vue";

defineProps({
    income: {
        type: Number,
        required: true,
    },
    withdrawn: {
        type: Number,
        required: true,
    },
    top10Affiliates: {
        type: Array,
        required: true,
    },
    sliders: Array,
})

const currentSlide = ref(1)

const changeSlide = (slide) => {
    currentSlide.value = slide
};
const perseNum = (value) => {
    return Math.round(value)
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex gap-2">
                <a :href="route('courses.index')" class="btn btn-primary btn-sm">Course</a>
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

        <div class="py-2 relative">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mt-2 grid grid-cols-3 gap-2 px-2">
                    <div class="card bg-amber-700 text-neutral-content">
                        <div class="card-body items-center text-center">
                            <h3 class="card-title text-white ">Balance</h3>
                            <p class="text-white flex gap-2 mb-0 text-lg">
                                {{ perseNum(income) - perseNum(withdrawn) || 0 }}
                            </p>
                        </div>
                    </div>
                    <div class="card bg-fuchsia-950 text-neutral-content">
                        <div class="card-body items-center text-center">
                            <h3 class="card-title text-white">Income</h3>
                            <p class="text-white flex gap-2 mb-0 text-lg">
                                {{ perseNum(income) || 0 }}
                            </p>
                        </div>
                    </div>
                    <div class="card bg-cyan-950 text-neutral-content">
                        <div class="card-body items-center text-center">
                            <h3 class="card-title text-white">Withdrawn</h3>
                            <p class="text-white flex gap-2 mb-0 text-lg">
                                {{ perseNum(withdrawn) || 0 }}
                            </p>
                        </div>
                    </div>
                </div>

                <div v-if="sliders && sliders.length" class="mt-4 flex justify-center">
                    <div class="carousel w-full">
                        <div v-for="(slide, index) in sliders" :key="index" :class="['carousel-item relative w-full', { hidden: currentSlide !== index + 1 }]">
                            <img :src="slide.image" class="w-full" alt="slider image"/>
                            <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                                <a href="#" class="btn btn-circle" @click.prevent="changeSlide(currentSlide === 1 ? 3 : currentSlide - 1)">❮</a>
                                <a href="#" class="btn btn-circle" @click.prevent="changeSlide(currentSlide === 3 ? 1 : currentSlide + 1)">❯</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="py-16">
                    <h1 class="text-4xl font-bold text-center text-gray-900">Top 10 Affiliates</h1>
                    <div class="overflow-x-auto py-3">
                        <table class="table table-zebra text-center">
                            <thead class="text-xl text-gray-900">
                            <tr>
                                <th>Rank</th>
                                <th>Name</th>
                                <th>Total Sales</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(affiliate, index) in top10Affiliates" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>{{ affiliate.user.name }}</td>
                                <td>{{ affiliate.total_income }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-0 right-0 p-4">
                <a href="https://www.facebook.com" target="_blank" class="btn btn-primary btn-sm">
<!--                    <svg-->
<!--                        class="w-10 h-11"-->
<!--                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z" fill="currentColor"></path></svg>-->
               Join Our Facebook Group
                </a>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

