<template>
    <div class="h-[30em]">
        <v-chart :option="chartOption" autoresize />
    </div>
</template>

<script setup>
import { ref } from "vue";
import { use } from "echarts/core";
import { CanvasRenderer } from "echarts/renderers";
import { PieChart } from "echarts/charts";
import {
    TooltipComponent,
    LegendComponent,
} from "echarts/components";
import VChart from "vue-echarts";

use([
    CanvasRenderer,
    PieChart,
    TooltipComponent,
    LegendComponent,
]);

// Chart options
const chartOption = ref({
    tooltip: {
        trigger: "item"
    },
    legend: {
        orient: "horizontal",
        bottom: "0"
    },
    series: [
        {
            name: "Access Source",
            type: "pie",
            radius: "50%",
            data: [
                { value: 1048, name: "Search Engine" },
                { value: 735, name: "Direct" },
                { value: 580, name: "Email" },
                { value: 484, name: "Union Ads" },
                { value: 300, name: "Video Ads" }
            ],
            label: {
                show: false
            },
            emphasis: {
                itemStyle: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: "rgba(0, 0, 0, 0.5)"
                }
            }
        }
    ]
});
</script>
