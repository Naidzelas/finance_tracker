<template>
    <div class="bg-[white] border-6 rounded">
        <div class="justify-items-center gap-2 grid grid-cols-3 p-4">
            <BudgetItem v-for="item in budget_types" :item="item"></BudgetItem>
        </div>
    </div>
</template>

<script setup>
import BudgetItem from "./BudgetItem.vue";
import { inject } from "vue";
let budget_types = inject("budget_types");
</script>
