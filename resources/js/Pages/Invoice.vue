<template>
    <AppLayout>
        <div class="grid xl:grid-cols-12 lg:grid-cols-1 gap-1">
            <div class="w-full sm:px-6 lg:px-8 mt-6 col-span-7">
                <div class="border border-slate-300 rounded-lg">
                    <div class="text-xl bg-slate-300 p-4 font-bold">
                        Invoice List
                    </div>
                    <div>
                        <table
                            class="text-sm w-full text-left divide-y divide-slate-200 rounded-lg"
                        >
                            <thead>
                                <tr
                                    class="bg-slate-200 font-semibold uppercase tracking-widest text-xs"
                                >
                                    <th class="py-3 px-2">Invoice No</th>
                                    <th class="py-3 px-2">Date</th>
                                    <th class="py-3 px-2">Table</th>
                                    <th class="py-3 pr-12 text-right">Total</th>
                                    <th class="py-3 px-2">Status</th>
                                    <th class="py-3 px-2">Paid Time</th>
                                    <th class="py-3 px-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class=""
                                    v-for="invoice in data.invoices"
                                    :key="invoice.id"
                                >
                                    <td class="py-3 px-2">
                                        {{ invoice.invoice_no }}
                                        <span>&nbsp;&nbsp;</span>
                                        <span
                                            class="px-2 py-1 bg-red-600 text-red-50 rounded-lg text-xs"
                                            v-if="
                                                $page.props.invoice_no ==
                                                invoice.invoice_no
                                            "
                                            >New</span
                                        >
                                    </td>
                                    <td class="py-3 px-2">
                                        {{
                                            dayjs(invoice.updated_at).format(
                                                "DD - MMM - YYYY"
                                            )
                                        }}
                                    </td>
                                    <td class="py-3 px-2">
                                        {{ invoice.table.name }}
                                    </td>
                                    <td class="py-3 pr-12 text-right">
                                        {{
                                            Number(
                                                invoice.total
                                            ).toLocaleString()
                                        }}
                                    </td>
                                    <td class="py-3 px-2">
                                        <span
                                            v-if="invoice.is_paid == 1"
                                            class="text-xs bg-green-500 text-white px-2 py-1 rounded-full"
                                            >Paid</span
                                        >
                                        <span
                                            v-else
                                            class="text-xs bg-red-500 text-white px-2 py-1 rounded-full"
                                            >{{ invoice.is_paid }}</span
                                        >
                                    </td>
                                    <td class="py-3 px-2">
                                        <div v-if="invoice.time_paid">
                                            {{
                                                dayjs(invoice.time_paid).format(
                                                    "DD - MMM - YYYY"
                                                )
                                            }}
                                        </div>
                                        <div v-else class="text-center">-</div>
                                    </td>
                                    <td class="py-3 px-2 flex gap-4">
                                        <PrimaryButton
                                            @click="
                                                viewInvoice(invoice.invoice_no)
                                            "
                                            >View</PrimaryButton
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div v-if="data.details" class="col-span-5 mr-6">
                <div class="gap-3 flex mx-auto mt-4 max-w-xl">
                    <PrimaryButton class="text-sm">Print</PrimaryButton>
                    <DangerButton class="text-sm">Cancel</DangerButton>
                </div>
                <div
                    class="my-4 mx-auto py-4 px-8 border border-slate-300 max-w-xl rounded-lg"
                >
                    <div class="flex justify-center gap-4 items-center mt-6">
                        <img class="w-8 h-8" src="/img/icon.svg" alt="" />
                        <div class="text-2xl font-bold">
                            TheNextLevel <span class="font-normal">Resto</span>
                        </div>
                    </div>
                    <div class="text-center text-base mt-3">
                        <div>Taman Kopo Indah III Blok A2 No 15</div>
                        <div class="font-bold">BANDUNG 40218</div>
                    </div>
                    <hr class="mt-3" />
                    <div class="mt-3">
                        <div class="text-sm">
                            INV No:
                            <span>{{ data.invoice_detail.invoice_no }}</span>
                        </div>
                        <div class="text-sm">
                            Date:
                            <span>{{
                                dayjs(data.invoice_detail.time_checkout).format(
                                    "DD MMMM YYYY"
                                )
                            }}</span>
                        </div>
                        <div class="text-sm">
                            Table:
                            <span>{{ data.invoice_detail.table.name }}</span>
                        </div>
                    </div>
                    <hr class="mt-3" />
                    <table class="text-sm w-full my-2">
                        <thead>
                            <tr>
                                <th class="py-1 pr-4 text-left">Item</th>
                                <th class="py-1 px-4 text-center">Qty</th>
                                <th class="py-1 px-4 text-right">Price</th>
                                <th class="py-1 pl-4 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="detail in data.details" :key="detail.id">
                                <td class="py-1 pr-4">
                                    {{ detail.food_detail.name }}
                                </td>
                                <td class="py-1 px-4 text-center">
                                    {{ detail.quantity }}
                                </td>
                                <td class="py-1 px-4 text-right">
                                    Rp.
                                    {{ Number(detail.price).toLocaleString() }}
                                </td>
                                <td class="py-1 pl-4 text-right">
                                    Rp.
                                    {{
                                        Number(
                                            detail.sub_total
                                        ).toLocaleString()
                                    }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <hr class="mt-3" />
                    <div class="flex justify-between mt-3">
                        <div class="text-sm">Subtotal</div>
                        <div class="text-sm">
                            Rp.
                            {{
                                Number(
                                    data.invoice_detail.sub_total
                                ).toLocaleString()
                            }}
                        </div>
                    </div>
                    <div class="flex justify-between mt-3">
                        <div class="text-sm">Discount</div>
                        <div class="text-sm">
                            Rp.
                            {{
                                Number(
                                    data.invoice_detail.discount
                                ).toLocaleString()
                            }}
                        </div>
                    </div>
                    <div class="flex justify-between mt-3">
                        <div class="text-sm">After Disc</div>
                        <div class="text-sm">
                            Rp.
                            {{
                                Number(
                                    data.invoice_detail.after_disc
                                ).toLocaleString()
                            }}
                        </div>
                    </div>
                    <div class="flex justify-between mt-3">
                        <div class="text-sm">Tax</div>
                        <div class="text-sm">
                            Rp.
                            {{
                                data.invoice_detail.tax
                                    ? Number(
                                          data.invoice_detail.tax
                                      ).toLocaleString()
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
                                data.invoice_detail.tax
                                    ? Number(
                                          data.invoice_detail.total
                                      ).toLocaleString()
                                    : 0
                            }}
                        </div>
                    </div>
                    <hr class="mt-3" />
                    <div class="mt-3">
                        <div class="text-sm">
                            Payment Method: <span>Cash</span>
                        </div>
                        <div class="text-sm">
                            Payment Status: <span>Paid</span>
                        </div>
                    </div>
                    <hr class="mt-3" />
                    <div class="mt-3">
                        <div class="text-sm text-center">
                            ----- END of DOCUMENT -----
                        </div>
                    </div>
                </div>
                <div class="gap-3 flex mx-auto mt-4 mb-12 max-w-xl">
                    <PrimaryButton class="text-sm">Print</PrimaryButton>
                    <DangerButton class="text-sm">Cancel</DangerButton>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import dayjs from "dayjs";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { Inertia } from "@inertiajs/inertia";
import route from "../../../vendor/tightenco/ziggy/src/js";

const data = defineProps({
    invoices: {
        type: Object,
    },
    invoice_detail: {
        type: Object,
    },
    details: {
        type: Object,
    },
});

const viewInvoice = (id) => {
    Inertia.get(route("order.invoice"), {
        invoice_no: id,
    });
};
</script>
