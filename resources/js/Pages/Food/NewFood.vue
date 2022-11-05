<template>
    <AppLayout>
        <div
            class="max-w-7xl mx-auto border border-slate-300 rounded-lg my-6 shadow-lg"
        >
            <div class="bg-slate-300 p-4 rounded-t-lg">
                <p class="uppercase tracking-wider font-bold">New Food</p>
            </div>
            <form @submit.prevent="saveFood">
                <div class="p-4">
                    <div class="mt-3">
                        <InputLabel value="Food Name" />
                        <TextInput
                            type="text"
                            class="w-full"
                            v-model="form.name"
                        />
                        <span
                            v-for="error in v$.name.$errors"
                            :key="error.$uid"
                        >
                            <p class="text-red-500 text-sm mt-1">
                                {{ error.$message }}
                            </p>
                        </span>
                    </div>
                    <div class="mt-3">
                        <InputLabel value="Description" />
                        <textarea
                            type="text"
                            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            v-model="form.description"
                        ></textarea>
                        <span
                            v-for="error in v$.description.$errors"
                            :key="error.$uid"
                        >
                            <p class="text-red-500 text-sm mt-0">
                                {{ error.$message }}
                            </p>
                        </span>
                    </div>
                    <div class="mt-3 grid grid-cols-3 gap-3">
                        <div>
                            <InputLabel value="Category" />
                            <select
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                v-model="form.category_id"
                            >
                                <option value="">Select Category</option>
                                <option
                                    v-for="data in data.categories"
                                    :value="data.id"
                                >
                                    {{ data.name }}
                                </option>
                            </select>
                            <span
                                v-for="error in v$.category_id.$errors"
                                :key="error.$uid"
                            >
                                <p class="text-red-500 text-sm mt-1">
                                    {{ error.$message }}
                                </p>
                            </span>
                        </div>
                        <div>
                            <InputLabel value="Price in IDR" />
                            <TextInput
                                type="number"
                                class="w-full"
                                v-model="form.price"
                            />
                            <span
                                v-for="error in v$.price.$errors"
                                :key="error.$uid"
                            >
                                <p class="text-red-500 text-sm mt-1">
                                    {{ error.$message }}
                                </p>
                            </span>
                        </div>
                        <div>
                            <InputLabel value="Unit" />
                            <TextInput
                                type="text"
                                class="w-full"
                                v-model="form.unit"
                            />
                            <span
                                v-for="error in v$.unit.$errors"
                                :key="error.$uid"
                            >
                                <p class="text-red-500 text-sm mt-1">
                                    {{ error.$message }}
                                </p>
                            </span>
                        </div>
                    </div>
                    <!-- <div class="mt-3 grid grid-cols-3"> -->
                    <div class="flex items-center gap-1 mt-3">
                        <Checkbox v-model="form.is_recommended" />
                        <InputLabel value="Chef Recommended" />
                    </div>
                    <div class="flex items-center gap-1 mt-3">
                        <Checkbox v-model="form.is_favorite" />
                        <InputLabel value="Favorite" />
                    </div>
                    <div class="flex items-center gap-1 mt-3">
                        <Checkbox v-model="form.is_available" />
                        <InputLabel value="Available" />
                    </div>
                    <!-- </div> -->
                    <div class="mt-3">
                        <InputLabel value="Image" />
                        <FilePond
                            accept="image/jpg, image/jpeg, image/png"
                            :server="{
                                url: '',
                                process: {
                                    url: '/settings/upload',
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $page.props.csrf_token,
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
                    <div class="flex gap-3">
                        <PrimaryButton value="Save" class="mt-3" type="submit"
                            >SAVE</PrimaryButton
                        >
                        <DangerButton
                            value="Cancel"
                            class="mt-3"
                            @click="cancel"
                            >Cancel</DangerButton
                        >
                    </div>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
<script setup>
import { reactive, computed } from "vue";
import { Inertia } from "@inertiajs/inertia";
import VueFilePond from "vue-filepond";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size";
import FilePondPluginImageExifOrientation from "filepond-plugin-image-exif-orientation";
import FilePondPluginImageResize from "filepond-plugin-image-resize";
import FilePondPluginImageTransform from "filepond-plugin-image-transform";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css";
import AppLayout from "@/Layouts/AppLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/Textinput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Checkbox from "@/Components/Checkbox.vue";
import { useVuelidate } from "@vuelidate/core";
import { required, minLength, minValue } from "@vuelidate/validators";

const form = reactive({
    name: "",
    description: "",
    category_id: "",
    price: "",
    unit: "ea",
    photo: "",
    is_recommended: "",
    is_favorite: "",
    is_available: "",
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
        category_id: {
            required,
        },
        price: {
            required,
            minValue: minValue(0),
        },
        unit: {
            required,
        },
    };
});

const v$ = useVuelidate(rules, form);

const saveFood = async () => {
    const result = await v$.value.$validate();
    if (result) {
        Inertia.post(route("food.store"), form);
    } else {
        console.log("error");
    }
};

const data = defineProps({
    categories: {
        type: Object,
    },
});

const FilePond = VueFilePond(
    FilePondPluginImagePreview,
    FilePondPluginFileValidateType,
    FilePondPluginFileValidateSize,
    FilePondPluginImageExifOrientation,
    FilePondPluginImageResize,
    FilePondPluginImageTransform
);

const cancel = () => {
    Inertia.get(route("settings"));
};
</script>
