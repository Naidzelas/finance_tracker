<template>
    <div class="h-[30em]">
        <!-- {{ chartData.xAxis }} {{ chartData.yAxis }} -->
        <v-chart :option="chartOption" autoresize />
    </div>
</template>

<script setup>
import { ref, inject } from "vue";
import { use } from "echarts/core";
import { CanvasRenderer } from "echarts/renderers";
import { LineChart } from "echarts/charts";
import {
    GridComponent,
    TooltipComponent,
    LegendComponent,
} from "echarts/components";
import VChart from "vue-echarts";

const chartData = inject("chartData") ?? { xAxis: [], yAxis: [] };

use([
    CanvasRenderer,
    LineChart,
    GridComponent,
    TooltipComponent,
    LegendComponent,
]);

// Chart options
const chartOption = ref({
    xAxis: {
        type: "category",
        data: chartData.xAxis,
    },
    yAxis: {
        type: "value",
    },
    series: [
        {
            type: "line",
            data: chartData.yAxis,
        },
    ],
});
</script>
