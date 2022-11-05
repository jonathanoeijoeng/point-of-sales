<template></template>
<script setup>
import Swal from "sweetalert2";
import { watch } from "vue";

const data = defineProps({
    flash: {
        type: Object,
    },
});

watch(
    () => data.flash,
    (newVal, oldVal) => {
        if (data.flash.toast) {
            Swal.fire({
                title: data.flash.title,
                text: data.flash.text,
                html: data.flash.html,
                icon: data.flash.type,
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false,
                toast: true,
                position: "top-end",
            });
        } else {
            Swal.fire({
                title: data.flash.title,
                text: data.flash.text,
                html: data.flash.html,
                icon: data.flash.type,
                timerProgressBar: true,
                showConfirmButton: true,
                toast: false,
            });
        }
    },
    { immediate: true }
);
</script>
