<template>
    <div
        class="border border-slate-300 rounded-lg shadow-lg p-4 bg-white flex flex-col mt-8 cursor-pointer"
        @click="orderFood()"
    >
        <img
            :src="
                data.photo
                    ? `storage/images/foods/` + data.photo
                    : 'https://via.placeholder.com/200x200'
            "
            alt=""
            class="rounded-md aspect-auto cursor-pointer"
            @click="orderFood()"
        />
        <p class="font-bold leading-5 mt-3">
            {{ data.name }}
        </p>
        <p class="mt-4 text-slate-500 text-sm flex-1">
            {{ data.description }}
        </p>
        <div class="flex justify-between items-center">
            <p class="mt-4">
                <span class="font-bold text-lg text-orange-600"
                    >IDR {{ Number(data.price).toLocaleString() }}</span
                >
                <span class="text-sm text-slate-500"> /{{ data.unit }}</span>
            </p>
            <div class="flex gap-2 items-center">
                <img
                    src="/img/heart.png"
                    alt=""
                    class="w-5 h-5 mt-4"
                    v-if="data.is_favorite"
                />
                <img
                    src="/img/chef.png"
                    alt=""
                    class="w-6 h-6 mt-4"
                    v-if="data.is_recommended"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import { Inertia } from "@inertiajs/inertia";

const data = defineProps({
    photo: {
        type: String,
    },
    name: {
        type: String,
    },
    description: {
        type: String,
    },
    price: {
        type: String,
    },
    unit: {
        type: String,
    },
    id: {
        type: Number,
    },
    table_id: {
        type: String,
    },
    is_favorite: {
        type: Number,
    },
    is_recommended: {
        type: Number,
    },
});

const orderFood = () => {
    Inertia.post(
        route("order.add"),
        {
            data: {
                id: data.id,
                table_id: data.table_id,
            },
        },
        { preserveScroll: true }
    );
};
</script>
