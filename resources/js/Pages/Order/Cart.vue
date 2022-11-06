<template>
    <div class="px-3">
        <p class="text-2xl font-bold">Current Order</p>
        <p class="text-xl text-slate-500 font-semibold">
            From Table "<span>{{ data.table_id }}</span
            >"
        </p>
        <div v-if="carts.length > 0">
            <div class="mt-8">
                <!-- <TransitionGroup name="leave" tag="ul"> -->
                <div
                    class="grid grid-cols-4 gap-4 mt-4"
                    v-for="cart in data.carts"
                    key="data.id"
                >
                    <img
                        v-if="cart.food_detail.photo"
                        :src="`storage/images/foods/` + cart.food_detail.photo"
                        alt=""
                        class="rounded-md"
                    />
                    <img
                        v-else
                        src="https://via.placeholder.com/200x200"
                        alt=""
                    />
                    <div class="flex flex-col col-span-3">
                        <p class="font-bold text-lg leading-6 flex-1">
                            {{ cart.name }}
                        </p>
                        <div class="flex justify-between items-center mt-5">
                            <p class="text-orange-600 font-bold">
                                IDR
                                {{ Number(cart.sub_total).toLocaleString() }}
                            </p>
                            <div class="flex gap-3">
                                <DangerButton
                                    class="py-1 px-2"
                                    @click="addOrder(cart)"
                                    >+</DangerButton
                                >
                                <span>{{ cart.quantity }}</span>
                                <DangerButton
                                    class="py-1 px-2"
                                    @click="minusOrder(cart)"
                                    >-</DangerButton
                                >
                            </div>
                        </div>
                        <div class="mt-3" @click="addNoteDisc(cart)">
                            <p class="text-sm cursor-pointer">
                                Note:
                                <span class="text-slate-600">{{
                                    cart.notes
                                }}</span>
                            </p>
                            <p class="text-sm cursor-pointer">
                                Disc:
                                <span class="text-slate-600"
                                    >{{ cart.discount }} %</span
                                >
                            </p>
                        </div>
                        <div class="mt-3">
                            <p
                                class="text-sm text-red-500 font-bold"
                                v-if="cart.is_sent_to_kitchen == 0"
                            >
                                <span> Not sent to kitchen yet</span>
                                <span></span>
                            </p>
                            <p
                                class="text-sm text-green-600 font-bold"
                                v-else-if="cart.is_done == 1"
                            >
                                <span>Order is done at </span>
                                <span class="font-normal">{{
                                    dayjs(cart.time_done).format("HH:mm")
                                }}</span>
                            </p>
                            <p
                                class="text-sm text-green-600 font-bold"
                                v-else-if="cart.is_processed == 1"
                            >
                                <span>Processed at </span>
                                <span class="font-normal">{{
                                    dayjs(cart.time_processed).format("HH:mm")
                                }}</span>
                            </p>
                            <p
                                class="text-sm text-green-600 font-bold"
                                v-else-if="cart.is_sent_to_kitchen == 1"
                            >
                                <span>Sent to kitchen at </span>
                                <span class="font-normal">{{
                                    dayjs(cart.time_sent_to_kitchen).format(
                                        "HH:mm"
                                    )
                                }}</span>
                            </p>
                        </div>
                        <div class="border-b bg-slate-100 mt-4"></div>
                    </div>
                </div>
                <!-- </TransitionGroup> -->
            </div>
            <div class="mt-8 py-6 bg-slate-200 rounded-lg text-slate-500">
                <div class="flex justify-between">
                    <p class="px-6">Sub Total</p>
                    <p class="px-6 font-bold">
                        IDR
                        {{
                            Number(sub_total_1).toLocaleString(undefined, {
                                maximumFractionDigits: 0,
                            })
                        }}
                    </p>
                </div>
                <div class="flex justify-between mt-3">
                    <p class="px-6">Total Discount</p>
                    <p class="px-6 font-bold">
                        IDR
                        {{
                            Number(discount).toLocaleString(undefined, {
                                maximumFractionDigits: 0,
                            })
                        }}
                    </p>
                </div>
                <div class="flex justify-between mt-3">
                    <p class="px-6">After Disc</p>
                    <p class="px-6 font-bold">
                        IDR
                        {{
                            Number(sub_total_2).toLocaleString(undefined, {
                                maximumFractionDigits: 0,
                            })
                        }}
                    </p>
                </div>
                <div class="flex justify-between mt-3">
                    <p class="px-6">Tax 10%</p>
                    <p class="px-6 font-bold">
                        IDR
                        {{
                            Number(tax_value).toLocaleString(undefined, {
                                maximumFractionDigits: 0,
                            })
                        }}
                    </p>
                </div>
                <div class="flex justify-between my-4">
                    <div class="bg-white rounded-full w-6 h-6 -ml-3"></div>
                    <div class="flex-1"></div>
                    <div class="bg-white rounded-full w-6 h-6 -mr-3"></div>
                </div>

                <div class="flex justify-between mt-3">
                    <p class="px-6 font-bold text-lg text-slate-700">TOTAL</p>
                    <p class="px-6 font-bold text-lg text-slate-700">
                        IDR
                        {{
                            Number(total).toLocaleString(undefined, {
                                maximumFractionDigits: 0,
                            })
                        }}
                    </p>
                </div>
            </div>
            <div>
                <GreenButton
                    disabled
                    class="w-full mt-8"
                    v-if="all_sent_to_kitchen"
                    >Send to kitchen
                </GreenButton>
                <GreenButton class="w-full mt-8" @click="sent_to_kitchen" v-else
                    >Send to kitchen
                </GreenButton>
            </div>
            <div>
                <CheckoutButton
                    class="w-full mt-8"
                    @click="checkout"
                    v-if="data.carts.length > 0 && all_done"
                    >Checkout Now
                </CheckoutButton>
                <CheckoutButton disabled class="w-full mt-8" v-else
                    >Checkout Now
                </CheckoutButton>
            </div>
        </div>
        <div v-else class="mt-16">
            <img src="/img/no-order.svg" alt="" />
        </div>
    </div>
    <DialogModal :show="showModal" @close="showModal = false">
        <template #title>
            <div class="font-semibold">Add / Edit Note</div>
        </template>
        <template #content>
            <InputLabel for="notes" value="Notes" />
            <textarea
                v-model="modal.notes"
                class="w-full border border-slate-300 rounded-md p-2"
                rows="3"
            ></textarea>
            <InputLabel for="notes" value="Discount (%)" class="mt-3" />
            <TextInput
                v-model="modal.discount"
                type="number"
                class="w-full border border-slate-300 rounded-md p-2"
            />
        </template>
        <template #footer>
            <div class="flex justify-end gap-3">
                <PrimaryButton @click="submit">Update</PrimaryButton>
                <DangerButton @click="showModal = !showModal">
                    Back
                </DangerButton>
            </div>
        </template>
    </DialogModal>
</template>

<script setup>
import { ref, computed, reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";
import dayjs from "dayjs";
import CheckoutButton from "@/Components/CheckoutButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import GreenButton from "@/Components/GreenButton.vue";
import DialogModal from "@/Components/DialogModal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import Swal from "sweetalert2";

const data = defineProps({
    carts: {
        type: Object,
    },
    table_id: {
        type: String,
    },
});
const showModal = ref(false);

const modal = reactive({
    id: "",
    notes: "",
    discount: "",
});

const sub_total_1 = computed(() => {
    let sub_total_1 = 0;
    data.carts.forEach((cart) => {
        sub_total_1 += cart.food_detail.price * cart.quantity;
    });
    return sub_total_1;
});

const sub_total_2 = computed(() => {
    let sub_total_2 = 0;
    data.carts.forEach((cart) => {
        sub_total_2 +=
            (cart.food_detail.price * cart.quantity * (100 - cart.discount)) /
            100;
    });
    return sub_total_2;
});

const tax = ref(0.1);
const tax_value = computed(() => {
    return sub_total_2.value * tax.value;
});

const discount = computed(() => {
    let discount = 0;
    data.carts.forEach((cart) => {
        discount +=
            (cart.food_detail.price * cart.quantity * cart.discount) / 100;
    });
    return discount;
});

const total = computed(() => {
    return sub_total_2.value + tax_value.value;
});

const checkout = () => {
    Swal.fire({
        title: "Are you sure?",
        text: "You will checkout all items",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, checkout all items!",
    }).then((result) => {
        if (result.isConfirmed) {
            Inertia.post(
                route("order.checkout"),
                {
                    data: {
                        carts: data.carts,
                        table_id: data.table_id,
                        total: total.value,
                    },
                },
                { preserveScroll: true }
            );
            // Swal.fire("Checkout!", "Checkout succesfully.", "success");
        }
    });
};

const addOrder = (cart) => {
    Inertia.post(
        route("order.change"),
        {
            data: {
                id: cart.id,
                quantity: cart.quantity + 1,
            },
        },
        { preserveScroll: true }
    );
};

const minusOrder = (cart) => {
    Inertia.post(
        route("order.change"),
        {
            data: {
                id: cart.id,
                quantity: cart.quantity - 1,
            },
        },
        { preserveScroll: true }
    );
};

const addNoteDisc = (cart) => {
    showModal.value = true;
    modal.notes = cart.notes;
    modal.id = cart.id;
    modal.discount = cart.discount;
};

const submit = () => {
    Inertia.post(
        route("order.note"),
        {
            data: {
                id: modal.id,
                notes: modal.notes,
                discount: modal.discount,
            },
        },
        { preserveScroll: true }
    );
    showModal.value = false;
};

const sent_to_kitchen = () => {
    Swal.fire({
        title: "Are you sure?",
        text: "You will sent all items to kitchen",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, sent all items to kitchen!",
    }).then((result) => {
        if (result.isConfirmed) {
            Inertia.post(
                route("order.sent_to_kitchen"),
                {
                    data: {
                        carts: data.carts,
                        table_id: data.table_id,
                    },
                },
                { preserveScroll: true }
            );
            // Swal.fire("Checkout!", "Checkout succesfully.", "success");
        }
    });
};

const all_sent_to_kitchen = computed(() => {
    let all_sent_to_kitchen = true;
    data.carts.forEach((cart) => {
        if (cart.is_sent_to_kitchen == false) {
            all_sent_to_kitchen = false;
        }
    });
    return all_sent_to_kitchen;
});

const all_done = computed(() => {
    let all_done = true;
    data.carts.forEach((cart) => {
        if (cart.is_done == false) {
            all_done = false;
        }
    });
    return all_done;
});
</script>

<style>
.list-enter-active,
.list-leave-active {
    transition: all 1s ease;
}
.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateX(30px);
}

.leave-enter-active,
.leave-leave-active {
    transform-origin: 50% 50%;
    transition: transform 0.5s cubic-bezier(0.61, 1, 0.88, 1);
    transition-property: transform, opacity;
}
.leave-enter,
.leave-leave-to {
    transform: scale(0) rotate(-60deg);
}
</style>
