<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    phone: {
        type: [String, Number],
    },
    error: {
        type: String,
    },
})
const form = useForm({
    code: '',
    phone: props.phone,
});

const submit = () => {
    form.post(route('verify.otp'), {
        // onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Otp Verification" />

        <form @submit.prevent="submit">
            <div>
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-900 text-center">Enter OTP</h3>
                    <p class="mt-1 text-sm text-gray-600 text-center">
                        A 6 digit OTP has been sent to {{ $page.props.phone.substring(0, 5) }}XXXX{{ $page.props.phone.substring(9, 11)}}
                    </p>
                </div>
                <InputLabel for="code" value="OTP" />

                <TextInput
                    id="name"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.code"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.code || error" />
            </div>
            <input type="hidden" name="phone" :value="$page.props.phone" />

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Back to login
                </Link>

                <PrimaryButton class="ml-4"
                               :class="{ 'opacity-25': form.processing || form.code.length < 6 }"
                               :disabled="form.processing || form.code.length < 6">
                    Submit OTP
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
