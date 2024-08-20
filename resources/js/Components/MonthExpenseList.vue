<template>
    <div class="text-center border h-lvh">
        <div class="flex">
            <div class="rounded border-6 bg-[white] w-52 h-8 text-lg mb-2">
                2024-05
            </div>
            <div class="flex-auto"></div>
            <div
                v-if="!state.primary"
                class="bg-[#3C3C3C] rounded-md size-8 grid place-items-center"
            >
                <Icon icon="ion:calendar" color="white" class="size-6"></Icon>
            </div>
            <div
                class="bg-[#3C3C3C] rounded-md size-8 grid place-items-center ml-1"
            >
                <Icon
                    icon="tabler:category-filled"
                    color="white"
                    class="size-6"
                ></Icon>
            </div>
        </div>
        <div
            :class="
                'rounded border-2 ' + headerColor + ' columns-3 h-10 clear-both'
            "
        >
            <div class="text-[white] font-bold pt-1">Name</div>
            <div class="text-[white] font-bold pt-1">Amount (Eur)</div>
            <div class="text-[white] font-bold pt-1">Date</div>
        </div>
        <ExpenseListItem></ExpenseListItem>
    </div>
</template>
<script setup>
import ExpenseListItem from "../Components/ExpenseListItem.vue";
let state = defineProps({ primary: Boolean });
let headerColor = state.primary ? "bg-[#9E8167]" : "bg-[#7B7B7B]";
</script>
