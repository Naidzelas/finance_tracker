<template>
    <section class="clear-both flex justify-center">
        <div
            class="clear-both gap-10 grid grid-cols-3 mr-40 mb-10 ml-40 w-screen"
        >
            <div class="col-span-2 text-4xl">
                {{ $t("expenses.title").toLocaleLowerCase() }}
            </div>
            <div class="text-4xl">{{ $t("expenses.personal_information").toLocaleLowerCase() }}</div>
            <PreviousExpenseList
                :previous_expenses="previous_expenses"
                :budget_types="budget_types"
            ></PreviousExpenseList>
            <CurrentExpenseList
                :current_expenses="current_expenses"
                :budget_types="budget_types"
            ></CurrentExpenseList>
            <div>
                <div class="mb-6 text-2xl text-left">
                    {{ $t("expenses.basic_info").toLocaleLowerCase() }}
                </div>
                <BasicInfo :debt="debt" :invested="invested"></BasicInfo>

                <div class="mt-6 mb-6 text-2xl text-left">
                    {{ $t("expenses.budget_remaining").toLocaleLowerCase() }}
                </div>
                <div class="flex justify-end mt-[-2em] mb-2">
                    <Link
                        href="/budget/create"
                        method="get"
                        as="button"
                        type="button"
                        class="flex bg-[#3B3B3B] p-2 rounded text-md text-white uppercase"
                    >
                        <Icon
                            icon="carbon:add-filled"
                            class="mr-1 size-6"
                        ></Icon>
                        {{ $t("general.add_new") }}
                    </Link>
                </div>

                <BudgetDisplay></BudgetDisplay>
                <div class="mt-6 mb-6 text-2xl text-left">
                    {{ $t("expenses.upcoming_news").toLocaleLowerCase() }}
                </div>
                <NewsInfo></NewsInfo>
                <div class="mt-6 mb-6 text-2xl text-left">
                    {{ $t("expenses.goals").toLocaleLowerCase() }}
                </div>
                <div class="flex justify-end mt-[-2em] mb-2">
                    <Link
                        :href="route('goal.create')"
                        method="get"
                        as="button"
                        type="button"
                        class="flex bg-[#3B3B3B] p-2 rounded text-md text-white uppercase"
                    >
                        <Icon
                            icon="carbon:add-filled"
                            class="mr-1 size-6"
                        ></Icon>
                        {{ $t("general.add_new") }}
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
import BasicInfo from "../Components/BasicInfoDisplay.vue";
import BudgetDisplay from "../Components/BudgetDisplay.vue";
import NewsInfo from "../Components/NewsDisplay.vue";
import GoalInfo from "../Components/GoalDisplay.vue";
import PreviousExpenseList from "../Components/PreviousExpenseList.vue";
import CurrentExpenseList from "../Components/CurrentExpenseList.vue";

let pageVariables = defineProps({
    expenses: Object,
    budget_types: Object,
    goals: Object,
    current_expenses: Object,
    previous_expenses: Object,
    invested: Number,
    debt: Object,
});
provide("expenses", pageVariables.expenses);
provide("budget_types", ref(pageVariables.budget_types));
</script>
