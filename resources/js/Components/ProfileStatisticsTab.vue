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
                        <div class="flex space-x-2">
                            <DatePicker
                                v-model="dates"
                                showIcon
                                fluid
                                iconDisplay="input"
                                :dateFormat="mode.dateFormat"
                                :view="mode.view"
                                :selectionMode="mode.selectionMode"
                                :manualInput="false"
                            />
                            <BlockUI :blocked="blocked">
                                <DatePicker
                                    v-if="mode.visible"
                                    v-model="compareDate"
                                    showIcon
                                    fluid
                                    iconDisplay="input"
                                    dateFormat="yy"
                                    view="year"
                                    selectionMode="single"
                                    class="w-[8em]"
                                />
                            </BlockUI>
                        </div>
                    </template>

                    <template #end>
                        <div>Compare modes:</div>
                        <Divider layout="vertical" />
                        <div class="flex space-x-2">
                            <div class="flex-1">
                                <input
                                    @input="changeMode('none')"
                                    type="radio"
                                    id="none"
                                    name="mode"
                                    value="none"
                                    class="sr-only peer/none"
                                    checked
                                />
                                <label
                                    for="none"
                                    class="inline-flex justify-between items-center bg-white hover:bg-gray-100 p-2 border border-gray-200 peer-checked/none:border-blue-600 rounded-lg w-full text-gray-500 hover:text-gray-600 peer-checked/none:text-blue-600 cursor-pointer"
                                    >None</label
                                >
                            </div>
                            <!-- TODO: This one is fucked, will need to look into it. Formating breaks when swaping between modes -->
                            <!-- <div class="flex-1">
                                <input
                                    @input="changeMode('year')"
                                    type="radio"
                                    id="by_year"
                                    name="mode"
                                    value="by_year"
                                    class="sr-only peer/by_year"
                                />
                                <label
                                    for="by_year"
                                    class="inline-flex justify-between items-center bg-white hover:bg-gray-100 p-2 border border-gray-200 peer-checked/by_year:border-blue-600 rounded-lg w-full text-gray-500 hover:text-gray-600 peer-checked/by_year:text-blue-600 cursor-pointer"
                                    >Yearly</label
                                >
                            </div> -->
                            <div class="flex-1">
                                <input
                                    @input="changeMode('month')"
                                    type="radio"
                                    id="by_month"
                                    name="mode"
                                    value="by_month"
                                    class="sr-only peer/by_month"
                                />
                                <label
                                    for="by_month"
                                    class="inline-flex justify-between items-center bg-white hover:bg-gray-100 p-2 border border-gray-200 peer-checked/by_month:border-blue-600 rounded-lg w-full text-gray-500 hover:text-gray-600 peer-checked/by_month:text-blue-600 cursor-pointer"
                                    >Monthly</label
                                >
                            </div>
                            <div class="flex-1">
                                <input
                                    @input="changeMode('day')"
                                    type="radio"
                                    id="by_day"
                                    name="mode"
                                    value="by_day"
                                    class="sr-only peer/by_day"
                                />
                                <label
                                    for="by_day"
                                    class="inline-flex justify-between items-center bg-white hover:bg-gray-100 p-2 border border-gray-200 peer-checked/by_day:border-blue-600 rounded-lg w-full text-gray-500 hover:text-gray-600 peer-checked/by_day:text-blue-600 cursor-pointer"
                                    >Daily</label
                                >
                            </div>
                        </div>
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
import { Toolbar, Menu, Button, DatePicker, Divider, BlockUI } from "primevue";
import { router, WhenVisible } from "@inertiajs/vue3";

const dates = ref();
const lineCharts = ref();
const startDate = ref();
const endDate = ref();
const budgetTypes = inject("budgetTypes");
const mode = ref({
    view: "month",
    selectionMode: "range",
    visible: false,
    dateFormat: "yy-mm-dd",
    mode: "none",
});
const compareDate = ref();
const blocked = ref(true);

watch(dates, (newDate) => {
    if (newDate[1]) {
        blocked.value = false;
        startDate.value = newDate[0].toLocaleDateString("lt-LT");
        endDate.value = newDate[1].toLocaleDateString("lt-LT");
    }
});

const lineChartItems = [
    {
        label: "All",
        command: () =>
            router.get(route("profile.statistics"), {
                typeIds: budgetTypes.map((type) => type.id),
                chartType: "line",
                mode: mode.value.visible,
                startDate: startDate.value,
                endDate: endDate.value,
                compareDate: mode.value.visible
                    ? compareDate.value.toLocaleDateString("lt-LT")
                    : "",
            }),
    },
    ...budgetTypes.map((type) => ({
        label: type.name,
        command: () =>
            router.get(route("profile.statistics"), {
                typeIds: type.id,
                chartType: "line",
                mode: mode.value.visible,
                startDate: startDate.value,
                endDate: endDate.value,
                compareDate: mode.value.visible
                    ? compareDate.value.toLocaleDateString("lt-LT")
                    : "",
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

const changeMode = (newMode) => {
    switch (newMode) {
        // case "year":
        //     mode.value = {
        //         view: "year",
        //         selectionMode: "single",
        //         visible: true,
        //         dateFormat: "yy",
        //     };
        //     break;
        case "month":
            mode.value = {
                view: "month",
                selectionMode: "range",
                visible: true,
                dateFormat: "yy-mm",
                mode: true,
            };
            break;
        case "day":
            mode.value = {
                selectionMode: "range",
                visible: true,
                dateFormat: "yy-mm-dd",
                mode: true,
            };
            break;
        default:
            mode.value = mode.value = {
                view: "month",
                selectionMode: "range",
                visible: false,
                dateFormat: "yy-mm-dd",
                mode: false,
            };
            break;
    }
};
</script>
