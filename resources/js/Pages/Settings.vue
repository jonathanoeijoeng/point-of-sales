<template>
    <AppLayout title="Settings">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div
                class="mt-8 overflow-x-auto bg-slate-300 rounded-lg border border-slate-300"
            >
                <div
                    class="p-4 bg-slate-300 rounded-t-lg lg:flex lg:justify-between items-center w-full"
                >
                    <p class="font-bold uppercase tracking-widest text-sm">
                        User List
                    </p>
                </div>
                <table
                    class="text-xs lg:text-sm w-full text-left divide-y divide-slate-200"
                >
                    <thead>
                        <tr
                            class="bg-slate-200 font-semibold uppercase tracking-widest text-xs"
                        >
                            <th class="py-3 px-4">Name</th>
                            <th class="py-3 px-4">Phone</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-center">Role</th>
                            <th class="py-3 px-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <tr
                            class="bg-white"
                            v-for="user in data.users"
                            :key="user.id"
                        >
                            <td class="py-3 px-4">
                                <!-- <img
                                    class="w-12 h-12 rounded-full"
                                    :src="`storage/images/foods/` + food.photo"
                                    alt=""
                                /> -->
                                <div class="font-semibold text-lg">
                                    {{ user.name }}
                                </div>
                                <div class="text-sm">{{ user.email }}</div>
                            </td>
                            <td class="py-3 px-4">
                                {{ user.phone }}
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center text-center">
                                    <div
                                        class="flex items-center"
                                        v-if="
                                            user.active_until >=
                                            dayjs().format('YYYY-MM-DD')
                                        "
                                    >
                                        <div
                                            class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"
                                        ></div>
                                        Active
                                    </div>
                                    <div class="flex items-center" v-else>
                                        <div
                                            class="h-2.5 w-2.5 rounded-full bg-red-500 mr-2"
                                        ></div>
                                        Inactive
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span
                                    v-for="role in user.roles"
                                    :key="role.id"
                                    >{{ role.name }}</span
                                >
                            </td>
                            <td
                                class="px-4 text-center flex justify-center whitespace-nowrap gap-1"
                            >
                                <Edit
                                    class="w-12 scale-50 hover:scale-75"
                                    @click="editUser(user)"
                                />
                                <Delete
                                    class="w-12 scale-50 hover:scale-75"
                                    @click.once="deleteUser(user)"
                                />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div
                class="my-8 overflow-x-auto bg-slate-300 rounded-lg border border-slate-300"
            >
                <div
                    class="p-4 bg-slate-300 rounded-t-lg lg:flex lg:justify-between items-center w-full"
                >
                    <div class="flex items-center justify-between gap-6">
                        <p class="font-bold uppercase tracking-widest text-sm">
                            Food List
                        </p>
                        <div>
                            <TextInput
                                class="w-64 p-2 text-sm"
                                placeholder="Search food"
                                v-model="search"
                                type="search"
                            />
                        </div>
                    </div>
                    <PrimaryButton class="w-full lg:w-auto" @click="createNew"
                        >New</PrimaryButton
                    >
                </div>
                <table
                    class="text-xs lg:text-sm w-full text-left divide-y divide-slate-200 rounded-lg"
                >
                    <thead>
                        <tr
                            class="bg-slate-200 font-semibold uppercase tracking-widest text-xs"
                        >
                            <th class="py-3 px-4">Name</th>
                            <th class="py-3 px-4">Description</th>
                            <th class="py-3 px-4">Category</th>
                            <th class="py-3 px-4">Price</th>
                            <th class="py-3 px-4">Unit</th>
                            <th class="py-3 px-4 text-center">Available</th>
                            <th class="py-3 px-4 text-center">
                                <img
                                    class="w-6 h-6"
                                    src="/img/chef.png"
                                    alt=""
                                />
                            </th>
                            <th class="py-3 px-4 text-center">
                                <img
                                    class="w-6 h-6"
                                    src="/img/heart.png"
                                    alt=""
                                />
                            </th>
                            <th class="py-3 px-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <tr
                            class="bg-white"
                            v-for="food in data.foods"
                            :key="food.id"
                        >
                            <td class="py-3 px-4 flex items-center gap-4">
                                <img
                                    class="w-12 h-12 rounded-full"
                                    :src="`storage/images/foods/` + food.photo"
                                    alt=""
                                />
                                <span class="font-semibold text-base">{{
                                    food.name
                                }}</span>
                            </td>
                            <td class="py-3 px-4">
                                {{ food.description.substring(0, 50) + " .." }}
                            </td>
                            <td class="py-3 px-4">
                                <select
                                    name=""
                                    id=""
                                    class="rounded-lg py-1 text-sm border border-slate-300"
                                    @change="changeCategory(food.id, $event)"
                                >
                                    <option
                                        v-for="category in data.categories"
                                        :key="category.id"
                                        :value="category.id"
                                        :selected="
                                            category.id == food.category_id
                                        "
                                    >
                                        {{ category.name }}
                                    </option>
                                </select>
                            </td>
                            <td class="py-3 px-4" @click="priceEdit">
                                {{ Number(food.price).toLocaleString() }}
                            </td>
                            <td class="py-3 px-4">{{ food.unit }}</td>
                            <td class="py-3 px-4 text-center">
                                <Checkbox
                                    v-model="is_available"
                                    :checked="
                                        food.is_available == 1 ? true : false
                                    "
                                    :id="food.id"
                                    @change="changeStatus(food.id)"
                                />
                            </td>
                            <td class="py-3 px-4">
                                <Checkbox
                                    v-model="is_recommended"
                                    :checked="
                                        food.is_recommended == 1 ? true : false
                                    "
                                    :id="food.id"
                                    @change="changeRecommended(food.id)"
                                />
                            </td>
                            <td class="py-3 px-4">
                                <Checkbox
                                    v-model="is_favorite"
                                    :checked="
                                        food.is_favorite == 1 ? true : false
                                    "
                                    :id="food.id"
                                    :value="food.id"
                                    @change="changeFavourite(food.id)"
                                />
                            </td>
                            <td
                                class="px-4 text-center flex justify-center whitespace-nowrap gap-1"
                            >
                                <Edit
                                    class="w-12 scale-50 hover:scale-75"
                                    @click="editFood(food)"
                                />
                                <Delete
                                    class="w-12 scale-50 hover:scale-75"
                                    @click="deleteFood(food)"
                                />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
<script setup>
import { ref, reactive, computed, watch } from "vue";
import AppLayout from "../Layouts/AppLayout.vue";
import Checkbox from "../Components/Checkbox.vue";
import Edit from "../Components/Edit.vue";
import Delete from "../Components/Delete.vue";
import { Inertia } from "@inertiajs/inertia";
import Swal from "sweetalert2";
import dayjs from "dayjs";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import VueFilePond from "vue-filepond";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size";
import FilePondPluginImageExifOrientation from "filepond-plugin-image-exif-orientation";
import FilePondPluginImageResize from "filepond-plugin-image-resize";
import FilePondPluginImageTransform from "filepond-plugin-image-transform";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css";
import { useVuelidate } from "@vuelidate/core";
import { required, minLength, minValue } from "@vuelidate/validators";
import TextInput from "@/Components/TextInput.vue";

const data = defineProps({
    foods: {
        type: Object,
    },
    users: {
        type: Object,
    },
    categories: {
        type: Object,
    },
});

const search = ref("");

watch(search, (value) => {
    Inertia.post(
        route("settings"),
        { search: value },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
});

const is_recommended = ref("");
const is_favorite = ref("");
const is_available = ref("");
const showModal = ref(false);

const form = reactive({
    id: "",
    name: "",
    description: "",
    price: "",
    photo: "",
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
            minValue: minValue(0),
        },
    };
});

const v$ = useVuelidate(rules, form);

const FilePond = VueFilePond(
    FilePondPluginImagePreview,
    FilePondPluginFileValidateType,
    FilePondPluginFileValidateSize,
    FilePondPluginImageExifOrientation,
    FilePondPluginImageResize,
    FilePondPluginImageTransform
);

const changeRecommended = (id) => {
    Inertia.post(
        route("recommended"),
        {
            id: id,
            is_recommended: is_recommended.value,
        },
        {
            preserveScroll: true,
        }
    );
};

const changeFavourite = (id) => {
    Inertia.post(
        route("favourite"),
        {
            id: id,
            is_favorite: is_favorite.value,
        },
        {
            preserveScroll: true,
        }
    );
};

const changeStatus = (id) => {
    Inertia.post(
        route("status"),
        {
            id: id,
            is_available: is_available.value,
        },
        {
            preserveScroll: true,
        }
    );
};

const changeCategory = (id, event) => {
    Inertia.post(
        route("category"),
        {
            id: id,
            category_id: event.target.value,
        },
        {
            preserveScroll: true,
        }
    );
};

const editFood = (food) => {
    Inertia.get(
        route("food.show", {
            id: food.id,
        })
    );
};

const deleteFood = (food) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            Inertia.delete(
                route(
                    "food.destroy",
                    {
                        id: food.id,
                        name: food.name,
                    },
                    {
                        preserveScroll: true,
                    }
                )
            );
        }
    });
};

const createNew = () => {
    Inertia.get(route("food.create"));
};

const editUser = (user) => {
    Inertia.get(
        route("user.show", {
            id: user.id,
        })
    );
};

const deleteUser = (user) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            Inertia.delete(
                route(
                    "user.destroy",
                    {
                        id: user.id,
                        name: user.name,
                    },
                    {
                        preserveScroll: true,
                    }
                )
            );
        }
    });
};
</script>
