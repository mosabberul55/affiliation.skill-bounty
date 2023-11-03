<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    errors: {
        type: Object,
        default: () => ({}),
    }
});

const form = useForm({
    phone: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-900 text-center">Log in to your account</h3>
            </div>
            <div>
                <InputLabel for="phone" value="Phone" />

                <TextInput
                    id="phone"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.phone || errors?.phone" />
            </div>

<!--            <div class="block mt-4">-->
<!--                <label class="flex items-center">-->
<!--                    <Checkbox name="remember" v-model:checked="form.remember" />-->
<!--                    <span class="ml-2 text-sm text-gray-600">Remember me</span>-->
<!--                </label>-->
<!--            </div>-->

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('register.store')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Dont have an account?
                </Link>

                <PrimaryButton class="ml-4"
                               :class="{ 'opacity-25': form.processing || form.phone.length < 11 }"
                               :disabled="form.processing || form.phone.length < 11">
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
