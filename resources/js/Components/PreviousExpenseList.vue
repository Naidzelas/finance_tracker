<template>
    <div class="border h-lvh text-center">
        <div class="relative flex">
            <div class="bg-[white] mb-2 border-6 rounded w-52 h-8 text-lg">
                {{ previousDate.substring(0, 7) }}
            </div>
            <div class="flex-auto"></div>
            <div>
                <VueDatePicker
                    @change="console.log('test')"
                    v-model="month"
                    :format-locale="lt"
                    month-picker
                >
                    <template #trigger>
                        <div
                            class="place-items-center grid bg-[#3C3C3C] rounded-md size-8 hover:cursor-pointer"
                        >
                            <Icon
                                icon="ion:calendar"
                                color="white"
                                class="size-6"
                            ></Icon>
                        </div>
                    </template>
                </VueDatePicker>
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
        <div class="clear-both' columns-3 bg-[#7B7B7B] border-2 'rounded h-10">
            <div class="pt-1 font-bold text-[white]">Name</div>
            <div class="pt-1 font-bold text-[white]">Amount (Eur)</div>
            <div class="pt-1 font-bold text-[white]">Date</div>
        </div>
        <ExpenseListItem :data="previous_expenses"></ExpenseListItem>
    </div>
</template>

<script setup>
import ExpenseListItem from "../Components/ExpenseListItem.vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import { lt } from "date-fns/locale";
import { router } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const pageVariables = defineProps({
    previous_expenses: Object,
});

const month = ref({
    month: new Date().getMonth(),
    year: new Date().getFullYear(),
});

watch(month, async (newMonth) => {
    let yearMonth = newMonth.year + "-" + (newMonth.month + 1);
    router.get(
        route("expense_list.fetch", {
            yearMonth: yearMonth,
        })
    );
});

// TODO fix this when no data.
let previousDate = new Date(
    pageVariables.previous_expenses[0]["date"]
).toLocaleDateString("lt-LT");
</script>
