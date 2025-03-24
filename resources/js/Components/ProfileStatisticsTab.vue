<template>
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
                        <Menu ref="lineCharts" :model="items" :popup="true" />
                    </div>
                </template>

                <template #center>
                    <Datepicker
                        v-model="date"
                        :format-locale="lt"
                        :enable-time-picker="false"
                        :format="format"
                        class="mt-1"
                    ></Datepicker>
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
</template>

<script setup>
import { ref } from "vue";
import LineGraph from "./Statistics/LineGraph.vue";
import PieChart from "./Statistics/PieChart.vue";
import { Toolbar, Menu, Button } from "primevue";
import Datepicker from "@vuepic/vue-datepicker";
import "../../css/custom-vue-datepicker.css";
import { lt } from "date-fns/locale";
let date = ref();
const lineCharts = ref();
const items = [
    { label: "Debt", icon: "pi pi-refresh" },
    { label: "Investments", icon: "pi pi-times" },
    { label: "Budget", icon: "pi pi-home" },
    { label: "Goal", icon: "pi pi-save" },
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

const format = (date) => {
    if (date) {
        return `${date.toLocaleDateString("lt-LT")}`;
    } else {
        return "Invalid date range";
    }
};
</script>
