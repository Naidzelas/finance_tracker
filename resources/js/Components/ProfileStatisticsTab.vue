<template>
    <div class="w-full h-[30em]">
        <v-chart :option="chartOption" autoresize />
    </div>
</template>

<script setup>
import { ref } from "vue";
import { use } from "echarts/core";
import { CanvasRenderer } from "echarts/renderers";
import { LineChart } from "echarts/charts";
import { GridComponent, TooltipComponent, LegendComponent } from "echarts/components";
import VChart from "vue-echarts";

// Register ECharts components
use([CanvasRenderer, LineChart, GridComponent, TooltipComponent, LegendComponent]);

// Chart options
const chartOption = ref({
    xAxis: {
        type: "category",
        data: ["A", "B", "C", "D", "E"],
    },
    yAxis: {
        type: "value",
    },
    series: [
        {
            type: "line",
            data: [120, 200, 150, 80, 70],
        },
    ],
});
</script>