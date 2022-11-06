<template>
    <div class="grid grid-cols-4 lg:grid-cols-3 gap-3">
        <FoodCard
            v-for="food in foods"
            :key="food.id"
            :id="food.id"
            :photo="food.photo"
            :name="food.name"
            :description="food.description"
            :price="food.price"
            :unit="food.unit"
            :table_id="table_id"
            :is_favorite="food.is_favorite"
            :is_recommended="food.is_recommended"
        />
    </div>
</template>

<script setup>
import FoodCard from "@/Components/FoodCard.vue";

const data = defineProps({
    foods: {
        type: Object,
    },
    categories: {
        type: Object,
    },
    filter: {
        type: String,
    },
    table_id: {
        type: String,
    },
});
</script>
