<template>
    <WhenVisible :data="lineChartItems">
        <template #fallback>
            <div>Loading...</div>
        </template>
        <div class="gap-4 grid grid-cols-3">
            <div class="col-span-2 w-full">
                <h1 class="mt-2 mb-8 px-6 text-2xl">
                    {{ $t("statistics.current_budget_allocation") }}
                </h1>
                <Toolbar>
                    <template #start>
                        <div class="flex justify-center">
                            <Button
                                type="button"
                                @click="toggle($event, 'lineCharts')"
                            >
                                <Icon icon="mdi:chart-line" class="size-6" />
                            </Button>
                            <Menu
                                ref="lineCharts"
                                :model="lineChartItems"
                                :popup="true"
                            />
                        </div>
                    </template>

                    <template #center>
                        <DatePicker
                            v-model="dates"
                            showIcon
                            fluid
                            iconDisplay="input"
                            dateFormat="yy-mm-dd"
                            view="month"
                            selectionMode="range"
                            :manualInput="false"
                        />
                    </template>

                    <template #end>
                        <div>generate button</div>
                    </template>
                </Toolbar>
                <LineGraph></LineGraph>
            </div>
            <div class="px-6 border-gray-200 border-l-2 w-full">
                <h1 class="mt-2 text-2xl">
                    {{ $t("statistics.current_budget_allocation") }}
                </h1>
                <PieChart></PieChart>
            </div>
        </div>
    </WhenVisible>
</template>

<script setup>
import { ref, watch, inject } from "vue";
import LineGraph from "./Statistics/LineGraph.vue";
import PieChart from "./Statistics/PieChart.vue";
import { Toolbar, Menu, Button, DatePicker } from "primevue";
import { router, WhenVisible } from "@inertiajs/vue3";

let dates = ref([]);
const lineCharts = ref();
const startDate = ref();
const endDate = ref();
const budgetTypes = inject("budgetTypes");

watch(dates, (newDate) => {
    if (newDate[1]) {
        startDate.value = newDate[0].toLocaleDateString("lt-LT");
        endDate.value = newDate[1].toLocaleDateString("lt-LT");
    }
});

const lineChartItems = [
    {
        label: "All",
        command: () =>
            router.get(route("profile.statistics"), {
                typeId: budgetTypes.map((type) => type.id),
                chartType: "line",
                startDate: startDate.value,
                endDate: endDate.value,
            }),
    },
    ...budgetTypes.map((type) => ({
        label: type.name,
        command: () =>
            router.get(route("profile.statistics"), {
                typeId: type.id,
                chartType: "line",
                startDate: startDate.value,
                endDate: endDate.value,
            }),
    })),
];

// const pieChartItems = [
//     {
//         label: "All",
//         command: () =>
//             router.get(route("profile.statistics"), {
//                 typeId: budgetTypes.map((type) => type.id),
//                 startDate: startDate.value,
//                 endDate: endDate.value,
//             }),
//     },
//     ...budgetTypes.map((type) => ({
//         label: type.name,
//         command: () =>
//             router.get(route("profile.statistics"), {
//                 typeId: type.id,
//                 startDate: startDate.value,
//                 endDate: endDate.value,
//             }),
//     })),
// ];

const toggle = (event, chart) => {
    switch (chart) {
        case "lineCharts":
            lineCharts.value.toggle(event);
            break;
        case "pie":
            pie.value.toggle(event);
            break;
    }
};
</script>
