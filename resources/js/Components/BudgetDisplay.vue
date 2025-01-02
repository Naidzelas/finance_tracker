<template>
    <div class="rounded border-6 bg-[white]">
        <div class="grid grid-cols-3 gap-1 p-4 justify-items-center">
            <BudgetItem v-for="item in budget_types" :item="item"></BudgetItem>
        </div>
    </div>
</template>

<script setup>
import BudgetItem from "./BudgetItem.vue";
import { inject } from "vue";
let budget_types = inject("budget_types");
</script>
