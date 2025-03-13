<template>
    <section class="flex flex-col mr-40 ml-40">
        <div class="mb-10 text-5xl">{{ $t("investments.title") }}</div>
        <div
            v-if="Object.keys(investments).length"
            v-for="investment in investments"
            class="group relative flex-col"
        >
            <div class="flex bg-[#F4F4F4] -mb-4 p-3 rounded-md">
                <div class="flex flex-1 pl-10">
                    <div>
                        <Icon
                            :icon="investment.investment_icon.iconify_name"
                            class="size-12"
                        ></Icon>
                    </div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">
                        {{ $t("investments.investment_name") }}
                    </div>
                    <div>{{ investment.symbol }}</div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">
                        {{ $t("investments.invested") }}
                    </div>
                    <div>{{ investment.invested ?? 0 }} €</div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">
                        {{ $t("investments.price_loss_percent") }}
                    </div>
                    <div v-if="investment.is_green">
                        {{ investment.profit_percent }}
                    </div>
                    <div v-else>{{ -Math.abs(investment.profit_percent) }}</div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">
                        {{ $t("investments.price_loss") }}
                    </div>
                    <div v-if="investment.is_green">
                        {{ investment.profit ?? 0 }} €
                    </div>
                    <div v-else>{{ -Math.abs(investment.profit) ?? 0 }} €</div>
                </div>
                <div class="flex flex-col flex-1">
                    <div class="font-bold">{{ $t("investments.value") }}</div>
                    <div>{{ investment.value ?? 0 }} €</div>
                </div>
            </div>
            <DetailsDisplay
                :detailsTab="detailsTab"
                :id="investment.id"
            ></DetailsDisplay>
            <EditOrDelete
                :action="{
                    edit: 'investment.edit',
                    delete: 'investment.destroy',
                    redirect: '/investment',
                }"
                :id="investment.id"
            ></EditOrDelete>
        </div>
        <NoData v-else></NoData>
    </section>
</template>

<script setup>
import DetailsDisplay from "../Components/DetailsDisplay.vue";
import NoData from "../Components/NoData.vue";
import EditOrDelete from "../Components/EditOrDelete.vue";
import { provide } from "vue";

let pageVariables = defineProps({
    investments: Object,
    detailsTab: Object,
});

provide("translate", "investments");
</script>
