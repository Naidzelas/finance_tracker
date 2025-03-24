<template>
    <div v-if="Object.keys(goal_data).length">
        <div v-for="goal in goal_data" class="group relative shadow-md mb-2">
            <EditOrDelete
                :action="{
                    edit: 'goal.edit',
                    delete: 'goal.destroy',
                    redirect: '/',
                }"
                :id="goal.id"
            ></EditOrDelete>
            <LvProgressBar
                :value="getPercent(goal.end_goal, goal.contribution)"
                :color="'#008ba0'"
                class="bg-gray-100 mt-px mb-0.5 border rounded-full w-full h-1"
            ></LvProgressBar>
            <div
                class="flex place-items-center bg-[white] p-4 border-6 rounded text-center"
            >
                <div class="flex flex-auto justify-center">
                    <Icon :icon="goal.icon.iconify_name" class="size-10"></Icon>
                </div>
                <div class="w-96 font-semibold text-3xl">{{ goal.name }}</div>
                <div class="group-hover:invisible flex-auto text-3xl">
                    {{ goal.end_goal }}
                </div>
            </div>
        </div>
    </div>
    <div
        v-else
        class="bg-[white] pt-6 pb-6 border-6 rounded font-bold text-2xl text-center"
    >
        No data
    </div>
</template>

<script setup>
import EditOrDelete from "./EditOrDelete.vue";
import LvProgressBar from "lightvue/progress-bar";
defineProps({ goal_data: Object });

function getPercent(fullSum = 0, sum = 0) {
    return Number(((sum / fullSum) * 100).toFixed());
}
</script>
