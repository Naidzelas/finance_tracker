<template>
    <ScrollPanel class="h-full">
        <div class="gap-4 grid grid-cols-1 lg:grid-cols-3">
            <div class="col-span-3">
                <BasicInfoDisplay :debt="debt" :invested="invested" />
            </div>
            <div>
                <BudgetDisplay></BudgetDisplay>
            </div>
            <div class="col-span-1">
                <GoalInfo :goal_data="goals"></GoalInfo>
            </div>
            <div class="col-span-2">
                <DataTable
                    :value="expenses"
                    class="!w-full"
                    paginator
                    :rows="10"
                    :rowsPerPageOptions="[5, 10, 20, 50]"
                >
                    <template #header>
                        <div class="flex justify-between items-center">
                            <h2 class="font-bold text-2xl">
                                {{ $t("general.expenses") }}
                            </h2>
                            <DatePicker
                                view="month"
                                dateFormat="yy-mm"
                                showIcon
                            />
                        </div>
                    </template>
                    <Column field="name" header="Name" />
                    <Column field="amount" header="Amount" />
                    <Column field="date" header="Date" />
                </DataTable>
            </div>
            <div>
                <DataTable
                    :value="expenses"
                    class="w-full"
                    paginator
                    :rows="10"
                    :rowsPerPageOptions="[5, 10, 20, 50]"
                >
                    <template #header>
                        <div class="flex justify-between items-center">
                            <h2 class="font-bold text-2xl">
                                {{ $t("general.expenses") }}
                            </h2>
                            <DatePicker
                                view="month"
                                dateFormat="yy-mm"
                                showIcon
                            />
                        </div>
                    </template>
                    <Column field="name" header="Name" />
                    <Column field="amount" header="Amount" />
                    <Column field="date" header="Date" />
                </DataTable>
            </div>
        </div>
    </ScrollPanel>
</template>
<script setup>
import { provide, ref } from "vue";
import { Column, DataTable, DatePicker, ScrollPanel } from "primevue";
import { Link } from "@inertiajs/vue3";
import BasicInfo from "../Components/BasicInfoDisplay.vue";
import BudgetDisplay from "../Components/BudgetDisplay.vue";
import NewsInfo from "../Components/NewsDisplay.vue";
import GoalInfo from "../Components/GoalDisplay.vue";
import PreviousExpenseList from "../Components/PreviousExpenseList.vue";
import CurrentExpenseList from "../Components/CurrentExpenseList.vue";
import BasicInfoDisplay from "../Components/BasicInfoDisplay.vue";

// Add test data for DataTable
const testExpenses = [
    { name: "Groceries", amount: 120.5, date: "2024-06-01" },
    { name: "Utilities", amount: 80.0, date: "2024-06-03" },
    { name: "Internet", amount: 45.99, date: "2024-06-05" },
    { name: "Transport", amount: 60.0, date: "2024-06-07" },
    { name: "Dining Out", amount: 35.2, date: "2024-06-09" },
    { name: "Groceries", amount: 120.5, date: "2024-06-01" },
    { name: "Utilities", amount: 80.0, date: "2024-06-03" },
    { name: "Internet", amount: 45.99, date: "2024-06-05" },
    { name: "Transport", amount: 60.0, date: "2024-06-07" },
    { name: "Dining Out", amount: 35.2, date: "2024-06-09" },
    { name: "Groceries", amount: 120.5, date: "2024-06-01" },
    { name: "Utilities", amount: 80.0, date: "2024-06-03" },
    { name: "Internet", amount: 45.99, date: "2024-06-05" },
    { name: "Transport", amount: 60.0, date: "2024-06-07" },
    { name: "Dining Out", amount: 35.2, date: "2024-06-09" },
    { name: "Groceries", amount: 120.5, date: "2024-06-01" },
    { name: "Utilities", amount: 80.0, date: "2024-06-03" },
    { name: "Internet", amount: 45.99, date: "2024-06-05" },
    { name: "Transport", amount: 60.0, date: "2024-06-07" },
    { name: "Dining Out", amount: 35.2, date: "2024-06-09" },
];

let pageVariables = defineProps({
    expenses: Object,
    budget_types: Object,
    goals: Object,
    current_expenses: Object,
    previous_expenses: Object,
    invested: Number,
    debt: Object,
});

// Use test data if no expenses are provided
const expenses =
    pageVariables.expenses && Object.keys(pageVariables.expenses).length
        ? pageVariables.expenses
        : testExpenses;

provide("expenses", expenses);
provide("budget_types", ref(pageVariables.budget_types));
</script>
