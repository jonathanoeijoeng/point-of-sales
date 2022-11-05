<template>
    <AppLayout>
        <div
            class="max-w-4xl mx-auto border border-slate-300 rounded-lg my-6 shadow-lg"
        >
            <div class="bg-slate-300 p-4 rounded-t-lg">
                <p class="uppercase tracking-wider font-bold">Edit Food</p>
            </div>
            <form @submit.prevent="updateFood">
                <div class="p-4">
                    <div>
                        <InputLabel value="Food Name" />
                        <TextInput
                            type="text"
                            class="w-full"
                            v-model="form.name"
                        />
                        <span
                            v-for="error in v$.name.$silentErrors"
                            :key="error.$uid"
                        >
                            <p class="text-red-500 text-sm mt-1">
                                {{ error.$message }}
                            </p>
                        </span>
                    </div>
                    <div class="mt-3">
                        <InputLabel value="Food Description" />
                        <textarea
                            type="text"
                            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            v-model="form.description"
                        ></textarea>
                        <span
                            v-for="error in v$.description.$silentErrors"
                            :key="error.$uid"
                        >
                            <p class="text-red-500 text-sm mt-1">
                                {{ error.$message }}
                            </p>
                        </span>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="mt-3">
                            <InputLabel value="Price" />
                            <TextInput
                                type="text"
                                class="w-full"
                                v-model="form.price"
                            />
                            <span
                                v-for="error in v$.price.$silentErrors"
                                :key="error.$uid"
                            >
                                <p class="text-red-500 text-sm mt-1">
                                    {{ error.$message }}
                                </p>
                            </span>
                        </div>
                        <div class="mt-3">
                            <InputLabel value="Unit" />
                            <TextInput
                                type="text"
                                class="w-full"
                                v-model="form.unit"
                            />
                            <span
                                v-for="error in v$.unit.$silentErrors"
                                :key="error.$uid"
                            >
                                <p class="text-red-500 text-sm mt-1">
                                    {{ error.$message }}
                                </p>
                            </span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="mt-3">
                            <InputLabel value="Food Photo" />
                            <img
                                class="border border-slate-400 rounded-lg"
                                :src="
                                    `../../storage/images/foods/` + form.photo
                                "
                            />
                        </div>
                        <div class="mt-3">
                            <InputLabel for="new_photo" value="New Photo" />
                            <FilePond
                                accept="image/jpg, image/jpeg, image/png"
                                :server="{
                                    url: '',
                                    process: {
                                        url: '/settings/upload',
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN':
                                                $page.props.csrf_token,
                                        },
                                        withCredential: false,
                                    },
                                }"
                                :imageResizeTargetWidth="1200"
                                :imageResizeTargetHeight="1200"
                                name="photo"
                                id="photo"
                            />
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex gap-3 bg-slate-300 p-4">
                    <PrimaryButton type="submit" @click="updateFood"
                        >Update</PrimaryButton
                    >
                    <DangerButton @click="back">Cancel</DangerButton>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
<script setup>
import { reactive, computed } from "vue";
import { Inertia } from "@inertiajs/inertia";
import AppLayout from "@/Layouts/AppLayout.vue";
import VueFilePond from "vue-filepond";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size";
import FilePondPluginImageExifOrientation from "filepond-plugin-image-exif-orientation";
import FilePondPluginImageResize from "filepond-plugin-image-resize";
import FilePondPluginImageTransform from "filepond-plugin-image-transform";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/Textinput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { useVuelidate } from "@vuelidate/core";
import { required, minLength, minValue } from "@vuelidate/validators";

const data = defineProps({
    food: Object,
});

const form = reactive({
    id: data.food.id,
    name: data.food.name,
    description: data.food.description,
    price: data.food.price,
    photo: data.food.photo,
    unit: data.food.unit,
});

const rules = computed(() => {
    return {
        name: {
            required,
            minLength: minLength(3),
        },
        description: {
            required,
            minLength: minLength(5),
        },
        price: {
            required,
            minValue: minValue(1),
        },
        unit: {
            required,
        },
    };
});

const v$ = useVuelidate(rules, form);

const updateFood = async () => {
    const result = await v$.value.$validate();
    if (result) {
        Inertia.put(route("food.update"), form);
    }
};

const FilePond = VueFilePond(
    FilePondPluginImagePreview,
    FilePondPluginFileValidateType,
    FilePondPluginFileValidateSize,
    FilePondPluginImageExifOrientation,
    FilePondPluginImageResize,
    FilePondPluginImageTransform
);

const back = () => {
    Inertia.get(route("settings"));
};
</script>
