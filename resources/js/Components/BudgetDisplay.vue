<template>
    <div class="rounded border-6 bg-[white]">
        <div class="grid grid-cols-3 gap-1 p-4 justify-items-center">
            <BudgetItem v-for="icon in budgetIcons" :iconify_name="icon.iconify_name"></BudgetItem>
        </div>
    </div>
</template>

<script setup>
import BudgetItem from "./BudgetItem.vue";
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()

const budgetIcons = computed(() => page.props.budgetIcons)

</script>
