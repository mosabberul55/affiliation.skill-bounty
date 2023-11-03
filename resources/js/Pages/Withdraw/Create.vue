<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
})
const form = useForm({
    amount: '',
    mfs: 'bkash',
    note: '',
});

const submit = () => {
    form.post(route('withdraw.store'), {
        // onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="WithDraw Request" />

        <form @submit.prevent="submit">
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-900 text-center">WithDraw Request</h3>
            </div>
            <div>
                <InputLabel for="amount" value="Amount" />

                <TextInput
                    id="amount"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.amount"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.amount" />
            </div>
            <div class="mt-6">
                <InputLabel for="mfs" value="Mobile Banking" />

                <select required autofocus v-model="form.mfs" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option disabled selected>Select Mobile Banking</option>
                    <option value="bkash">Bkash</option>
<!--                    <option value="rocket">Rocket</option>-->
                    <option value="nagad">Nagad</option>
                </select>

                <InputError class="mt-2" :message="form.errors.mfs" />
            </div>
            <div class="mt-6">
                <InputLabel for="note" value="Note" />

                <textarea
                    v-model="form.note"
                    autofocus
                    placeholder="Note"
                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                </textarea>

                <InputError class="mt-2" :message="form.errors.note" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ml-4"
                               :class="{ 'opacity-25': form.processing || !form.amount.length }"
                               :disabled="form.processing || !form.amount.length">
                    Submit
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
