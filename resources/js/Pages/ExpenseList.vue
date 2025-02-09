<template>
    <section class="flex flex-col mr-40 ml-40">
        <div class="text-5xl">all expenses</div>
        <div class="mt-1 mb-10 text-md">finance • all expenses</div>
        <div v-for="(expense, index) in expenses">
            <div v-if="isNewDate(index)" class="flex">
                <div
                    class="border-6 bg-[#C9AA8E] mb-2 rounded w-36 h-8 font-bold text-center text-lg text-white"
                >
                    {{ expense.YM }}
                </div>
                <div class="flex-auto"></div>
                <div
                    class="place-items-center grid bg-[#3C3C3C] rounded-md size-8"
                >
                    <Icon
                        icon="ion:calendar"
                        color="white"
                        class="size-6"
                    ></Icon>
                </div>
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
            <div class="flex bg-[#F4F4F4] mb-[-1em] p-3 rounded-md">
                <div class="flex pr-10 pl-10">
                    <div>
                        <Icon icon="lucide:house" class="size-12"></Icon>
                    </div>
                </div>
                <div class="flex pr-36">
                    <div>{{ expense.type_id + " type name" }}</div>
                </div>
                <div class="flex flex-col flex-1 pr-6">
                    <div class="font-bold">Name</div>
                    <div>{{ expense.transaction_name }}</div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">Amount</div>
                    <div>{{ expense.amount }}</div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">Date</div>
                    <div>{{ expense.date }}</div>
                </div>
            </div>
            <DetailsDisplay></DetailsDisplay>
        </div>
        <WhenVisible
            always
            :params="{
                data: {
                    page: expenses_paginated.current_page + 1,
                },
                only: ['expenses', 'expenses_paginated'],
            }"
        >
            <template #fallback>
                <div class="text-center">
                    <Icon
                        icon="mingcute:loading-fill"
                        class="animate-spin size-6"
                    ></Icon>
                </div>
            </template>
        </WhenVisible>
    </section>
</template>

<script setup>
import DetailsDisplay from "../Components/DetailsDisplay.vue";
import { WhenVisible } from "@inertiajs/vue3";

let pageVaribalbes = defineProps({
    expenses: Object,
    expenses_paginated: Object,
});

// TODO clean this up and add full URL reload
const isNewDate = (index) => {
    return (
        index === 0 ||
        pageVaribalbes.expenses[index].YM !==
            pageVaribalbes.expenses[index - 1].YM
    );
};

</script>
