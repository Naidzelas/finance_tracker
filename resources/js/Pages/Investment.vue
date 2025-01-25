<template>
    <section class="flex flex-col mr-40 ml-40">
        <div class="mb-10 text-5xl">current investments</div>
        <!-- <pre>
            {{ investments }}

        </pre> -->
        <div
            v-if="Object.keys(investments).length"
            v-for="investment in investments"
            class="flex-col"
        >
            <div class="rounded-md bg-[#F4F4F4] flex p-3 -mb-4">
                <div class="flex flex-1 pl-10">
                    <div>
                        <Icon
                            :icon="investment.investment_icon.iconify_name"
                            class="size-12"
                        ></Icon>
                    </div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">Name</div>
                    <div>{{ investment.symbol }}</div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">Invested</div>
                    <div>€</div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">P/L %</div>
                    <div v-if="investment.is_green">
                        {{ investment.profit_percent }}
                    </div>
                    <div v-else>{{ -Math.abs(investment.profit_percent) }}</div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">P/L</div>
                    <div></div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">Value</div>
                    <div></div>
                </div>
            </div>
            <DetailsDisplay
                :detailsTab="detailsTab"
                :id="investment.id"
            ></DetailsDisplay>
        </div>
        <NoData v-else></NoData>
    </section>
</template>

<script setup>
import DetailsDisplay from "../Components/DetailsDisplay.vue";
import NoData from "../Components/NoData.vue";
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
