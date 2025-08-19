<template>
    <section class="flex flex-col 2xl:mr-40 2xl:ml-40">
        <AppHeader
            :breadcrumbs="items"
            title="Investments"
            subtitle="Track your investments"
            class="mb-10"
        ></AppHeader>
        <div
            v-if="Object.keys(investments).length"
            v-for="investment in investments"
            class="group relative flex-col"
        >
            <LvProgressBar
                :value="getPercent(investment.value, investment.invested)"
                :color="'#008ba0'"
                :showValue="false"
                class="bg-white mb-0.5 rounded-md h-2"
            ></LvProgressBar>
            <div
                class="md:flex gap-4 grid grid-cols-3 bg-surface-0 shadow-lg -mb-4 p-3 rounded-md md:text-md text-sm"
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
                <Button
                    rounded
                    icon="pi pi-trash"
                    severity="danger"
                    class="md:mr-4"
                    :outlined="true"
                    @click="deleteInvestment(investment.id)"
                ></Button>
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
import LvProgressBar from "lightvue/progress-bar";
import { provide, ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import { Breadcrumb, Button } from "primevue";
import AppHeader from "../Components/AppHeader.vue";

let pageVariables = defineProps({
    investments: Object,
    detailsTab: Object,
    breadcrumbs: Object,
});

provide("translate", "investments");
const items = ref([{ label: "Home", route: "/" }, { label: "Investment" }]);

function getPercent(fullSum = 0, sum = 0) {
    return Number(((sum / fullSum) * 100).toFixed());
}

function deleteInvestment(id) {
    router.delete(route("investment.destroy", id), {
        onSuccess: () => {
            router.visit(route("investment.index"), { only: [] });
        },
        onError: (errors) => {
            console.error("Delete failed:", errors);
        },
    });
}
</script>
