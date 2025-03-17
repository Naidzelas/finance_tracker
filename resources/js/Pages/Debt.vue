<template>
    <section class="flex flex-col 2xl:mr-40 2xl:ml-40">
        <div class="mb-10 text-5xl 2xl:text-left text-center">
            {{ $t("debts.title").toLocaleLowerCase() }}
        </div>
        <div
            v-if="Object.keys(debts).length"
            v-for="debt in debts"
            class="group relative flex-col"
        >
            <LvProgressBar
                :value="getPercent(debt.loan_final_amount, debt.paid)"
                :color="'#008ba0'"
                class="bg-white mb-0.5 rounded-md h-2"
            ></LvProgressBar>

            <div class="md:flex gap-4 grid grid-cols-3 bg-[#F4F4F4] -mb-4 p-3 rounded-md md:text-md text-sm">
                <div class="flex flex-1 justify-center col-span-3 md:pl-10">
                    <div>
                        <Icon
                            :icon="debt.icon.iconify_name"
                            class="size-8 md:size-12"
                        ></Icon>
                    </div>
                </div>
                <div class="flex flex-col flex-1 text-center">
                    <div class="font-bold">{{ $t("debts.name") }}</div>
                    <div>{{ debt.name }}</div>
                </div>
                <div class="flex flex-col flex-1 text-center">
                    <div class="font-bold">{{ $t("debts.loan_size") }}</div>
                    <div>{{ debt.loan_size }}</div>
                </div>
                <div class="flex flex-col flex-1 text-center">
                    <div class="font-bold">
                        {{ $t("debts.monthly_payment") }}
                    </div>
                    <div>{{ debt.monthly_payment }}</div>
                </div>
                <div class="flex flex-col flex-1 text-center">
                    <div class="font-bold">{{ $t("debts.payment_date") }}</div>
                    <div>{{ debt.debt_detail.payment_date }}</div>
                </div>
                <div class="flex flex-col flex-1 text-center">
                    <div class="font-bold">{{ $t("debts.interest_rate") }}</div>
                    <div>{{ debt.interest_rate }}</div>
                </div>
                <div class="group-hover:invisible flex flex-col flex-1 text-center">
                    <div class="font-bold">{{ $t("debts.loan_payed") }}</div>
                    <div>
                        {{
                            typeof debt.paid !== 'undefined' ? debt.paid.toFixed(2) : 0
                             + " / " + debt.loan_size ??
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
import LvProgressBar from "lightvue/progress-bar";
import { provide } from "vue";

let pageVariables = defineProps({
    debts: Object,
    detailsTab: Object,
});

provide("translate", 'debts');

function getPercent(fullSum = 0, sum = 0) {
    return Number(((sum / fullSum) * 100).toFixed());
}
</script>
