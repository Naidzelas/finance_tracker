<template>
    <ScrollPanel class="h-full">
        <div class="flex flex-col gap-4 md:grid md:grid-cols-1 lg:grid-cols-3">
            <div class="md:col-span-3">
                <BasicInfoDisplay :debt="debt" :invested="invested" />
            </div>
            <div>
                <BudgetDisplay></BudgetDisplay>
            </div>
            <div class="col-span-1">
                <GoalInfo :goal_data="goals"></GoalInfo>
            </div>
            <div></div>
            <div
                class="flex md:col-span-2 bg-surface-50 dark:bg-surface-950 px-6 md:px-12 lg:px-20 py-8 -full"
            >
                <DataTable
                    :value="current_expenses"
                    class="bg-surface-0 shadow-lg p-8 border !rounded-2xl md:!w-full"
                    paginator
                    :scrollable="true"
                    scrollHeight="600px"
                    :rows="10"
                    :rowsPerPageOptions="[5, 10, 20, 50]"
                >
                    <template #header>
                        <div class="flex justify-between items-center">
                            <h2 class="font-bold text-2xl">
                                {{ $t("general.expenses") }}
                            </h2>
                        </div>
                    </template>
                    <Column field="transaction_name" header="Name" />
                    <Column field="amount" header="Amount" />
                    <Column field="date" header="Date" />
                </DataTable>
                <Divider class="bg-surface-50" layout="vertical"
                    ><b>Compare</b></Divider
                >
                <DataTable
                :value="previous_expenses"
                class="bg-surface-0 shadow-lg p-8 border !rounded-2xl !w-full"
                paginator
                :scrollable="true"
                scrollHeight="600px"
                :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50]"
                >
                    <template #header>
                        <div class="flex justify-between items-center">
                            <h2 class="font-bold text-2xl">
                                {{ $t("general.previous_expenses") }}
                            </h2>
                            <DatePicker
                                view="month"
                                dateFormat="yy-mm"
                                showIcon
                                v-model="previousDate"
                                @update:model-value="fetchData"
                            />
                        </div>
                    </template>
                    <Column field="transaction_name" header="Name" />
                    <Column field="amount" header="Amount" />
                    <Column field="date" header="Date" />
                </DataTable>
            </div>
            <div
                class="flex col-span-1 bg-surface-50 dark:bg-surface-950 px-6 md:px-12 lg:px-20 py-8"
            >
                <div
                    class="bg-surface-0 shadow-lg p-8 border !rounded-2xl !w-full"
                >
                    <ComparedExpenses />
                </div>
            </div>
        </div>
    </ScrollPanel>
</template>
<script setup>
import { provide, ref } from "vue";
import { Column, DataTable, DatePicker, ScrollPanel, Divider } from "primevue";
import { router } from "@inertiajs/vue3";
import ComparedExpenses from "../Components/ComparedExpenses.vue";
import BudgetDisplay from "../Components/BudgetDisplay.vue";
import GoalInfo from "../Components/GoalDisplay.vue";
import BasicInfoDisplay from "../Components/BasicInfoDisplay.vue";

let pageVariables = defineProps({
    expenses: Object,
    budget_types: Object,
    goals: Object,
    current_expenses: Object,
    previous_expenses: Object,
    invested: Number,
    debt: Object,
    previous_date: String
});

const previousDate = ref(pageVariables.previous_date); // Set to 30 days before current date
const expenses = ref([]);

function fetchData() {
    router.visit(route("index"), {
        data: {
            previous_date: previousDate.value,
        },
        only: ["previous_expenses", "previous_date"],
        // preserveState: true,
        // preserveScroll: true,
    });
}

   
provide("expenses", expenses);
provide("budget_types", ref(pageVariables.budget_types));
</script>
