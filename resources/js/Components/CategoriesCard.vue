<template>
    <div
        class="bg-white border border-slate-300 shadow-md rounded-lg py-2 px-4 flex justify-center items-center gap-4 cursor-pointer hover:bg-orange-600 hover:text-white transition"
        @click="categorySelected"
    >
        <img
            :src="`storage/images/categories/` + data.photo"
            alt=""
            class="w-6 h-6 hover:text-white hover:fill-current"
        />
        <span> {{ data.category }}</span>
    </div>
</template>

<script setup>
import { Inertia } from "@inertiajs/inertia";

let data = defineProps({
    category: String,
    photo: String,
    id: Number,
});

const categorySelected = () => {
    Inertia.get(
        route("dashboard"),
        {
            id: data.id,
        },
        {
            preserveScroll: true,
        }
    );
};
</script>
