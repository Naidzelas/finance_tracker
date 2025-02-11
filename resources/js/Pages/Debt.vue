<template>
    <section class="flex flex-col mr-40 ml-40">
        <div class="mb-10 text-5xl">current debts</div>
        <div
            v-if="Object.keys(debts).length"
            v-for="debt in debts"
            class="group relative flex-col"
        >
            <div class="bg-[white] mb-0.5 rounded-full">
                <div
                    class="bg-gradient-to-r from-black to-[#606060] mb-1 rounded-full w-0 h-2 transition-all duration-700 transform"
                ></div>
            </div>
            <div class="flex bg-[#F4F4F4] -mb-4 p-3 rounded-md">
                <div class="flex flex-1 pl-10">
                    <div>
                        <Icon
                            :icon="debt.icon.iconify_name"
                            class="size-12"
                        ></Icon>
                    </div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">Name</div>
                    <div>{{ debt.name }}</div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">Loan Size</div>
                    <div>{{ debt.loan_size }}</div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">Payment</div>
                    <div>{{ debt.monthly_payment }}</div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">Payment date</div>
                    <div>{{ debt.debt_detail.payment_date }}</div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">Interest Rate</div>
                    <div>{{ debt.interest_rate }}</div>
                </div>
                <div class="group-hover:invisible flex flex-col flex-1">
                    <div class="font-bold">Payment left</div>
                    <div>
                        {{
                            (debt.loan_size / debt.monthly_payment).toFixed() ??
                            "N/A"
                        }}
                    </div>
                </div>
            </div>
            <DetailsDisplay
                :detailsTab="detailsTab"
                :id="debt.id"
            ></DetailsDisplay>
            <EditOrDelete
                :action="{
                    edit: 'debt.edit',
                    delete: 'debt.destroy',
                    redirect: '/debt',
                }"
                :id="debt.id"
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
    debts: Object,
    detailsTab: Object,
});

let percent = computed(() => {});

function getPercent() {}
</script>
