<template>
    <AppLayout>
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
                    INV No: <span>12521-1212-121-25</span>
                </div>
                <div class="text-sm">Date: <span>12/12/2021</span></div>
                <div class="text-sm">Table: <span>1</span></div>
            </div>
            <hr class="mt-3" />
            <div>
                <div class="flex justify-between mt-3 font-bold">
                    <div class="text-sm">Item</div>
                    <div class="text-sm">Qty</div>
                    <div class="text-sm">Price</div>
                    <div class="text-sm">Total</div>
                </div>
                <div class="flex justify-between mt-3">
                    <div class="text-sm">Nasi Goreng</div>
                    <div class="text-sm">1</div>
                    <div class="text-sm">Rp. 10.000</div>
                    <div class="text-sm">Rp. 10.000</div>
                </div>
                <div class="flex justify-between mt-3">
                    <div class="text-sm">Nasi Goreng</div>
                    <div class="text-sm">2</div>
                    <div class="text-sm">Rp. 10.000</div>
                    <div class="text-sm">Rp. 20.000</div>
                </div>
                <div class="flex justify-between mt-3">
                    <div class="text-sm">Nasi Goreng</div>
                    <div class="text-sm">1</div>
                    <div class="text-sm">Rp. 10.000</div>
                    <div class="text-sm">Rp. 10.000</div>
                </div>
                <div class="flex justify-between mt-3">
                    <div class="text-sm">Nasi Goreng</div>
                    <div class="text-sm">4</div>
                    <div class="text-sm">Rp. 10.000</div>
                    <div class="text-sm">Rp. 40.000</div>
                </div>
            </div>
            <hr class="mt-3" />
            <div class="flex justify-between mt-3">
                <div class="text-sm">Subtotal</div>
                <div class="text-sm">Rp. 80.000</div>
            </div>
            <div class="flex justify-between mt-3">
                <div class="text-sm">Discount</div>
                <div class="text-sm">Rp. 0</div>
            </div>
            <div class="flex justify-between mt-3">
                <div class="text-sm">Tax</div>
                <div class="text-sm">Rp. 8.000</div>
            </div>
            <hr class="mt-3" />
            <div class="flex justify-between mt-3 font-bold">
                <div class="text-base">Total</div>
                <div class="text-base">Rp. 88.000</div>
            </div>
            <hr class="mt-3" />
            <div class="mt-3">
                <div class="text-sm">Payment Method: <span>Cash</span></div>
                <div class="text-sm">Payment Status: <span>Paid</span></div>
            </div>
            <hr class="mt-3" />
            <div class="mt-3">
                <div class="text-sm text-center">----- END BILL -----</div>
            </div>
        </div>
        <div class="gap-3 flex mx-auto mt-4 mb-12 max-w-xl">
            <PrimaryButton class="text-sm">Print</PrimaryButton>
            <DangerButton class="text-sm">Cancel</DangerButton>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
</script>
