<template>
    <section class="flex flex-col 2xl:mr-40 2xl:ml-40">
        <div class="mb-10 text-5xl 2xl:text-left text-center">
            {{ $t("goals.title").toLocaleLowerCase() }}
        </div>
        <Breadcrumb :model="breadcrumbs">
            <template #item="{ item }">
                <div>
                    <Link as="button" :href="item.route">{{ item.label }}</Link>
                </div>
            </template>
        </Breadcrumb>
        <div
            v-if="Object.keys(goals).length"
            v-for="goal in goals"
            class="group relative flex-col"
        >
            <LvProgressBar
                :value="getPercent(goal.end_goal, goal.contribution)"
                :color="'#008ba0'"
                class="bg-white mb-0.5 rounded-md h-2"
            ></LvProgressBar>
            <div
                class="md:flex gap-4 grid grid-cols-3 bg-[#F4F4F4] -mb-4 p-3 rounded-md md:text-md text-sm"
            >
                <div class="flex flex-1 justify-center col-span-3 md:pl-10">
                    <div>
                        <Icon
                            :icon="goal.icon.iconify_name"
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
import LvProgressBar from "lightvue/progress-bar";
import { provide, ref } from "vue";
import { Link } from "@inertiajs/vue3";
import { Breadcrumb } from "primevue";

let pageVariables = defineProps({
    goals: Object,
    detailsTab: Object,
    breadcrumbs: Object
});

provide("translate", "goals");
const items = ref([{ label: "Home", route: "/" }, { label: "Goal" }]);

function getPercent(fullSum = 0, sum = 0) {
    return Number(((sum / fullSum) * 100).toFixed());
}
</script>
