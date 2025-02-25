<template>
    <section class="flex flex-col mr-40 ml-40">
        <div class="mb-10 text-5xl">current goals</div>
        <div
            v-if="Object.keys(goals).length"
            v-for="goal in goals"
            class="group relative flex-col"
        >
            <div class="bg-[white] mb-0.5 rounded-full">
                <div
                    class="bg-gradient-to-r from-black to-[#606060] mb-1 rounded-full w-0 h-2 transition-all duration-700 transform"
                    :class="percent(goal)"
                ></div>
            </div>
            <div class="flex bg-[#F4F4F4] -mb-4 p-3 rounded-md">
                <div class="flex flex-1 pl-10">
                    <div>
                        <Icon
                            :icon="goal.icon.iconify_name"
                            class="size-12"
                        ></Icon>
                    </div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">Need</div>
                    <div>{{ goal.end_goal }}</div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">Monthly</div>
                    <div>€ {{ goal.contribution }}</div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">Months to complete</div>
                    <div>
                        {{ (goal.end_goal / goal.contribution).toFixed(1) }}
                    </div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">Saved</div>
                    <div>{{ goal.deposit }}</div>
                </div>
            </div>
            <DetailsDisplay
                :detailsTab="detailsTab"
                :id="goal.id"
            ></DetailsDisplay>
            <EditOrDelete
                :action="{
                    edit: 'goal.edit',
                    delete: 'goal.destroy',
                    redirect: '/goal',
                }"
                :id="goal.id"
            ></EditOrDelete>
        </div>
        <NoData v-else></NoData>
    </section>
</template>

<script setup>
import DetailsDisplay from "../Components/DetailsDisplay.vue";
import EditOrDelete from "../Components/EditOrDelete.vue";
import NoData from "../Components/NoData.vue";
import { computed } from "vue";
let pageVariables = defineProps({
    goals: Object,
    detailsTab: Object,
});

let percent = computed(() => {
    return (goal) => {
        return "w-[" + getPercent(goal.end_goal, goal.deposit) + "%]";
    };
});

function getPercent(fullSum = 0, sum = 0) {
    return (sum / fullSum) * 100 > 100
        ? 100
        : ((sum / fullSum) * 100).toFixed();
}
</script>
