<template>
    <section class="flex flex-col mr-40 ml-40">
        <div class="mb-10 text-5xl">current investments</div>
        {{ investments }}
        <div v-for="investment in investments" class="flex-col">
            <div class="rounded-md bg-[#F4F4F4] flex p-3 -mb-4">
                <div class="flex flex-1 pl-10">
                    <div>
                        <Icon
                            icon="none"
                            class="size-12"
                        ></Icon>
                    </div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">Name</div>
                    <div></div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">Invested</div>
                    <div>€ </div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">P/L %</div>
                    <div></div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">P/L</div>
                    <div> </div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">Value</div>
                    <div></div>
                </div>
            </div>
            <DetailsDisplay
                 :detailsTab="detailsTab"
            ></DetailsDisplay>
        </div>
    </section>
</template>

<script setup>
import DetailsDisplay from "../Components/DetailsDisplay.vue";
import { computed } from "vue";
let pageVariables = defineProps({
    investments: Object,
    detailsTab: Object,

});

// let percent = computed(() =>{
//     return (goal) => {
//         return 'w-['+getPercent(goal.end_goal, goal.deposit)+'%]';
//     }
// })

// function getPercent(fullSum = 0, sum = 0){
//     return (sum / fullSum * 100) > 100 ? 100 : (sum / fullSum * 100).toFixed();
// }
</script>
