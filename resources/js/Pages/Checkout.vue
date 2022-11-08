<template>
    <AppLayout>
        <div
            class="w-1/2 mx-auto p-8 border border-slate-300 rounded-lg mt-6 shadow-md"
        >
            <div class="text-2xl font-bold">Order Checkout</div>
            <div class="mt-3">
                <div>
                    INV No:
                    <span>{{ data.invoice.invoice_no }}</span>
                </div>
                <div>
                    Date:
                    <span>{{
                        dayjs(data.invoice.time_checkout).format("DD MMMM YYYY")
                    }}</span>
                </div>
                <div>
                    Table:
                    <span>{{ data.invoice.table.name }}</span>
                </div>
            </div>
            <hr class="mt-3" />
            <table class="my-2 w-full">
                <thead>
                    <tr>
                        <th class="py-1 pr-4 text-left">Item</th>
                        <th class="py-1 px-4 text-center">Qty</th>
                        <th class="py-1 px-4 text-right">Price</th>
                        <th class="py-1 pl-4 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="cart in data.carts" :key="cart.id">
                        <td class="py-1 pr-4">
                            {{ cart.food_detail.name }}
                        </td>
                        <td class="py-1 px-4 text-center">
                            {{ cart.quantity }}
                        </td>
                        <td class="py-1 px-4 text-right">
                            Rp.
                            {{ Number(cart.price).toLocaleString() }}
                        </td>
                        <td class="py-1 pl-4 text-right">
                            Rp.
                            {{ Number(cart.sub_total).toLocaleString() }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr />
            <div class="flex justify-between mt-3">
                <div>Subtotal</div>
                <div>
                    Rp.
                    {{ Number(data.invoice.sub_total).toLocaleString() }}
                </div>
            </div>
            <div class="flex justify-between mt-3">
                <div>Discount</div>
                <div>
                    Rp.
                    {{ Number(data.invoice.discount).toLocaleString() }}
                </div>
            </div>
            <div class="flex justify-between mt-3">
                <div>After Disc</div>
                <div>
                    Rp.
                    {{ Number(data.invoice.after_disc).toLocaleString() }}
                </div>
            </div>
            <div class="flex justify-between mt-3">
                <div>Tax</div>
                <div>
                    Rp.
                    {{
                        data.invoice.tax
                            ? Number(data.invoice.tax).toLocaleString()
                            : 0
                    }}
                </div>
            </div>
            <hr class="mt-3" />
            <div class="flex justify-between mt-3 font-bold">
                <div class="text-base">Total</div>
                <div class="text-base">
                    Rp.
                    {{
                        data.invoice.tax
                            ? Number(data.invoice.total).toLocaleString()
                            : 0
                    }}
                </div>
            </div>
            <hr class="mt-3" />
            <div class="mt-3 font-bold">Payment Type:</div>
            <select
                class="w-full mt-2 p-2 border border-slate-300 rounded-lg"
                name=""
                id=""
                v-model="payment_type"
            >
                <option value="1">Cash</option>
                <option value="2">Credit Card</option>
                <option value="3">GoPay</option>
                <option value="4">OVO</option>
            </select>
            <div v-if="payment_type == 1">
                <div class="mt-3 w-full">
                    <InputLabel value="Payment Amount" />
                    <TextInput
                        id="payment_amount"
                        type="number"
                        class="mt-1 block w-full py-2 text-2xl"
                        v-model="payment_amount"
                    />
                </div>
                <div class="mt-3 w-full text-right">
                    <div class="font-bold">Change:</div>
                    <div class="font-bold text-3xl text-right">
                        Rp. {{ Number(change).toLocaleString() }}
                    </div>
                </div>
            </div>
            <div>
                <button
                    class="bg-green-500 text-white px-4 py-4 text-lg rounded-lg mt-3"
                    @click="checked_out"
                >
                    Pay Bill
                </button>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import dayjs from "dayjs";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";

const data = defineProps({
    carts: Object,
    table_id: String,
    invoice: Object,
    snapToken: String,
});

const payment_type = ref(1);

const payment_amount = ref(0);
const change = computed(() => {
    return payment_amount.value - data.invoice.total;
});

const checked_out = () => {
    if (payment_type.value == 1) {
        if (payment_amount.value < data.invoice.total) {
            alert("Payment amount is not enough");
            return;
        }
    } else {
        window.snap.pay(data.snapToken);
    }
};
</script>
