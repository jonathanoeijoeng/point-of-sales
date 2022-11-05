<template>
    <AppLayout>
        <div class="grid grid-cols-5 gap-3 py-4 px-8 my-3">
            <div
                class="col-span-2 border border-slate-300 rounded-lg shadow-lg p-4"
            >
                <div class="overflow-x-auto bg-slate-300 rounded-lg">
                    <div
                        class="bg-slate-300 p-4 rounded-t-lg flex items-center justify-between"
                    >
                        <p class="uppercase tracking-wider font-bold">
                            Best Seller Food
                        </p>
                        <PrimaryButton @click="addToFavs"
                            >Add To FAV's</PrimaryButton
                        >
                    </div>
                    <div>
                        <table class="text-xs lg:text-sm w-full text-left">
                            <thead>
                                <tr
                                    class="bg-slate-100 font-semibold uppercase tracking-widest text-xs"
                                >
                                    <th class="py-3 px-4">Food Name</th>
                                    <th class="py-3 px-4 text-right">Qty</th>
                                    <th class="py-3 px-4 text-right">
                                        Gross Revenue
                                    </th>
                                    <th class="py-3 px-4 text-right">
                                        Nett Revenue
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class="bg-white hover:bg-slate-100"
                                    v-for="food in data.foods"
                                    :key="food.id"
                                >
                                    <td
                                        class="py-2 px-4"
                                        v-if="food.food_detail"
                                    >
                                        {{ food.food_detail.name }}
                                    </td>
                                    <td class="py-2 px-4" v-else>No Name</td>

                                    <td class="py-2 px-4 text-right">
                                        {{ Number(food.qty).toLocaleString() }}
                                    </td>
                                    <td class="py-2 px-4 text-right">
                                        {{
                                            Number(
                                                food.gross_revenue
                                            ).toLocaleString()
                                        }}
                                    </td>
                                    <td class="py-2 px-4 text-right">
                                        {{
                                            Number(
                                                food.net_revenue
                                            ).toLocaleString()
                                        }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div
                class="col-span-3 border border-slate-300 rounded-lg shadow-lg p-4"
            >
                <MonthlySalesChart
                    :month="data.month"
                    :net_revenue_month="data.net_revenue_month"
                />
            </div>
        </div>
        <div
            class="mt-3 border border-slate-300 rounded-lg shadow-lg py-4 mx-8 my-3 px-4"
        >
            <DailySalesChart
                :date="data.date"
                :net_revenue="data.net_revenue"
            />
        </div>
    </AppLayout>
</template>
<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DailySalesChart from "@/Pages/Dashboard/DailySalesChart.vue";
import MonthlySalesChart from "@/Pages/Dashboard/MonthlySalesChart.vue";
import { Inertia } from "@inertiajs/inertia";

const data = defineProps({
    foods: {
        type: Object,
    },
    date: {
        type: Array,
    },
    net_revenue: {
        type: Array,
    },
    month: {
        type: Array,
    },
    net_revenue_month: {
        type: Array,
    },
});

clearTimeout(window.interval);

const addToFavs = () => {
    Inertia.post(route("dashboard.add-to-favs"));
};
</script>
