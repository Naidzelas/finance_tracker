<template>
    <div class="dark:bg-surface-950 px-6 md:px-12 lg:px-20 py-8 h-full">
        <div
            class="flex flex-col gap-8 bg-surface-0 dark:bg-surface-900 shadow-lg p-8 rounded-2xl h-full"
        >
            <div class="flex items-center gap-4">
                <div
                    class="flex justify-center items-center bg-cyan-500 dark:bg-cyan-600 rounded-full w-8 h-8"
                >
                    <i
                        class="text-surface-0 !text-base !leading-none pi pi-dollar"
                    />
                </div>

                <div class="flex flex-col gap-1">
                    <span
                        class="text-md text-surface-900 dark:text-surface-0 text-xl leading-tight"
                        >{{ $t("user.goal") }}</span
                    >
                    <span
                        class="text-surface-600 dark:text-surface-200 text-sm leading-tight"
                        >{{ $t("user.goal_sub_text") }}</span
                    >
                </div>
            </div>

            <div
                v-for="(goal, index) in goal_data"
                :key="index"
                class="flex flex-col gap-4"
            >
                <div class="flex flex-col gap-2">
                    <div class="flex justify-between items-center gap-4">
                        <div class="flex items-center gap-2">
                            <Icon
                                :icon="goal.iconify_name"
                                class="size-4"
                            ></Icon>
                            <span
                                class="font-medium text-surface-900 dark:text-surface-0 leading-tight"
                                >{{ goal.name }}</span
                            >
                        </div>

                        <span
                            class="text-surface-700 dark:text-surface-300 leading-tight"
                            >{{
                                getPercent(goal.end_goal, goal.contribution)
                            }}%</span
                        >
                    </div>
                    <ProgressBar
                        :value="getPercent(goal.end_goal, goal.contribution)"
                        class="rounded !h-2"
                        :pt="{
                            label: { class: '!hidden' },
                        }"
                    />
                </div>
            </div>
            <Button :outlined="true" @click="addGoal">
                <i class="pi pi-plus"></i><span>Add</span>
            </Button>
        </div>
    </div>
</template>

<script setup>
import { Button, ProgressBar } from "primevue";
import { router } from "@inertiajs/vue3";
import EditOrDelete from "./EditOrDelete.vue";
import LvProgressBar from "lightvue/progress-bar";
defineProps({ goal_data: Object });

function getPercent(fullSum = 0, sum = 0) {
    return Number(((sum / fullSum) * 100).toFixed());
}

function addGoal() {
    router.get(route("goal.create"));
}
</script>

<!-- <div v-if="Object.keys(goal_data).length">
        <div v-for="goal in goal_data" class="group relative shadow-md mb-2">
            <EditOrDelete
                :action="{
                    edit: 'goal.edit',
                    delete: 'goal.destroy',
                    redirect: '/',
                }"
                :id="goal.id"
            ></EditOrDelete>
            <LvProgressBar
                :value="getPercent(goal.end_goal, goal.contribution)"
                :color="'#008ba0'"
                class="bg-gray-100 mt-px mb-0.5 border rounded-full w-full h-1"
            ></LvProgressBar>
            <div
                class="flex place-items-center bg-[white] p-4 border-6 rounded text-center"
            >
                <div class="flex flex-auto justify-center">
                    <Icon :icon="goal.iconify_name" class="size-10"></Icon>
                </div>
                <div class="w-96 font-semibold text-3xl">{{ goal.name }}</div>
                <div class="group-hover:invisible flex-auto text-3xl">
                    {{ goal.end_goal }}
                </div>
            </div>
        </div>
    </div> -->
<!-- <div
        v-else
        class="bg-[white] pt-6 pb-6 border-6 rounded font-bold text-2xl text-center"
    >
        No data
    </div> -->
<!-- </template> -->
