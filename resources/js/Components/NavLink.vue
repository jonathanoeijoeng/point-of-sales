<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? "inline-flex items-center px-1 pt-1 border-b-4 border-yellow-300 text-sm font-medium leading-5 text-slate-50 focus:outline-none focus:border-indigo-700 transition"
        : "inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-400 hover:text-slate-100 hover:border-yellow-600 focus:outline-none focus:text-gray-100 focus:border-yellow-600 transition";
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
