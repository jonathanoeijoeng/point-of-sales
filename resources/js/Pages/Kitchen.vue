<template>
    <AppLayout title="Kitchen Order List">
        <div class="mx-6 mt-6 mb-12 border border-slate-300 rounded-lg">
            <div
                class="text-xl p-4 font-bold uppercase tracking-wider bg-slate-300 rounded-t-lg"
            >
                Kitchen Order List
            </div>
            <div>
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
                                    v-if="order.time_processed"
                                >
                                    Done
                                </GreenButton>
                                <GreenButton
                                    class="text-sm"
                                    @click="done(order)"
                                    v-else
                                    disabled
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
                                <div class="text-xl flex justify-center">
                                    <img src="/img/giphy.gif" alt="" />
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import AppLayout from "@/Layouts/AppLayout.vue";
import dayjs from "dayjs";
import GreenButton from "@/Components/GreenButton.vue";
import CheckoutButton from "@/Components/CheckoutButton.vue";
import Pusher from "pusher-js";
import Checkbox from "@/Components/Checkbox.vue";

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

// const interval = setTimeout(function () {
//     Inertia.get(route("kitchen"));
// }, 5000);

// onBeforeUnmount(() => {
//     clearTimeout(interval);
// });

onMounted(() => {
    // Pusher.logToConsole = true;
    const pusher = new Pusher("ff94d45ed44d71633a8d", {
        cluster: "ap1",
    });
    const channel = pusher.subscribe("order-sent");
    channel.bind("OrderSent", function (data) {
        Inertia.get(route("kitchen"));
    });
});
</script>
