<template>
    <div class="group relative p-4 w-full">
        <div v-if="item.budget_left > 0">
            <div class="group-hover:invisible flex flex-row">
                <div class="flex place-items-center basis-1/2">
                    <Icon :icon="item.icon.iconify_name" class="size-8"></Icon>
                </div>
                <div class="text-4xl text-right basis-1/2">
                    {{ item.budget_left.toFixed(2) }}
                </div>
            </div>
            <LvProgressBar
                :value="getPercent(item.amount, item.budget_left)"
                :color="'#008ba0'"
                class="group-hover:invisible bg-gray-100 mt-px mb-0.5 border rounded-full w-full h-2"
            ></LvProgressBar>
        </div>
        <div v-else class="text-red-600">
            <div class="group-hover:invisible flex flex-row">
                <div class="flex place-items-center basis-1/2">
                    <Icon :icon="item.icon.iconify_name" class="size-8"></Icon>
                </div>
                <Icon
                    icon="fluent-emoji-high-contrast:white-exclamation-mark"
                    class="top-2 right-0 absolute size-6"
                ></Icon>
                <div class="text-4xl text-right basis-1/2">
                    {{ item.budget_left.toFixed(2) }}
                </div>
            </div>
            <LvProgressBar
                :value="getPercent(item.amount, item.budget_left)"
                :color="'red'"
                class="group-hover:invisible bg-gray-100 mt-px mb-0.5 rounded-full w-full h-2"
            ></LvProgressBar>
        </div>
        <EditOrDelete
            :action="{
                edit: 'budget.edit',
                delete: 'budget.destroy',
                redirect: '/',
            }"
            :id="item.id"
        ></EditOrDelete>
    </div>
</template>

<script setup>
import EditOrDelete from "./EditOrDelete.vue";
import LvProgressBar from "lightvue/progress-bar";

defineProps({ item: Object });

function getPercent(fullSum = 0, sum = 0) {
    let percent = (sum / fullSum) * 100;
    if(percent > 0){
        return Number(percent.toFixed());
    }else{
        return Number(0);
    }
}
</script>
