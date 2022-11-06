<script setup>
import { watch, reactive, onMounted, ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import AppLayout from "@/Layouts/AppLayout.vue";
import Order from "./Order/Order.vue";
import Cart from "./Order/Cart.vue";
import TextInput from "@/Components/Textinput.vue";
import route from "../../../vendor/tightenco/ziggy/src/js";
import dayjs from "dayjs";
import Swal from "sweetalert2";
import Pusher from "pusher-js";

const data = defineProps({
    foods: {
        type: Object,
    },
    categories: {
        type: Object,
    },
    carts: {
        type: Object,
    },
    table_id: {
        type: String,
    },
});

const filters = reactive({
    search: "",
    category: "",
});

watch(filters, (value) => {
    Inertia.get(
        route("order"),
        { filters: value },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
});

const reset = () => {
    filters.search = "";
    filters.category = "";
};

if (data.table_id == null) {
    Swal.fire({
        title: "Error",
        text: "No table number found!",
        icon: "error",
        allowOutsideClick: false,
        showCancelButton: false,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Choose table!",
    }).then((result) => {
        if (result.isConfirmed) {
            Inertia.visit(route("table"));
        }
    });
}

const table = ref(data.table_id);

onMounted(() => {
    // Pusher.logToConsole = true;
    const pusher = new Pusher("ff94d45ed44d71633a8d", {
        cluster: "ap1",
    });
    const channel = pusher.subscribe("order-processed");
    channel.bind("OrderProcessed", function (data) {
        Inertia.get(
            route("order"),
            {
                table_id: table.value,
            },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
            }
        );
    });

    const pusher1 = new Pusher("ff94d45ed44d71633a8d", {
        cluster: "ap1",
    });
    const channel1 = pusher1.subscribe("order-done");
    channel1.bind("OrderDone", function (data) {
        Inertia.get(
            route("order"),
            {
                table_id: table.value,
            },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
            }
        );
    });
});
</script>

<template>
    <AppLayout title="Order List">
        <div class="grid grid-cols-12 relative">
            <div
                class="py-12 bg-slate-100 col-span-9 lg:col-span-7 overflow-y-auto h-screen"
            >
                <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                    <div class="flex justify-between gap-6">
                        <div>
                            <p class="text-2xl font-bold">
                                Hi, {{ $page.props.user.name }}
                            </p>
                            <p class="text-slate-500 text-sm mt-2">
                                Today is
                                <span class="font-semibold">
                                    {{ dayjs().format("dddd, D MMMM YYYY") }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <TextInput
                                type="text"
                                placeholder="Search here.."
                                class="w-64"
                                v-model="filters.search"
                            />
                        </div>
                    </div>

                    <!-- Categories Card -->
                    <div
                        class="grid grid-cols-5 lg:grid-cols-3 gap-8 lg:gap-3 mt-12"
                    >
                        <div v-for="data in data.categories">
                            <button
                                :value="data.name"
                                class="bg-white border border-slate-300 shadow-md rounded-lg py-2 px-8 flex justify-evenly items-center gap-4 cursor-pointer hover:bg-orange-600 hover:text-white hover:font-bold transition w-full uppercase tracking-wider"
                                @click="filters.category = data.id"
                                :class="{
                                    'bg-orange-600 text-white':
                                        filters.category == data.id,
                                }"
                            >
                                {{ data.name }}
                            </button>
                        </div>
                    </div>
                    <!--  -->

                    <div class="mt-6">
                        <!-- <Link :href="route('order')"> -->
                        <p
                            class="text-sm text-slate-500 hover:text-slate-800 hover:underline cursor-pointer"
                            @click="reset"
                        >
                            Reset Filter
                        </p>
                        <!-- </Link> -->
                    </div>

                    <div class="overflow-hidden">
                        <Order
                            :foods="data.foods"
                            :categories="categories"
                            :filter="filters.category"
                            :table_id="data.table_id"
                        />
                    </div>
                </div>
            </div>
            <div
                class="px-4 py-12 col-span-3 lg:col-span-5 overflow-y-auto h-screen"
            >
                <Cart :carts="data.carts" :table_id="data.table_id" />
            </div>
        </div>
    </AppLayout>
</template>
