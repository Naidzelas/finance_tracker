<template>
    <section class="clear-both flex justify-center">
        <div
            class="clear-both grid grid-cols-3 w-screen gap-10 mr-40 ml-40 mb-10"
        >
            <div class="col-span-2 text-4xl">current expenses</div>
            <div class="text-4xl">personal Information</div>
            <ExpenseList></ExpenseList>
            <ExpenseList :primary="true"></ExpenseList>
            <div>
                <div class="text-left text-2xl mb-6">basic info</div>
                <BasicInfo></BasicInfo>

                <div class="text-left text-2xl mb-6 mt-6">budget remaining</div>
                <div class="flex justify-end mt-[-2em] mb-2">
                    <Link
                        href="/budget/create"
                        method="get"
                        as="button"
                        type="button"
                        class="text-md uppercase flex bg-[#3B3B3B] text-white p-2 rounded"
                    >
                        <Icon
                            icon="carbon:add-filled"
                            class="size-6 mr-1"
                        ></Icon>
                        Add new
                    </Link>
                </div>

                <BudgetDisplay></BudgetDisplay>
                <div class="text-left text-2xl mb-6 mt-6">upcoming news</div>
                <NewsInfo></NewsInfo>
                <div class="text-left text-2xl mb-6 mt-6">goals</div>
                <div class="flex justify-end mt-[-2em] mb-2">
                    <Link
                        href="/goal/create"
                        method="get"
                        as="button"
                        type="button"
                        class="text-md uppercase flex bg-[#3B3B3B] text-white p-2 rounded"
                    >
                        <Icon
                            icon="carbon:add-filled"
                            class="size-6 mr-1"
                        ></Icon>
                        Add new
                    </Link>
                </div>
                <GoalInfo :goal_data="goals"></GoalInfo>
            </div>
        </div>
    </section>
</template>
<script setup>
import { provide, ref } from "vue";
import { Link } from "@inertiajs/vue3";
import ExpenseList from "../Components/MonthExpenseList.vue";
import BasicInfo from "../Components/BasicInfoDisplay.vue";
import BudgetDisplay from "../Components/BudgetDisplay.vue";
import NewsInfo from "../Components/NewsDisplay.vue";
import GoalInfo from "../Components/GoalDisplay.vue";

let pageVariables = defineProps({
    expenses: Object,
    budget_types: Object,
    goals: Object,
});
provide("expenses", pageVariables.expenses);
provide("budget_types", ref(pageVariables.budget_types));
</script>
