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
                <BudgetInfo></BudgetInfo>
                <div class="text-left text-2xl mb-6 mt-6">upcoming news</div>
                <NewsInfo></NewsInfo>
                <div class="text-left text-2xl mb-6 mt-6">goals</div>
                <GoalInfo></GoalInfo>
            </div>
        </div>
    </section>
</template>
<script setup>
import ExpenseList from "../Components/MonthExpenseList.vue";
import BasicInfo from "../Components/BasicInfoDisplay.vue";
import BudgetInfo from "../Components/BudgetDisplay.vue";
import NewsInfo from "../Components/NewsDisplay.vue";
import GoalInfo from "../Components/GoalDisplay.vue";
</script>
