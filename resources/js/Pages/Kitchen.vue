<template>
    <AppLayout title="Kitchen Order List">
        <div class="px-12 py-12">
            <h1 class="text-2xl font-bold uppercase tracking-wider">
                Kitchen Order List
            </h1>
            <div class="mt-5">
                <table
                    class="w-full text-left divide-y divide-slate-200 rounded-lg"
                >
                    <thead>
                        <tr
                            class="bg-slate-200 font-semibold uppercase tracking-widest"
                        >
                            <th class="py-3 px-4">Time Received</th>
                            <th class="py-3 px-4">Time Processed</th>
                            <th class="py-3 px-4">Table</th>
                            <th class="py-3 px-4">Name</th>
                            <th class="py-3 px-4">Quantity</th>
                            <th class="py-3 px-4">Note</th>
                            <th class="py-3 px-4">Action</th>
                        </tr>
                    </thead>
                    <tbody
                        class="divide-y divide-slate-200"
                        v-if="data.orders.length > 0"
                    >
                        <tr v-for="order in data.orders">
                            <td class="py-3 px-4">
                                {{
                                    dayjs(order.time_sent_to_kitchen).format(
                                        "HH:mm:ss"
                                    )
                                }}
                            </td>
                            <td class="py-3 px-4" v-if="order.time_processed">
                                {{
                                    dayjs(order.time_processed).format(
                                        "hh:mm:ss"
                                    )
                                }}
                            </td>
                            <td class="py-3 px-4 text-center" v-else>-</td>
                            <td class="py-3 px-4">
                                {{ order.table.name }}
                            </td>
                            <td class="py-3 px-4">
                                {{ order.food_detail.name }}
                            </td>
                            <td class="py-3 px-4">
                                {{ order.quantity }}
                            </td>
                            <td class="py-3 px-4" v-if="order.notes">
                                {{ order.notes }}
                            </td>
                            <td class="py-3 px-4" v-else>-</td>
                            <td class="py-3 px-4 flex gap-4">
                                <CheckoutButton
                                    class="text-sm"
                                    @click="process(order)"
                                    v-if="!order.time_processed"
                                >
                                    Process
                                </CheckoutButton>
                                <CheckoutButton
                                    class="text-sm"
                                    @click="process(order)"
                                    v-else
                                    disabled
                                >
                                    Process
                                </CheckoutButton>
                                <GreenButton
                                    class="text-sm"
                                    @click="done(order)"
                                >
                                    Done
                                </GreenButton>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else class="border border-slate-300">
                        <tr>
                            <td
                                colspan="7"
                                class="py-8 text-center border border-slate-300"
                            >
                                <p class="text-xl">All Done! Great Job!</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { Inertia } from "@inertiajs/inertia";
import AppLayout from "@/Layouts/AppLayout.vue";
import dayjs from "dayjs";
import GreenButton from "@/Components/GreenButton.vue";
import CheckoutButton from "@/Components/CheckoutButton.vue";

const data = defineProps({
    orders: {
        type: Object,
    },
});

const process = (order) => {
    Inertia.post(route("order.process", order));
};

const done = (order) => {
    Inertia.post(route("order.done", order));
};

const interval = setTimeout(function () {
    Inertia.get(route("kitchen"));
}, 5000);
</script>
