<template>
    <WhenVisible :data="items">
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
                                :model="items"
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
import { ref, watch } from "vue";
import LineGraph from "./Statistics/LineGraph.vue";
import PieChart from "./Statistics/PieChart.vue";
import { Toolbar, Menu, Button, DatePicker } from "primevue";
import { router, WhenVisible } from "@inertiajs/vue3";

let dates = ref([]);
const lineCharts = ref();
const startDate = ref();
const endDate = ref();

watch(dates, (newDate) => {
    if (newDate[1]) {
        startDate.value = newDate[0].toLocaleDateString("lt-LT");
        endDate.value = newDate[1].toLocaleDateString("lt-LT");
    }
});

const items = [
    {
        label: "Debt",
        command: () =>
            router.get(
                route("profile.statistics"),
                {
                    typeId: 108,
                    startDate: startDate.value,
                    endDate: endDate.value,
                },
                // { replace: true, only: ["chartData"] }
            ),
    },
    { label: "Investments" },
    { label: "Budget" },
    { label: "Goal" },
];

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
