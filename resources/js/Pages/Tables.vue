<template>
    <AppLayout>
        <div class="mx-auto max-w-7xl mb-12">
            <div
                class="max-w-full mx-auto my-8 text-2xl font-bold text-slate-700 uppercase tracking tracking-wider"
            >
                Table List
            </div>
            <div
                class="grid grid-cols-5 gap-8 mx-auto px-12 border border-slate-300 py-8 rounded-3xl shadow-lg"
            >
                <div v-for="table in data.tables" class="flex justify-evenly">
                    <button
                        class="text-green-100 bg-green-600 text-center rounded-full shadow-2xl cursor-pointer px-8 py-12 hover:bg-green-700"
                        @click="order(table.id)"
                        :class="{
                            'text-red-200 bg-red-600 hover:bg-red-700':
                                data.orders.includes(table.id),
                        }"
                        v-if="table.is_available == 1"
                    >
                        {{ table.name }}
                    </button>
                    <button
                        class="rounded-full shadow-md text-center cursor-not-allowed p-8 bg-slate-500 text-slate-200"
                        disabled
                        v-else
                    >
                        {{ table.name }}
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Inertia } from "@inertiajs/inertia";

const data = defineProps({
    tables: {
        type: Array,
    },
    orders: {
        type: Object,
    },
    carts: {
        type: Object,
    },
});

const order = (id) => {
    Inertia.get(route("order"), {
        table_id: id,
    });
};
</script>

<style>
.bg-red-600 {
    background-color: #e53e3e !important;
}
</style>
