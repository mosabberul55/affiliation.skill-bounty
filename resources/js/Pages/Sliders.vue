<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, usePage} from '@inertiajs/vue3';
import {ref} from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";

defineProps({
    sliders: {
        type: Array,
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
const image = ref(null);
const error = ref(null);
const sliderModal = ref(null);
const takeImage = (e) => {
    image.value = e.target.files[0];
}
const createSlider = () => {
    const formData = new FormData();
    formData.append('image', image.value);
    axios.post(route('slider.store'), formData).then(res => {
        usePage().props.sliders.push(res.data.slider);
        usePage().props.successMessage = res.data.successMessage;
        showToast.value = true;
        setTimeout(() => {
            showToast.value = false;
        }, 3000)
        sliderModal.value.close();
    }).catch(err => {
        if (err.response.status === 422) {
            error.value = err.response.data.errors
        }
    })
}

const deleteSlider = (id) => {
    axios.delete(route('slider.destroy', id)).then(res => {
        const index = usePage().props.sliders.findIndex(slider => slider.id === id);
        usePage().props.sliders.splice(index, 1);
        usePage().props.successMessage = res.data.successMessage;
        showToast.value = true;
        setTimeout(() => {
            showToast.value = false;
        }, 3000)
    }).catch(err => {
        console.log(err);
    })
}
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
        </template>

        <div class="py-12">
            <div class="max-w-7xl overflow-auto mx-auto sm:px-6 lg:px-8">
                <button class="btn btn-primary" onclick="my_modal_4.showModal()" :disabled="sliders.length >= 3">Add
                    Slider </button>
                <dialog id="my_modal_4" class="modal"  ref="sliderModal">
                    <div class="modal-box w-11/12 max-w-5xl bg-gray-200">
                        <form @submit.prevent="createSlider()">
                            <h3 class="font-bold text-lg text-black">Add Slider</h3>
                            <div class="py-4 slider-form">
                                <div class="form-control">
                                    <InputLabel for="image" value="Image"/>
                                    <input type="file" @change="takeImage" id="image" ref="image"
                                           class="mt-2 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">

                                    <InputError class="mt-2" :message="error && error?.image[0]"/>
                                </div>
                            </div>

                            <div class="modal-action">
                                <button class="btn btn-primary">Add</button>
                                <form method="dialog">
                                    <!-- if there is a button, it will close the modal -->
                                    <button class="btn">Close</button>
                                </form>
                            </div>
                        </form>
                    </div>
                </dialog>
                <table class="table">
                    <!-- head -->
                    <thead class="text-xl">
                    <tr>
                        <th class="border-b-2 border-gray-400">S.N</th>
                        <th class="border-b-2 border-gray-400">Image</th>
                        <th class="border-b-2 border-gray-400">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- row 1 -->
                    <tr v-for="(slider, index) in sliders" :key="index">
                        <td class="border-b-2 border-gray-400">{{ index + 1 }}</td>
                        <td class="border-b-2 border-gray-400">
                            <img :src="slider.image" alt="slider image" class="w-24 h-24">
                        </td>
                        <td class="border-b-2 border-gray-400">
                            <button class="btn btn-error btn-sm" @click="deleteSlider(slider.id)">Delete</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="showToast" class="toast toast-top toast-end">
                <div class="alert alert-success">
                    <span>{{ successMessage }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                         stroke="currentColor" className="w-6 h-6">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12"/>
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
