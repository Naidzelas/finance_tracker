<template>
    <div class="text-center border h-lvh">
        <div class="flex">
            <div v-if="state.primary" class="rounded border-6 bg-[white] w-52 h-8 text-lg mb-2">
                {{ today.substring(0,7) }}
            </div>
            <div v-else class="rounded border-6 bg-[white] w-52 h-8 text-lg mb-2">
                {{ previousDate.substring(0,7) }}
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
        <ExpenseListItem v-for="expense in expenses" :data="expense" :tableDates="tableDates"></ExpenseListItem>
    </div>
</template>
<script setup>
import ExpenseListItem from "../Components/ExpenseListItem.vue";
import { inject } from "vue";

let expenses = inject('expenses');
let state = defineProps({ primary: Boolean });
let headerColor = state.primary ? "bg-[#9E8167]" : "bg-[#7B7B7B]";
let segmentDate = new Date();
let today = segmentDate.toLocaleDateString('lt-LT');
let previousDate = new Date(segmentDate.setMonth(segmentDate.getMonth() - 1)).toLocaleDateString('lt-LT');

let tableDates = {
    primaryDate: today,
    secondaryDate: previousDate,
    state: state.primary
};
</script>
