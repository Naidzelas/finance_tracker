<template>
    <section class="flex flex-col 2xl:mr-40 2xl:ml-40">
        <AppHeader
            :breadcrumbs="items"
            title="Goals"
            subtitle="Track your financial goals"
            class="mb-10"
        ></AppHeader>
        <div
            v-if="Object.keys(goals).length"
            v-for="goal in goals"
            class="group relative flex-col"
        >
            <LvProgressBar
                :value="getPercent(goal.end_goal, goal.contribution)"
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
                            :icon="goal.iconify_name"
                            class="size-8 md:size-12"
                        ></Icon>
                    </div>
                </div>
                <div class="flex flex-col flex-1 text-center">
                    <div class="font-bold">{{ $t("goals.need") }}</div>
                    <div>{{ goal.end_goal }}</div>
                </div>
                <div class="flex flex-col flex-1 text-center">
                    <div class="font-bold">{{ $t("goals.monthly") }}</div>
                    <div>€ {{ goal.contribution }}</div>
                </div>
                <div class="flex flex-col flex-1 text-center">
                    <div class="font-bold">
                        {{ $t("goals.months_to_complete") }}
                    </div>
                    <div>
                        {{ (goal.end_goal / goal.contribution).toFixed(1) }}
                    </div>
                </div>
                <div class="flex flex-col flex-1 text-center">
                    <div class="font-bold">{{ $t("goals.saved") }}</div>
                    <div>{{ goal.deposit ?? 0 }}</div>
                </div>
                <Button
                    rounded
                    icon="pi pi-trash"
                    severity="danger"
                    class="md:mr-4"
                    :outlined="true"
                    @click="deleteGoal(goal.id)"
                ></Button>
            </div>
            <DetailsDisplay
                :detailsTab="detailsTab"
                :id="goal.id"
            ></DetailsDisplay>
        </div>
        <NoData v-else></NoData>
    </section>
</template>

<script setup>
import DetailsDisplay from "../Components/DetailsDisplay.vue";
import EditOrDelete from "../Components/EditOrDelete.vue";
import NoData from "../Components/NoData.vue";
import LvProgressBar from "lightvue/progress-bar";
import { provide, ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import { Breadcrumb, Button } from "primevue";
import AppHeader from "../Components/AppHeader.vue";

let pageVariables = defineProps({
    goals: Object,
    detailsTab: Object,
    breadcrumbs: Object,
});

provide("translate", "goals");
const items = ref([{ label: "Home", route: "/" }, { label: "Goal" }]);

function getPercent(fullSum = 0, sum = 0) {
    return Number(((sum / fullSum) * 100).toFixed());
}

function deleteGoal(id) {
    router.delete(route("goal.destroy", id), {
        onSuccess: () => {
            router.visit(route("goal.index"), { only: [] });
        },
        onError: (errors) => {
            console.error("Delete failed:", errors);
        },
    });
}
</script>
