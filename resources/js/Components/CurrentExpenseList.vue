<template>
    <div class="border h-lvh text-center">
        <div class="flex">
            <div class="border-6 bg-[white] mb-2 rounded w-52 h-8 text-lg">
                {{ today.substring(0, 7) }}
            </div>
            <div class="flex-auto"></div>
            <div
                class="place-items-center grid bg-[#3C3C3C] ml-1 rounded-md size-8"
            >
                <Icon
                    icon="tabler:category-filled"
                    color="white"
                    class="size-6"
                ></Icon>
            </div>
        </div>
        <div class="clear-both' border-2 bg-[#9E8167] 'rounded h-10 columns-3">
            <div class="pt-1 font-bold text-[white]">Name</div>
            <div class="pt-1 font-bold text-[white]">Amount (Eur)</div>
            <div class="pt-1 font-bold text-[white]">Date</div>
        </div>
        <ExpenseListItem :data="current_expenses"></ExpenseListItem>
    </div>
</template>
<script setup>
import ExpenseListItem from "../Components/ExpenseListItem.vue";
defineProps({
    current_expenses: Object,
});
let segmentDate = new Date();
let today = segmentDate.toLocaleDateString("lt-LT");
</script>
