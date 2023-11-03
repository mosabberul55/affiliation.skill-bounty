<script setup>
import { Head, Link } from '@inertiajs/vue3';
import {ref} from "vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean
});
</script>

<template>
    <Head title="Affiliation | Welcome"/>

    <div class="navbar bg-base-100 container mx-auto px-2">
        <div class="flex-1">
            <img src="@/assets/images/logo.png" class="w-20" alt="logo"/>
        </div>
        <div class="flex-none">
            <ul class="menu menu-horizontal px-1 text-lg">
                <li v-if="canLogin && $page.props.auth.user"><a :href="route('dashboard')">Dashboard</a></li>
                <li v-else class="flex flex-row">
                    <a :href="route('login')">Log in</a>
                    <a v-if="canRegister" :href="route('register')">Register</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <h1 class="text-4xl font-bold text-center text-gray-900 dark:text-gray-100">
                <span class="text-red-500">Skill Bounty</span> Affiliation
            </h1>
        </div>
    </div>
</template>

<style>
</style>
