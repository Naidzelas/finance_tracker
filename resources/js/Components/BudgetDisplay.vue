<template>
    <div v-if="Object.keys(budget_types).length" class="bg-[white] border-6 rounded">
        <div class="justify-items-center gap-2 grid grid-cols-3 p-4">
            <BudgetItem v-for="item in budget_types" :item="item"></BudgetItem>
        </div>
    </div>
    <div v-else class="bg-[white] pt-6 pb-6 border-6 rounded font-bold text-2xl text-center">No data</div>
</template>

<script setup>
import BudgetItem from "./BudgetItem.vue";
import { inject } from "vue";
let budget_types = inject("budget_types");
</script>
