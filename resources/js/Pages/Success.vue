<template>
    <AppLayout>
        {{ data.data }}
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import Swal from "sweetalert2";

const data = defineProps({
    data: Object,
});

// Swal.fire({
//     title: "<strong>Success!</strong>",
//     text: "Payment Success",
//     icon: "success",
//     showCancelButton: false,
//     confirmButtonColor: "#3085d6",
//     cancelButtonColor: "#d33",
//     confirmButtonText: "OK",
// }).then((result) => {
//     if (result.isConfirmed) {
//         Inertia.get(route("table"));
//     }
// });
</script>
