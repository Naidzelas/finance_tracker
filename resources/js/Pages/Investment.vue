<template>
    <section class="flex flex-col 2xl:mr-40 2xl:ml-40">
        <div class="mb-10 text-5xl 2xl:text-left text-center">
            {{ $t("investments.title") }}
        </div>
        <Breadcrumbs :breadcrumbs="breadcrumbs"></Breadcrumbs>
        <div
            v-if="Object.keys(investments).length"
            v-for="investment in investments"
            class="group relative flex-col"
        >
            <div
                class="md:flex gap-4 grid grid-cols-3 bg-[#F4F4F4] -mb-4 p-3 rounded-md md:text-md text-sm"
            >
                <div class="flex flex-1 justify-center col-span-3 md:pl-10">
                    <div>
                        <Icon
                            :icon="investment.iconify_name"
                            class="size-8 md:size-12"
                        ></Icon>
                    </div>
                </div>
                <div class="flex flex-col flex-1 text-center">
                    <div class="font-bold">
                        {{ $t("investments.investment_name") }}
                    </div>
                    <div>{{ investment.symbol }}</div>
                </div>
                <div class="flex flex-col flex-1 text-center">
                    <div class="font-bold">
                        {{ $t("investments.invested") }}
                    </div>
                    <div>{{ investment.invested ?? 0 }} €</div>
                </div>
                <div class="flex flex-col flex-1 text-center">
                    <div class="font-bold">
                        {{ $t("investments.price_loss_percent") }}
                    </div>
                    <div v-if="investment.is_green">
                        {{ investment.profit_percent }}
                    </div>
                    <div v-else>{{ -Math.abs(investment.profit_percent) }}</div>
                </div>
                <div class="flex flex-col flex-1 text-center">
                    <div class="font-bold">
                        {{ $t("investments.price_loss") }}
                    </div>
                    <div v-if="investment.is_green">
                        {{ investment.profit ?? 0 }} €
                    </div>
                    <div v-else>{{ -Math.abs(investment.profit) ?? 0 }} €</div>
                </div>
                <div class="flex flex-col flex-1 text-center">
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
import Breadcrumbs from "../Components/Breadcrumbs.vue";
import { provide } from "vue";

let pageVariables = defineProps({
    investments: Object,
    detailsTab: Object,
    breadcrumbs: Object,
});

provide("translate", "investments");
</script>
