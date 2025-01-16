<template>
    <section class="flex flex-col mr-40 ml-40">
        <div class="mb-10 text-5xl">current goals</div>
        <div v-for="goal in goals" class="flex-col">
            <div class="rounded-full mb-0.5 bg-[white]">
                <div
                    class="rounded-full bg-gradient-to-r from-black to-[#606060] h-2 mb-1 w-0 transform transition-all duration-700"
                    :class="percent(goal)"
                ></div>
            </div>
            <div class="rounded-md bg-[#F4F4F4] flex p-3 -mb-4">
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
                    <div>{{ goal.end_goal / goal.contribution }}</div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">Saved</div>
                    <div> {{ goal.deposit }}</div>
                </div>
            </div>
            <DetailsDisplay
                :detailsTab="detailsTab"
                :id="goal.id"
            ></DetailsDisplay>
        </div>
    </section>
</template>

<script setup>
import DetailsDisplay from "../Components/DetailsDisplay.vue";
import { computed } from "vue";
let pageVariables = defineProps({
    goals: Object,
    detailsTab: Object,
});

let percent = computed(() =>{
    return (goal) => {
        return 'w-['+getPercent(goal.end_goal, goal.deposit)+'%]';
    }
})

function getPercent(fullSum = 0, sum = 0){
    return (sum / fullSum * 100) > 100 ? 100 : (sum / fullSum * 100).toFixed();
}
</script>
